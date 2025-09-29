<?php

namespace App\Http\Controllers\MMS;

use App\Http\Controllers\Controller;
use App\Models\MMS\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->tcode    =   'MMS2'; // harus diisi, karena akan menentukan menu aktif
    }

    public function index()
    {
        $packages = Package::all();
        return view('mms.packages.index', compact('packages'));
    }

    public function data(Request $request)
    {
        $packageId  =   $request->package_id;
        $mms        =   config('database.connections.mms.database');
        $today      =   Carbon::now()->format('Y-m-d');
        
        $packages   =   Package::with('memberships')->orderBy('id', 'desc');

        if ($packageId)
        {
            $packages->where('id', $packageId);
        }

        $searchParams = [
            'package_id'    =>  $packageId
        ];

        Session::put($this->tcode.'searchParams', $searchParams);

        return DataTables::of($packages)
                        ->addColumn('action', function($packages) {
                            $button = '<button title="'. ucfirst(__('detail')) .'" 
                                class="edit-button btn btn-xs btn-secondary mr-1" 
                                onclick="showEdit('. $packages->id .')">
                                <i class="fa fa-pen fa-fw fa-xs"></i>
                            </button>';

                            if (!$packages->memberships()->first())
                            {
                                $button .= '<button title="'. ucfirst(__('delete')) .'" 
                                    class="delete-button btn btn-xs btn-danger mr-1" 
                                    onclick="delete('. $packages->id .')">
                                    <i class="fa fa-trash fa-fw fa-xs"></i>
                                </button>';
                            }

                            return $button;
                        })
                        ->editColumn('price', function($packages) {
                            return number_format($packages->price, 0, ',', '.');
                        })
                        ->editColumn('discount', function($packages) {
                            return number_format($packages->discount, 0, ',', '.');
                        })
                        ->editColumn('created_at', function($packages) {
                            return Carbon::createFromFormat('Y-m-d H:i:s', $packages->created_at)->format('d/m/Y');
                        })
                        ->addIndexColumn()
                        ->make(true);
        
    }

    public function store(Request $request)
    {
        try
        {
            // dd($request->all());
            DB::connection('mms')->beginTransaction();
            request()->validate([
                'package_name' => 'required|string|max:100',
                'type' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
                'discount' => 'nullable|numeric|min:0|max:100',
                'duration_in_days' => 'required|integer|min:1',
            ]);

            $package = Package::where('package_name', $request->package_name)->first();

            if ($package)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  ucfirst(__('Paket '. $request->package_name.' telah terdaftar'))
                ], 200);
            }

            $package = Package::create([
                'package_name'      =>  $request->package_name,
                'type'              =>  $request->type,
                'description'       =>  preg_replace('/\s+/', ' ', trim($request->description)),
                'price'             =>  $request->price,
                'discount'          =>  $request->discount,
                'duration_in_days'  =>  $request->duration_in_days,
                'is_active'         =>  1,
                'created_by'        =>  Auth::user()->id,
                'created_at'        =>  Carbon::now(),
                'updated_by'        =>  Auth::user()->id,
                'updated_at'        =>  Carbon::now(),
            ]);

            DB::connection('mms')->commit();

            return response()->json([
                'success' => true,
                'message' => ucfirst(__('Paket '. $request->package_name.' berhasil didaftarkan')),
                'data' => $package,
            ]);
        } 
        catch (\Exception $e) 
        {
            DB::connection('mms')->rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error creating package: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getAllData()
    {
        try
        {
            $packages = Package::all();
            return response()->json([
                'success' => true,
                'message' => 'Packages retrieved successfully',
                'data' => $packages,
            ]);
        } 
        catch (\Exception $e) 
        {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getPackageById($id)
    {
        $package = Package::where('id', $id)->first();
        if ($package)
        {
            $discountPrice = 0;
            if ($package->discount > 0)
            {
                $discountPrice = $package->discount/100 * $package->price;
            }

            $totalPrice = $package->price - $discountPrice;
            $totalPrice =  number_format($totalPrice, 0, ',', '.');

            $data   =   [
                'id'                =>  $package->id,
                'package_name'      =>  $package->package_name,
                'type'              =>  $package->type,
                'description'       =>  $package->description,
                'total_price'       =>  $totalPrice,
                'price'             =>  number_format($package->price, 0, ',', '.'),
                'discount'          =>  $package->discount + 0,
                'discount_price'    =>  $discountPrice,
                'duration_in_days'  =>  $package->duration_in_days
            ];

            return response()->json([
                'success'   =>  true,
                'message'   =>  "Package found",
                'data'      =>  $data
            ]);
        }

        return response()->json([
            'success'   =>  false,
            'message'   =>  "Package not found"
        ]);
    }

    public function update(Request $request, $id)
    {
        try
        {
            // dd($request->all());
            DB::connection('mms')->beginTransaction();

            try
            {
                request()->validate([
                    'type' => 'required|string|max:50',
                    'price' => 'required|numeric|min:0',
                    'discount' => 'nullable|numeric|min:0|max:100',
                    'duration_in_days' => 'required|integer|min:1',
                ]);
            }
            catch (ValidationException $e) 
            {
                return response()->json([
                    'success' => false,
                    'errors'  => $e->errors(),
                ], 422);
            }

            $package = Package::where('package_name', $request->package_name)
                            ->where('id', '!=', $id)->first();
            if ($package)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  ucfirst(__('Paket dengan nama '. $request->package_name . ' telah terdaftar'))
                ], 200);
            }

            $package = Package::where('id', $id)->first();

            if (!$package)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  ucfirst(__('Paket tidak ditemukan'))
                ], 200);
            }

            $package->update([
                'type'              =>  $request->type,
                'description'       =>  preg_replace('/\s+/', ' ', trim($request->description)),
                'price'             =>  $request->price,
                'discount'          =>  $request->discount,
                'duration_in_days'  =>  $request->duration_in_days,
                'updated_by'        =>  Auth::user()->id,
                'updated_at'        =>  Carbon::now(),
            ]);

            DB::connection('mms')->commit();

            return response()->json([
                'success' => true,
                'message' => ucfirst(__('Paket '. $request->package_name.' berhasil diubah')),
                'data' => $package,
            ]);
        } 
        catch (\Exception $e) 
        {
            DB::connection('mms')->rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error creating package: ' . $e->getMessage(),
            ], 500);
        }
    }
}
