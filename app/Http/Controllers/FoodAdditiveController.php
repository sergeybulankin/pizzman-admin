<?php

namespace App\Http\Controllers;

use App\Additive;
use App\Food;
use App\FoodAdditive;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodAdditiveController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $foods = Food::select('id', 'name')->get();

        $additive = Additive::select('id', 'name')->get();

        return view('components.food_additives.create', compact('role_id', 'foods', 'additive'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $food_additives = FoodAdditive::with('food', 'additive')
            ->where('additive_id', '!=', 1)
            ->orderBy('food_id', 'ASC')
            ->get()
            ->groupBy('food_id');

        return view('components.food_additives.list', compact('role_id', 'food_additives'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $comparision = FoodAdditive::where('food_id', $request->food)
            ->where('additive_id', $request->additive)
            ->get();

        if (collect($comparision)->isEmpty()) {
            $food_type = new FoodAdditive();
            $food_type->food_id = $request->food;
            $food_type->additive_id = $request->additive;

            $food_type->save();
        }else {
            return redirect()->back()->with('success', 'Такая связь уже существует');
        }

        return redirect()->back()->with('success', 'Связь добавилась');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $food_additive = FoodAdditive::find($request->id);

        $food_additive->delete();

        return redirect()->back()->with('success', 'Связь блюда с добавкой удалена');
    }
}
