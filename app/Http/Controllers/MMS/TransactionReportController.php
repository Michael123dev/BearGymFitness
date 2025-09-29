<?php

namespace App\Http\Controllers\MMS;

use App\Http\Controllers\Controller;
use App\Models\MMS\Package;
use App\Models\MMS\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class TransactionReportController extends Controller
{
    public function __construct()
    {
        $this->tcode    =   'MMS3'; // harus diisi, karena akan menentukan menu aktif
    }

    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $threeMonthsBefore = Carbon::now()->subMonths(3)->format('Y-m-d');
        
        return view('mms.transaction_reports.index', compact('today', 'threeMonthsBefore'));
    }

    public function getPaymentData($documentNumber, $packageType, $packageName, $memberName, $paymentDateFrom, $paymentDateTo, $paymentMethod)
    {
        $defaultConnection  =   config('database.connections.mysql.database');

        $payments           =   Payment::select([
                                    'payments.*',
                                    'packages.package_name',
                                    'packages.type as package_type',
                                    'users.name as member_name'
                                ])
                                ->join('memberships', 'payments.membership_id', '=', 'memberships.id')
                                ->join('packages', 'memberships.package_id', '=', 'packages.id')
                                ->join($defaultConnection . '.users as users', 'memberships.user_id', '=', $defaultConnection.'.users.id')
                                ->orderBy('payments.id', 'desc');

        if ($documentNumber) 
        {
            $payments->where('payments.document_number', $documentNumber);
        }

        if ($packageType)
        {
            $payments->where('packages.type', $packageType);
        }

        if ($packageName) 
        {
            $payments->where('packages.package_name', $packageName);
        }

        if ($memberName)
        {
            $payments->where('users.name', 'like', "%{$memberName}%");
        }

        if ($paymentDateFrom && $paymentDateTo) 
        {
            $payments->whereDate('payments.payment_date', '>=', $paymentDateFrom)->whereDate('payments.payment_date', '<=', $paymentDateTo);
            // $payments->whereBetween('payments.payment_date', [$paymentDateFrom, $paymentDateTo]);
        }
        else if ($paymentDateFrom) 
        {
            $payments->whereDate('payments.payment_date', '>=', $paymentDateFrom);
        } 
        else if ($paymentDateTo) 
        {
            $payments->whereDate('payments.payment_date', '<=', $paymentDateTo);
        }

        if ($paymentMethod) 
        {
            $payments->where('payments.payment_method', $paymentMethod);
        }

        return $payments;
    }

    public function data(Request $request)
    {
        $documentNumber     =   $request->document_number;
        $packageType        =   $request->package_type;
        $packageName        =   $request->package_name;
        $memberName         =   $request->member_name;
        $paymentDateFrom    =   $request->payment_date_from;
        $paymentDateTo      =   $request->payment_date_to;
        $paymentMethod      =   $request->payment_method;

        $payments           =   $this->getPaymentData($documentNumber, $packageType, $packageName, $memberName, $paymentDateFrom, $paymentDateTo, $paymentMethod);
        // $total = (clone $payments)->sum('total_price');
        $searchParams = [
            'document_number'   =>  $documentNumber,
            'package_type'      =>  $packageType,
            'package_name'      =>  $packageName,
            'member_name'       =>  $memberName,
            'payment_date_from' =>  $paymentDateFrom,
            'payment_date_to'   =>  $paymentDateTo,
            'payment_methhod'   =>  $paymentMethod
        ];

        Session::put($this->tcode.'searchParams', $searchParams);

        return DataTables::of($payments)
                        ->editColumn('price', function($payments) {
                            return number_format($payments->price, 0, ',', '.');
                        })
                        ->editColumn('discount', function($payments) {
                            return number_format($payments->discount, 0, ',', '.');
                        })
                        ->editColumn('total_price', function($payments) {
                            return number_format($payments->total_price, 0, ',', '.');
                        })
                        ->editColumn('payment_date', function($payments) {
                            return Carbon::createFromFormat('Y-m-d H:i:s', $payments->payment_date)->format('d/m/Y H:i:s');
                        })
                        ->addIndexColumn()
                        // ->with('sum_amount', $total)
                        ->make(true);
        
        // return view($request->all());
    }

    public function getTotalPayment(Request $request)
    {
        $total              =   0;
        $documentNumber     =   $request->document_number;
        $packageType        =   $request->package_type;
        $packageName        =   $request->package_name;
        $memberName         =   $request->member_name;
        $paymentDateFrom    =   $request->payment_date_from;
        $paymentDateTo      =   $request->payment_date_to;
        $paymentMethod      =   $request->payment_method;

        $payments           =   $this->getPaymentData($documentNumber, $packageType, $packageName, $memberName, $paymentDateFrom, $paymentDateTo, $paymentMethod);

        $total              =   $payments->sum('payments.total_price');
        return response()->json([
            'total' =>  number_format($total, 0, ',', '.')
        ]);
    }

    public function getDocumentNumbers(Request $request)
    {
        try
        {
            $paymentDateFrom    =   $request->payment_date_from;
            $paymentDateTo      =   $request->payment_date_to;

            $payments =   Payment::query();
            if ($paymentDateFrom && $paymentDateTo) 
            {
                $payments->whereDate('payment_date', '>=', $paymentDateFrom)
                        ->whereDate('payment_date', '<=', $paymentDateTo);
            }
            else if ($paymentDateFrom) 
            {
                $payments->whereDate('payment_date', '>=', $paymentDateFrom);
            } 
            else if ($paymentDateTo) 
            {
                $payments->whereDate('payment_date', '<=', $paymentDateTo);
            }

            $payments = $payments->orderBy('id', 'DESC')->get();
            // dd($payments);
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Invoice number retrieved successfully',
                'data'      =>  $payments
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

    public function getPackageTypes(Request $request)
    {
        try
        {
            $packages = Package::select('type')->orderBy('type', 'asc')->groupBy('type')->get();
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Jenis Paket berhasil didapatkan',
                'data'      =>  $packages
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

    public function getPackageNames(Request $request)
    {
        try
        {
            $packageType = $request->package_type;
            $packages = Package::select('package_name');
            if ($packageType)
            {
                $packages->where('type', $packageType);
            }

            $packages = $packages->get();
            
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Nama Paket berhasil didapatkan',
                'data'      =>  $packages
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
}
