<?php

namespace App\Http\Controllers;

use App\Call;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user()->id;

        $account = User::with('account')->where('id', $user)->first();

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $calls = Call::all()->where('noted', 0)->sortByDesc('created_at');

        $count_calls = $calls->count();

        return view('components.calls.list', compact('account', 'calls', 'role', 'count_calls'));
    }


    /**
     * @return mixed
     */
    public function callsAccepted()
    {
        $user = Auth::user()->id;

        $account = User::with('account')->where('id', $user)->first();

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $calls = Call::all()->where('noted', 1)->sortByDesc('created_at');

        $count_calls = $calls->count();

        return view('components.calls.accepted', compact('account', 'calls', 'role', 'count_calls'));

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $call = Call::all()->where('id', $request->id)->first();
        $call->noted = 1;

        $call->save();

        return redirect()->back()->with('success', 'Заявка обработана');
    }
}
