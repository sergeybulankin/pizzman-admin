<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderStatus;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $orders = OrderStatus::with('order', 'status')
            ->where('status_id', '>', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('dashboard', compact('orders'));
    }
}
