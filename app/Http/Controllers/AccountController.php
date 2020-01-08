<?php

namespace App\Http\Controllers;

use App\Account;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user()->id;

        $account = User::with('account')->where('id', $user)->first();

        $roles = Role::all();

        return view('components.users.create', compact('roles', 'account'));
    }

    /**
     * @return mixed
     */
    public function show()
    {
        $user = Auth::user()->id;

        $account = User::with('account')->where('id', $user)->first();

        $accounts = Account::with('user')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('components.users.list', compact('accounts', 'account'));
    }

    public function store(Request $request)
    {
        // TODO
    }
}
