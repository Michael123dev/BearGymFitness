<?php

namespace App\Http\Controllers\MMS;

use App\Http\Controllers\Controller;
use App\Models\MMS\Attendance;
use App\Models\MMS\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $mms            =   config('database.connections.mms.database');
        $startOfMonth   =   Carbon::now()->startOfMonth();
        $endOfMonth     =   Carbon::now()->endOfMonth();
        $today          =   Carbon::now()->format('Y-m-d');
        $level          =   Auth::user()->role->level;
        $name           =   Auth::user()->name;

        $words          =   explode(' ', $name); // pecah berdasarkan spasi
        $firstThree     =   array_slice($words, 0, 1); // ambil 1 kata pertama
        $nickName       =   ucwords(strtolower(implode(' ', $firstThree)));

        if ($level > 1)
        {
            $totalUser      =   User::join('roles', function ($join) {
                                    $join->on('roles.id', '=', 'users.role_id')
                                        ->where('roles.level', 1);
                                })->count();

            // $totalRevenue   =   Payment::whereBetween('payment_date', [$startOfMonth, $endOfMonth])
            //                             ->sum('total_price');

            $totalRevenue       =   Payment::select([
                                        'payments.*'
                                    ])
                                    ->join('memberships', 'payments.membership_id', '=', 'memberships.id')
                                    ->join('packages', 'memberships.package_id', '=', 'packages.id')
                                    ->whereBetween('payment_date', [$startOfMonth->toDateTimeString(), $endOfMonth->toDateTimeString()])
                                    ->sum('total_price');

            $totalRevenue   =   number_format($totalRevenue, 0, ',', '.');

            $totalMember    =   User::join('roles', function ($join) {
                                    $join->on('roles.id', '=', 'users.role_id')
                                        ->where('roles.level', 1);
                                })
                                ->join($mms.'.memberships', function ($join) use ($today, $mms) {
                                    $join->on($mms.'.memberships.user_id', '=', 'users.id')
                                        ->where($mms.'.memberships.is_active', 1)
                                        ->whereDate($mms.'.memberships.start_date', '<=', $today)
                                        ->where(function ($query) use ($today, $mms) {
                                            $query->whereDate($mms.'.memberships.end_date', '>=', $today)
                                            ->orWhereNull($mms.'.memberships.end_date');
                                        });
                                })->count();

            $totalAttendance    =   Attendance::whereBetween('attendance_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                                                ->count();

            return view('mms.dashboard.index', compact('level', 'totalUser', 'totalRevenue', 'totalMember', 'totalAttendance', 'nickName'));
        }
        else
        {
            $user               =   User::select(['users.*', 'packages.package_name', 'packages.type as package_type', 'memberships.start_date', 'memberships.end_date', 'trainers.name as trainer_name'])
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
                                        ->leftJoin($mms.'.trainers', function ($join) use ($mms) {
                                            $join->on($mms.'.trainers.id', '=', $mms.'.memberships.trainer_id');
                                        })
                                        ->where('users.id', Auth::user()->id)
                                        ->first();

            $totalAttendance    =   User::leftJoin($mms.'.attendances', function ($join) use ($mms, $startOfMonth, $endOfMonth) {
                                        $join->on($mms.'.attendances.user_id', '=', 'users.id')
                                            ->whereBetween($mms.'.attendances.attendance_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()]);
                                    })->where('users.id', Auth::user()->id)
                                    ->count();

            $packageName        =   $user->package_name;
            $packageType        =   $user->package_type;
            $trainerName        =   $user->trainer_name ?? "-";
            $detailPackage      =   $packageName && $packageType ? ucwords(strtolower($packageName . ' - ' . $packageType)) : '-';
            $membershipEndDate  =   $user->end_date ? Carbon::createFromFormat('Y-m-d', $user->end_date)->format('d M Y') : '-';
            $membershipStatus   =   $packageName && $packageType ? 'Aktif' : 'Non-Aktif';
            $remainingDays      =   0;
            $alertColor         =   '';
            $alertMessage       =   '';
            $showAlert          =   false;

            if ($user->end_date)
            {
                $date               =   Carbon::parse($user->end_date);
                $today              =   Carbon::parse($today);   
                $remainingDays      =   $today->diffInDays($date);
            }

            if ($remainingDays > 0)
            {
                if ($remainingDays <= 3)
                {
                    $showAlert = true;
                    $alertColor  = 'alert-warning';
                    $alertMessage = "Paket Anda akan berakhir {$remainingDays} hari lagi.";
                }
            }
            else
            {
                if ($remainingDays == 0 && $packageName)
                {
                    $showAlert = true;
                    $alertColor  = 'alert-warning';
                    $alertMessage = 'Paket Anda akan berakhir hari ini!';
                }
                else
                {
                    $showAlert = true;
                    $alertColor  = 'alert-danger';
                    $alertMessage = 'Anda belum memiliki paket membership. Silakan hubungi Admin';
                }

            }

            return view('mms.dashboard.index', compact('level', 'detailPackage', 'membershipEndDate', 'totalAttendance', 'nickName', 'membershipStatus', 'remainingDays', 'showAlert', 'alertColor', 'alertMessage', 'trainerName'));
        }
    }

    public function getAdminDashboardChartData()
    {
        $firstDay       =   Carbon::now()->startOfYear();
        $lastDay        =   Carbon::now()->endOfYear(); 
        $months         =   [];
        $revenues       =   [];
        $ageRanges      =   [];
        $totalPeople    =   [];    
        $monthlyRevenue =   Payment::select(
                                DB::raw("DATE_FORMAT(payment_date, '%b') as month"),
                                DB::raw('SUM(total_price) as total')
                            )
                            ->join('memberships', 'payments.membership_id', '=', 'memberships.id')
                            ->join('packages', 'memberships.package_id', '=', 'packages.id')
                            ->whereBetween('payment_date', [$firstDay, $lastDay])
                            // ->whereBetween('payment_date', [$startOfMonth->toDateTimeString(), $endOfMonth->toDateTimeString()])
                            ->groupBy(DB::raw("DATE_FORMAT(payment_date, '%b')"), DB::raw("MONTH(payment_date)"))
                            ->orderBy(DB::raw("MONTH(payment_date)"))
                            ->get();

        $ageGroups      =   User::selectRaw("
                                CASE
                                    WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 0 AND 17 THEN '0-17 Tahun'
                                    WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 25 THEN '18-25 Tahun'
                                    WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 26 AND 35 THEN '26-35 Tahun'
                                    WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 36 AND 45 THEN '36-45 Tahun'
                                    ELSE '46+'
                                END AS age_range,
                                COUNT(*) AS total_people
                            ")
                            ->groupBy('age_range')
                            ->orderByRaw("MIN(TIMESTAMPDIFF(YEAR, birth_date, CURDATE()))")
                            ->get();

        foreach ($monthlyRevenue as $revenue)
        {
            $months[] = $revenue->month;
            $revenues[] = $revenue->total;
        }

        foreach ($ageGroups as $age)
        {
            $ageRanges[] = $age->age_range;
            $totalPeople[] = $age->total_people;
        }

        return response()->json([
            'months'        =>  $months,
            'revenues'      =>  $revenues,
            'age_ranges'    =>  $ageRanges,
            'total_people'  =>  $totalPeople
        ]);

                
    }

    public function getUserDashboardChartData()
    {
        $firstDay = Carbon::now()->startOfYear(); // 2025-01-01 00:00:00
        $lastDay  = Carbon::now()->endOfYear();   // 2025-12-31 23:59:59

        $months = [];
        $attendances = [];

        $monthlyAttendances = Attendance::select(
                DB::raw("DATE_FORMAT(attendance_date, '%b') as month"),
                DB::raw("COUNT(*) as total")
            )
            ->whereBetween('attendance_date', [$firstDay, $lastDay])
            ->where('user_id', Auth::user()->id)
            ->groupBy(DB::raw("DATE_FORMAT(attendance_date, '%b')"), DB::raw("MONTH(attendance_date)"))
            ->orderBy(DB::raw("MONTH(attendance_date)"))
            ->get();

        foreach ($monthlyAttendances as $attendance) {
            $months[] = $attendance->month;
            $attendances[] = $attendance->total;
        }

        return response()->json([
            'months'      => $months,
            'attendances' => $attendances
        ]);
    }

}
