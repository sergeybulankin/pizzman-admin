<?php

namespace App\Http\Controllers;

use App\Order;
use App\UserPoint;
use App\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $user_point = UserPoint::select('pizzman_address_id')->where('user_id', $user)->first();

        $orders = Order::with('food', 'order_status', 'order_status_last', 'address', 'courier', 'courier_info')
            ->where('pizzman_address_id', $user_point->pizzman_address_id)
            ->get();

        $orders = collect($orders)->groupBy('food_key')->collapse();

        return view('statistic', compact('role_id', 'orders'));
    }

    public function betweenDates(Request $request)
    {
        $request->validate([
            'from'=> 'required|date',
            'to'=> 'required|date',
        ]);

        $from = Carbon::parse($request->from)
            ->startOfDay()
            ->toDateTimeString();

        $to= Carbon::parse($request->to)
            ->endOfDay()
            ->toDateTimeString();

        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $user_point = UserPoint::select('pizzman_address_id')->where('user_id', $user)->first();

        $orders  = Order::whereBetween('created_at', [$from, $to])
            ->where('pizzman_address_id', $user_point->pizzman_address_id)
            ->get();

        return view('between_dates', compact('role_id', 'orders'));
    }
}
