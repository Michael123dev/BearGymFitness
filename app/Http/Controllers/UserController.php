<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\GeneralSetting;
use App\Models\MMS\Attendance;
use App\Models\MMS\Membership;
use App\Models\MMS\Package;
use App\Models\MMS\Payment;
use App\Models\MMS\Trainer;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->tcode    =   'MMS1'; // harus diisi, karena akan menentukan menu aktif
    }

    public function index()
    {
        $packages = Package::where('is_active', 1)->get();
        $trainers = Trainer::where('is_active', 1)->get();
        return view('mms.users.index', compact('packages', 'trainers'));
    }

    public function data(Request $request)
    {
        $name               =   $request->name;
        $birthDateFrom      =   $request->birth_date_from;
        $birthDateTo        =   $request->birth_date_to;
        $gender             =   $request->gender;
        $phone              =   $request->phone;
        $expiredDateFrom    =   $request->expired_date_from;
        $expiredDateTo      =   $request->expired_date_to;
        $membershipStatus   =   $request->membership_status;


        // dd($request->all());
        $mms                =   config('database.connections.mms.database');
        $today              =   Carbon::now()->format('Y-m-d');

        $users              =   User::select(['users.*', 'packages.type as package_type', 'memberships.start_date', 'memberships.end_date', 'attendances.attendance_date'])
                                    ->leftJoin($mms.'.memberships', function ($join) use ($today, $mms) {
                                        $join->on($mms.'.memberships.user_id', '=', 'users.id')
                                            ->where($mms.'.memberships.is_active', 1)
                                            ->whereDate($mms.'.memberships.start_date', '<=', $today)
                                            ->where(function ($query) use ($today, $mms) {
                                                $query->whereDate($mms.'.memberships.end_date', '>=', $today)
                                                    ->orWhereNull($mms.'.memberships.end_date');
                                            });
                                    })
                                    ->leftJoin($mms.'.packages', function ($join) use ($mms) {
                                        $join->on($mms.'.packages.id', '=', $mms.'.memberships.package_id');
                                    })
                                    ->leftJoin($mms.'.attendances', function ($join) use ($mms) {
                                        $join->on($mms.'.attendances.user_id', '=', 'users.id')
                                            ->whereDate($mms.'.attendances.attendance_date', Carbon::now()->format('Y-m-d'));
                                    })
                                    ->join('roles', function ($join) {
                                        $join->on('roles.id', '=', 'users.role_id')
                                            ->where('roles.level', 1);
                                    })
                                    ->orderBy('attendances.attendance_date', 'asc')
                                    ->orderBy('memberships.end_date', 'asc');

        if ($name) 
        {
            $users->where('name', 'like', "%{$name}%");
        }

        if ($birthDateFrom && $birthDateTo) 
        {
            $users->whereBetween('birth_date', [$birthDateFrom, $birthDateTo]);
        } 
        elseif ($birthDateFrom) 
        {
            $users->where('birth_date', '>=', $birthDateFrom);
        } 
        elseif ($birthDateTo) 
        {
            $users->where('birth_date', '<=', $birthDateTo);
        }

        if ($gender) 
        {
            if ($gender != "ALL")
            {
                $users->where('gender', $gender);
            }
        }

        if ($phone) 
        {
            $users->where('phone', 'like', "%{$phone}%");
        }

        if ($membershipStatus) 
        {
            if ($membershipStatus != "ALL")
            {
                if ($membershipStatus == "GUEST")
                {
                    $users->where('packages.type', 'DAILY');
                }
                else if ($membershipStatus == "MEMBER")
                {
                    $users->where('packages.type', 'MONTHLY');
                }
                else
                {
                    $users->whereNull('packages.type');
                }
            }
        }

        if ($expiredDateFrom && $expiredDateTo) 
        {
            $users->whereBetween('end_date', [$expiredDateFrom, $expiredDateTo]);
        } 
        else if ($expiredDateFrom) 
        {
            $users->where('end_date', '>=', $expiredDateFrom);
        } 
        elseif ($expiredDateTo) 
        {
            $users->where('end_date', '<=', $expiredDateTo);
        }

        $searchParams = [
            'name'              =>  $name,
            'birth_date_from'   =>  $birthDateFrom,
            'birth_date_to'     =>  $birthDateTo,
            'gender'            =>  $gender,
            'phone'             =>  $phone,
            'expired_date_from'   =>  $expiredDateFrom,
            'expired_date_to'     =>  $expiredDateTo,
            'membership_status' =>  $membershipStatus
        ];

        Session::put($this->tcode.'searchParams', $searchParams);

        return DataTables::of($users)
                        ->addColumn('action', function($users) {
                            $button = '<button title="'. ucfirst(__('detail')) .'" 
                                class="detail-button btn btn-xs btn-secondary mr-1" 
                                onclick="showDetail('. $users->id .')">
                                <i class="fa fa-eye fa-fw fa-xs"></i>
                            </button>';

                            $button .= '<button title="'. ucfirst(__('detail')) .'" 
                                class="edit-button btn btn-xs btn-secondary mr-1" 
                                onclick="showEdit('. $users->id .')">
                                <i class="fa fa-pen fa-fw fa-xs"></i>
                            </button>';

                            if (!$users->package_type)
                            {
                                $button .= '<button title="'. ucfirst(__('detail')) .'" 
                                    class="detail-button btn btn-xs btn-primary" 
                                    onclick="chooseMembershipPackage('. $users->id .')">
                                    <i class="fa fa-user-plus fa-fw fa-xs"></i>
                                </button>';
                            }

                            if (!$users->attendance_date && $users->package_type)
                            {
                                $button .= '<button title="'. ucfirst(__('check in')) .'" 
                                    class="checkin-button btn btn-xs btn-warning" 
                                    onclick="checkIn('. $users->id .')">
                                    <i class="fas fa-sign-in-alt fa-fw fa-xs"></i>
                                </button>';
                            }

                            return $button;
                        })
                        ->editColumn('birth_date', function($users) {
                            return Carbon::createFromFormat('Y-m-d', $users->birth_date)->format('d/m/Y');
                        })
                        ->addColumn('expired_date', function($users) {
                            if ($users->end_date)
                            {
                                return Carbon::parse($users->end_date)->format('d/m/Y');
                            }
                            else
                            {
                                return '-';
                            }
                        })
                        ->addColumn('membership_status', function($users) {

                            if ($users->package_type)
                            {
                                if ($users->package_type == "DAILY")
                                {
                                    return '<span class="badge badge-pill badge-warning">GUEST</span>';
                                }
                                else
                                {
                                    return '<span class="badge badge-pill badge-success">MEMBER</span>';
                                }
                            }
                            else
                            {
                                return '<span class="badge badge-pill badge-danger">EXPIRED</span>';
                            }


                        })
                        ->setRowClass(function ($users) {
                            // Example: highlight expired memberships
                            return !$users->end_date ? 'table-danger' : '';
                        })
                         ->rawColumns(['action', 'membership_status']) // <-- Important!
                        ->addIndexColumn()
                        ->make(true);
    }

    public function membershipHistory(Request $request)
    {
        $userId = $request->user_id;
        $today      =   Carbon::now()->format('Y-m-d');

        $memberships =  Membership::with(['package', 'trainer'])
                            ->where('user_id', $userId)
                            ->orderBy('id', 'desc');
        
        return DataTables::of($memberships)
                        ->addColumn('package_name', function ($memberships) {
                            return $memberships->package ? $memberships->package->package_name : '-';
                        })
                        ->addColumn('package_type', function ($memberships) {
                            return $memberships->package ? $memberships->package->type : '-';
                        })
                        ->addColumn('trainer_name', function ($memberships) {
                            return $memberships->trainer ? $memberships->trainer->name : '-';
                        })
                        ->editColumn('start_date', function ($memberships) {
                            return Carbon::parse($memberships->start_date)->format('d/m/Y');
                        })
                        ->editColumn('end_date', function ($memberships) {
                            return $memberships->end_date ? Carbon::parse($memberships->end_date)->format('d/m/Y') : '-';
                        })
                        ->editColumn('status', function ($memberships) use ($today) {
                            if ($memberships->is_active == 1 && $memberships->start_date <= $today && $memberships->end_date >= $today)
                            {
                                return 'AKTIF';
                            }
                            return 'NON-AKTIF';
                            
                        })
                        ->setRowClass(function ($memberships) use ($today) {
                            if ($memberships->is_active == 1 && $memberships->start_date <= $today && $memberships->end_date >= $today)
                            {
                                return 'table-success';
                            }
                            return '';
                        })
                        ->addIndexColumn()
                        ->make(true);
    }

    public function register(Request $request)
    {
        $name           =   $request->name;
        $birthDate      =   $request->birth_date;
        $gender         =   $request->gender;
        $phone          =   $request->phone;
        $email          =   $request->email ?? '';
        $packageId      =   $request->package_id;
        $startDate      =   $request->start_date;
        $endDate        =   $request->end_date;
        $trainerId      =   $request->trainer_id; 
        $isSpecialDisc  =   $request->is_special_discount == "YES" ? 1 : 0;
        $price          =   $request->price;
        $discountPrice  =   $request->discount_price;
        $totalPrice     =   $request->total_price;
        $paymentMethod  =   $request->payment_method;
        $remarks        =   $request->remarks;

        // dd($birthDate);
        try
        {
            DB::beginTransaction();
            DB::connection('mms')->beginTransaction();
            try 
            {
                request()->validate(
                    [
                        'name'       => 'required|string|max:255',
                        'gender'     => 'required|in:L,P',
                        'phone'      => 'required|string|regex:/^[0-9\-\+\s\(\)]+$/|min:10|max:15',
                        'birth_date' => 'required|date_format:Y-m-d',
                    ],
                    [
                        'name.required'       => 'Nama wajib diisi.',
                        'name.string'         => 'Nama harus berupa teks.',
                        'name.max'            => 'Nama maksimal :max karakter.',

                        'gender.required'     => 'Jenis kelamin wajib dipilih.',
                        'gender.in'           => 'Jenis kelamin harus Laki-Laki (L) atau Perempuan (P).',

                        'phone.required'      => 'Nomor telepon wajib diisi.',
                        'phone.string'        => 'Nomor telepon harus berupa teks.',
                        'phone.regex'         => 'Nomor telepon hanya boleh berisi angka, spasi, tanda +, -, atau ().',
                        'phone.min'           => 'Nomor telepon minimal :min digit.',
                        'phone.max'           => 'Nomor telepon maksimal :max digit.',

                        'birth_date.required'    => 'Tanggal lahir wajib diisi.',
                        'birth_date.date_format' => 'Format tanggal lahir harus YYYY-MM-DD.',
                    ]
                );
            } 
            catch (ValidationException $e) 
            {
                return response()->json([
                    'success' => false,
                    'errors'  => $e->errors(),
                ], 422);
            }

            $user       =   User::where('phone', $phone)->first();
            $role       =   Role::where('role_name', 'USER')->first();
            $package    =   Package::where('id', $packageId)->first();

            if ($user)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  "Pengguna dengan nomor HP ". $phone . " telah terdaftar"
                ]);
            }

            if (!$role)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  "Role user tidak ditemukan"
                ]);
            }

            if (!$package)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  "Paket tidak ditemukan"
                ]);
            }

            $passwordFromBirthDate  =   Carbon::createFromFormat('Y-m-d', $birthDate)->format('dmY');
            $passwordFromPhone      =   substr($phone, -3);
            // $password               =   $passwordFromBirthDate.$passwordFromPhone;
            $password               =   $passwordFromBirthDate;
            $password               =   password_hash($password, PASSWORD_DEFAULT);

            $user = User::create([
                'role_id'       =>  $role->id,
                'name'          =>  $name,
                'birth_date'    =>  Carbon::createFromFormat('Y-m-d', $birthDate)->format('Y-m-d'),
                'gender'        =>  $gender,
                'phone'         =>  $phone,
                'password'      =>  $password,
                'created_by'    =>  Auth::user()->id,
                'created_at'    =>  Carbon::now(),
                'updated_by'    =>  Auth::user()->id,
                'updated_at'    =>  Carbon::now(),
            ]);

            $membership = Membership::create([
                'user_id'           =>  $user->id,
                'package_id'        =>  $package->id,
                'trainer_id'        =>  $trainerId,
                'start_date'        =>  $startDate,
                'end_date'          =>  $endDate,
                'is_active'         =>  true,
                'is_verified'       =>  true,
                'created_by'        =>  Auth::user()->id,
                'created_at'        =>  Carbon::now(),
                'updated_by'        =>  Auth::user()->id,
                'updated_at'        =>  Carbon::now(),
            ]);

            $discount = 0;
            if ($discountPrice > 0)
            {
                $discount = ($discountPrice / $price) * 100;
            }

            $day = Carbon::now()->format('d');
            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('y');

            $documentNumber = Counter::getCounter('MMS', 'INVOICE', 'INV/BGM-KDS/'. $day . '/' . $month . '/' . $year . '/{C:3}');
            $payment = Payment::create([
                'membership_id'         =>  $membership->id,
                'document_number'       =>  $documentNumber,
                'price'                 =>  $price,
                'is_special_discount'   =>  $isSpecialDisc,
                'discount'              =>  $discount,
                'discount_price'        =>  $discountPrice,
                'total_price'           =>  $totalPrice,
                'payment_date'          =>  Carbon::now(),
                'payment_method'        =>  $paymentMethod,
                'proof_of_payment'      =>  '',
                'remarks'               =>  $remarks,
                'created_by'            =>  Auth::user()->id,
                'created_at'            =>  Carbon::now(),
                'updated_by'            =>  Auth::user()->id,
                'updated_at'            =>  Carbon::now(),
            ]);

            $attendance = Attendance::create([
                'user_id'           =>  $user->id,
                'attendance_date'   =>  Carbon::now(),
                'created_by'        =>  Auth::user()->id,
                'created_at'        =>  Carbon::now(),
                'updated_by'        =>  Auth::user()->id,
                'updated_at'        =>  Carbon::now()
            ]); 

            DB::commit();
            DB::connection('mms')->commit();

            return response()->json([
                'success'   =>  true,
                'message'   =>  "Pengguna baru behasil didaftarkan"
            ]);
            
        }
        catch (\Exception $e)
        {
            DB::rollback();
            DB::connection('mms')->rollback();

            return response()->json([
                'success' => false,
                'message' => 'Error creating user: ' . $e->getMessage(),
            ], 500);
        }
        
    }

    public function renewMembership(Request $request)
    {
        $userId         =   $request->user_id;
        $packageId      =   $request->package_id;
        $startDate      =   $request->start_date;
        $endDate        =   $request->end_date;
        $trainerId      =   $request->trainer_id;
        $isSpecialDisc  =   $request->is_special_discount == "YES" ? 1 : 0;
        $price          =   $request->price;
        $discountPrice  =   $request->discount_price;
        $totalPrice     =   $request->total_price;
        $paymentMethod  =   $request->payment_method;
        $remarks        =   $request->remarks;

        // dd($request->all());

        try
        {
            // dd($request->all());
            DB::beginTransaction();
            DB::connection('mms')->beginTransaction();
            try 
            {
                request()->validate(
                    [
                        'user_id'      => 'required|exists:users,id',
                        'package_id'   => 'required|exists:mms.packages,id',
                        'start_date'   => 'required|date_format:Y-m-d',
                        'end_date'     => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
                    ],
                    [
                        'user_id.required'     => 'Pengguna wajib dipilih.',
                        'user_id.exists'       => 'Pengguna tidak ditemukan.',

                        'package_id.required'  => 'Paket wajib dipilih.',
                        'package_id.exists'    => 'Paket tidak ditemukan.',

                        'start_date.required'    => 'Tanggal mulai wajib diisi.',
                        'start_date.date_format' => 'Format tanggal mulai harus YYYY-MM-DD.',

                        'end_date.date_format'   => 'Format tanggal berakhir harus YYYY-MM-DD.',
                        'end_date.after_or_equal'=> 'Tanggal berakhir harus setelah atau sama dengan tanggal mulai.',
                    ]
                );
            } 
            catch (ValidationException $e) 
            {
                return response()->json([
                    'success' => false,
                    'errors'  => $e->errors(),
                ], 422);
            }

            $user       =   User::where('id', $userId)->first();
            $package    =   Package::where('id', $packageId)->first();

            if (!$user)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  "Pengguna tidak ditemukan"
                ]);
            }

            if (!$package)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  "Paket tidak ditemukan"
                ]);
            }
            $membership = Membership::create([
                'user_id'           =>  $user->id,
                'package_id'        =>  $package->id,
                'start_date'        =>  $startDate,
                'end_date'          =>  $endDate,
                'trainer_id'        =>  $trainerId,
                'is_active'         =>  true,
                'is_verified'       =>  true,
                'created_by'        =>  Auth::user()->id,
                'created_at'        =>  Carbon::now(),
                'updated_by'        =>  Auth::user()->id,
                'updated_at'        =>  Carbon::now(),
            ]); 

            $discount = 0;
            if ($discountPrice > 0)
            {
                $discount = ($discountPrice / $price) * 100;
            }
            
            $day = Carbon::now()->format('d');
            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('y');

            $documentNumber = Counter::getCounter('MMS', 'INVOICE', 'INV/BGM-KDS/'. $day . '/' . $month . '/' . $year . '/{C:3}');
            $payment = Payment::create([
                'membership_id'         =>  $membership->id,
                'document_number'       =>  $documentNumber,
                'price'                 =>  $price,
                'is_special_discount'   =>  $isSpecialDisc,
                'discount'              =>  $discount,
                'discount_price'        =>  $discountPrice,
                'total_price'           =>  $totalPrice,
                'payment_date'          =>  Carbon::now(),
                'payment_method'        =>  $paymentMethod,
                'proof_of_payment'      =>  '',
                'remarks'               =>  $remarks,
                'created_by'            =>  Auth::user()->id,
                'created_at'            =>  Carbon::now(),
                'updated_by'            =>  Auth::user()->id,
                'updated_at'            =>  Carbon::now(),
            ]);

            DB::commit();
            DB::connection('mms')->commit();

            return response()->json([
                'success'   =>  true,
                'message'   =>  "Paket " . $package->package_name . " berhasil ditambahkan untuk pengguna " . $user->name
            ]);
            
        }
        catch (\Exception $e)
        {
            DB::rollback();
            DB::connection('mms')->rollback();

            return response()->json([
                'success' => false,
                'message' => 'Error renew membership: ' . $e->getMessage(),
            ], 500);
        }
        
    }

    public function checkIn(Request $request)
    {
        $userId = $request->user_id ?? Auth::user()->id;

        try
        {
            DB::beginTransaction();
            DB::connection('mms')->beginTransaction();

            $mms            =   config('database.connections.mms.database');
            $today          =   Carbon::now()->format('Y-m-d');
            $user           =   User::where('id', $userId)->first();
            $startOfMonth   =   Carbon::now()->startOfMonth();
            $endOfMonth     =   Carbon::now()->endOfMonth();

            if (!$user)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  "Pengguna tidak ditemukan"
                ]);
            }

            if (Auth::user()->role->level == 1)
            {
                $locationSetting    =   GeneralSetting::where('section', 'MMS')
                                                ->where('label', 'LATITUDE_LONGITUDE')
                                                ->first();

                if (!$locationSetting)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Setting lokasi tidak ditemukan'
                    ]);
                }

                $checkMembership    =   Membership::where('memberships.is_active', 1)
                                                ->whereDate('memberships.start_date', '<=', $today)
                                                    ->where(function ($query) use ($today, $mms) {
                                                        $query->whereDate('memberships.end_date', '>=', $today)
                                                            ->orWhereNull('memberships.end_date');
                                                    })
                                                ->where('user_id', $userId)
                                                ->first();

                if (!$checkMembership)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Anda belum memiliki paket membership. Silakan hubungi Admin'
                    ]);
                }

                $officeLat      =   $locationSetting->reff1;
                $officeLng      =   $locationSetting->reff2;
                $allowedRadius  =   $locationSetting->reff3; // in meters

                $distance = $this->haversine($request->latitude, $request->longitude, $officeLat, $officeLng);

                if ($distance > $allowedRadius) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Anda berada di luar jangkauan lokasi'
                    ]);
                }
            }
            
            $today = Carbon::now()->format('Y-m-d');
            $existingAttendance = Attendance::where('user_id', $userId)
                                        ->whereDate('attendance_date', $today)
                                        ->first();
            if ($existingAttendance)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  ucwords(strtolower($user->name)) . " sudah melakukan check-in hari ini"
                ]);
            }

            $attendance = Attendance::create([
                'user_id'           =>  $user->id,
                'attendance_date'   =>  Carbon::now(),
                'created_by'        =>  Auth::user()->id,
                'created_at'        =>  Carbon::now(),
                'updated_by'        =>  Auth::user()->id,
                'updated_at'        =>  Carbon::now()
            ]); 

            $totalAttendance    =   Attendance::whereBetween('attendance_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                                                ->where('user_id', Auth::user()->id)
                                                ->count();

            DB::commit();
            DB::connection('mms')->commit();

            return response()->json([
                'success'   =>  true,
                'total_attendance' => $totalAttendance,
                'message'   =>  ucwords(strtolower($user->name)) . " berhasil check-in"
            ]);
            
        }
        catch (\Exception $e)
        {
            DB::rollback();
            DB::connection('mms')->rollback();

            return response()->json([
                'success' => false,
                'message' => 'Error during check-in: ' . $e->getMessage(),
            ], 500);
        }
    }


    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function getUserProfile($id)
    {
        $mms    =   config('database.connections.mms.database');
        $today  =   Carbon::now()->format('Y-m-d');

        $user   =   User::select(['users.*', 'packages.type as package_type', 'packages.package_name', 'memberships.id as membership_id', 'memberships.end_date'])
                        ->leftJoin($mms.'.memberships', function ($join) use ($today, $mms) {
                            $join->on($mms.'.memberships.user_id', '=', 'users.id')
                                ->where($mms.'.memberships.is_active', 1)
                                ->whereDate($mms.'.memberships.start_date', '<=', $today)
                                ->where(function ($query) use ($today, $mms) {
                                    $query->whereDate($mms.'.memberships.end_date', '>=', $today)
                                        ->orWhereNull($mms.'.memberships.end_date');
                                });
                        })
                        ->leftJoin($mms.'.packages', function ($join) use ($mms) {
                            $join->on($mms.'.packages.id', '=', $mms.'.memberships.package_id');
                        })
                        ->where('users.id', $id)
                        ->first();


        if (!$user)
        {
            return response()->json([
                'success'   =>  false,
                'message'   =>  "Pengguna tidak ditemukan"
            ]);
        }

        $user = [
            'name'          =>  $user->name,
            'email'         =>    $user->email,
            'birth_date'    =>  $user->birth_date,
            'gender'            =>     $user->gender == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN',
            'phone'         =>  $user->phone,
            'package_type'    =>  $user->package_type ? $user->package_type : '-',
            'package_name'    =>  $user->package_name ? $user->package_name : '-',
            'end_date'  =>  $user->end_date ? Carbon::createFromFormat('Y-m-d', $user->end_date)->format('d/m/Y') : '-',
            'package_type'   =>  $user->package_type ? $user->package_type : '-',
            'membership_id' => $user->membership_id,
            'membership_status' =>  $user->package_type ? ($user->package_type == 'DAILY' ? 'GUEST' : 'MEMBER') : 'EXPIRED',
        ];

        return response()->json([
            'success'   =>  true,
            'data'      =>  $user
        ]);
    }

    public function update(Request $request)
    {
        try
        {
            DB::beginTransaction();

            $id         =   $request->user_id;
            $name       =   $request->name;
            $birthDate  =   $request->birth_date;
            $gender     =   $request->gender;
            $phone      =   $request->phone;
            $email      =   $request->email;

            try 
            {
                request()->validate(
                    [
                        'name'       => 'required|string|max:255',
                        'gender'     => 'required|in:L,P',
                        'phone'      => 'required|string|regex:/^[0-9\-\+\s\(\)]+$/|min:10|max:15',
                        'birth_date' => 'required|date_format:Y-m-d',
                    ],
                    [
                        'name.required'       => 'Nama wajib diisi.',
                        'name.string'         => 'Nama harus berupa teks.',
                        'name.max'            => 'Nama maksimal :max karakter.',

                        'gender.required'     => 'Jenis kelamin wajib dipilih.',
                        'gender.in'           => 'Jenis kelamin harus Laki-Laki (L) atau Perempuan (P).',

                        'phone.required'      => 'Nomor telepon wajib diisi.',
                        'phone.string'        => 'Nomor telepon harus berupa teks.',
                        'phone.regex'         => 'Nomor telepon hanya boleh berisi angka, spasi, tanda +, -, atau ().',
                        'phone.min'           => 'Nomor telepon minimal :min digit.',
                        'phone.max'           => 'Nomor telepon maksimal :max digit.',

                        'birth_date.required'    => 'Tanggal lahir wajib diisi.',
                        'birth_date.date_format' => 'Format tanggal lahir harus YYYY-MM-DD.',
                    ]
                );
            } 
            catch (ValidationException $e) 
            {
                return response()->json([
                    'success' => false,
                    'errors'  => $e->errors(),
                ], 422);
            }

            $user = User::where('phone', $phone)
                        ->where('id', '!=', $id)
                        ->first();

            if ($user)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  "Nomor HP sudah digunakan oleh pengguna lain"
                ]);
            }

            $user = User::where('id', $id)->first();
            if (!$user)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  "Pengguna tidak ditemukan"
                ]);
            }

            $user->update([
                'name'          =>  $name,
                'birth_date'    =>  $birthDate,
                'gender'        =>  $gender,
                'phone'         =>  $phone,
                'email'         =>  $email ?? '',
                'updated_by'    =>  Auth::user()->id,
                'updated_at'    =>  Carbon::now(),
            ]);

            DB::commit();
            return response()->json([
                'success'   =>  true,
                'message'   =>  "Data pengguna berhasil diperbaharui"
            ]); 

        }
        catch (\Exception $e)
        {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error update user profile: ' . $e->getMessage(),
            ], 500);
        }
        
    }

    public function deactivateMembership(Request $request)
    {
        try
        {
            DB::connection('mms')->beginTransaction();
            $membership = Membership::where('id', $request->membership_id);

            if (!$membership)
            {
                return response()->json([
                    'success'   =>  false,
                    'message'   =>  "Data membership tidak ditemukan"
                ]);
            }

            $membership->update([
                'is_active'     =>  0,
                'updated_by'    =>  Auth::user()->id,
                'updated_at'    =>  Carbon::now()
            ]);

            DB::connection('mms')->commit();
            return response()->json([
                'success'   =>  true,
                'message'   =>  "Paket berhasil dinon-aktifkan"
            ]); 

        }
        catch (\Exception $e)
        {
            DB::connection('mms')->rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error update user profile: ' . $e->getMessage(),
            ], 500);
        }
        
        
    }
}
