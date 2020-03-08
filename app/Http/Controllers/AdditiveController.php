<?php

namespace App\Http\Controllers;

use App\Additive;
use App\Call;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdditiveController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;        

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];        

        $count_calls = Call::all()->where('noted', 0)->count();

        return view('components.additives.create', compact('role_id', 'count_calls'));
    }
    
    /**
     * @return mixed
     */
    public function show()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $additives = Additive::all();

        $count_calls = Call::all()->where('noted', 0)->count();
        
        return view('components.additives.list', compact('additives', 'role_id', 'count_calls'));
    }
}
