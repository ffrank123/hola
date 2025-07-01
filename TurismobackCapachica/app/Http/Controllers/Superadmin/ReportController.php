<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Service;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function salesBy()
    {
        return Reservation::select('services.category_id', DB::raw('count(*) as total'))
            ->join('services','reservations.service_id','services.id')
            ->groupBy('services.category_id')
            ->with('category')
            ->get();
    }

    public function usageMetrics()
    {
        $isSqlite = \DB::connection()->getDriverName() === 'sqlite';
        $dateExpr = $isSqlite ? \DB::raw("strftime('%Y-%m', created_at) as month") : \DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month");
        return response()->json([
          'monthly_reservations' => \App\Models\Reservation::select($dateExpr, \DB::raw('count(*) as total'))
                                          ->groupBy('month')->get(),
          'active_users'        => \DB::table('users')->where('last_login_at','>=',now()->subMonth())->count(),
        ]);
    }
}
