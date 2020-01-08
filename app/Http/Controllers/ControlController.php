<?php

namespace App\Http\Controllers;

use App\User;
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

        return view('control', compact('account'));
    }
}
