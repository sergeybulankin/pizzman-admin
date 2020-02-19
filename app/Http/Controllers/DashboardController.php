<?php

namespace App\Http\Controllers;

use App\Call;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user()->id;
        
        $account = User::with('account')->where('id', $user)->first();
        
        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $count_calls = Call::all()->where('noted', 0)->count();

        return view('dashboard', compact('account', 'role', 'role_id', 'count_calls'));
    }
}
