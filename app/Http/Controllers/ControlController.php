<?php

namespace App\Http\Controllers;

use App\Call;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControlController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user()->id;

        $account = User::with('account')->where('id', $user)->first();

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $count_calls = Call::all()->where('noted', 0)->sortByDesc('created_at');

        return view('control', compact('account', 'role', 'count_calls'));
    }
}
