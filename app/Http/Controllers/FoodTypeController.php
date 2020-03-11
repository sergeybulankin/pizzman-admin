<?php

namespace App\Http\Controllers;

use App\Food;
use App\FoodType;
use App\Type;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodTypeController extends Controller
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

        $types = Type::select('id', 'name')->get();

        return view('components.food_types.create', compact('role_id', 'foods', 'types'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $food_types = Food::with('type')->get();

        return view('components.food_types.list', compact('role_id','food_types'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $comparision = FoodType::where('food_id', $request->food)
            ->where('type_id', $request->type)
            ->get();

        if (collect($comparision)->isEmpty()) {
            $food_type = new FoodType();
            $food_type->food_id = $request->food;
            $food_type->type_id = $request->type;

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
        $food_type = FoodType::where('food_id', $request->id)
            ->where('type_id', $request->type_id)
            ->first();

        $food_type->delete();

        return redirect()->back()->with('success', 'Связь блюда с типом удалена');
    }
}
