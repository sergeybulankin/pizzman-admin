<?php

namespace App\Http\Controllers;

use App\Additive;
use App\Call;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdditiveController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user()->id;        

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        return view('components.additives.create', compact('role_id'));
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
        
        return view('components.additives.list', compact('additives', 'role_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_additive' => 'required|min:3'
        ]);

        $name = $request->name_additive;
        $price = $request->price;

        $additive = new Additive();
        $additive->name =  $name;
        $additive->price = $price;
        $additive->save();

        return redirect()->back()->with('success', 'Данные добавились');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $additive = Additive::find($request->id);

        return view('components.additives.edit', compact('role_id', 'additive'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name_additive' => 'required|min:3'
        ]);

        $name = $request->name_additive;
        $price = $request->price;

        $additive = Additive::find($request->additive_id);
        $additive->name = $name;
        $additive->price = $price;
        $additive->save();

        return redirect('/list/additives')->with('success', 'Данные обновились');
    }
}
