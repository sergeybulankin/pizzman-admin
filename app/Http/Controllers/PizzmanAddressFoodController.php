<?php

namespace App\Http\Controllers;

use App\Food;
use App\PizzmanAddress;
use App\PizzmanAddressFood;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PizzmanAddressFoodController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $foods = Food::select('id', 'name')->get();

        $addresses = PizzmanAddress::with('address_delivery')->get();

        return view('components.food_address.create', compact('role_id', 'foods', 'addresses'));
    }

    /**
     * @return mixed
     */
    public function show()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $pizzman_address_foods = Food::with('pizzman_address')->get();

        return view('components.food_address.list', compact('role_id','pizzman_address_foods'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $comparision = PizzmanAddressFood::where('food_id', $request->food)
            ->where('pizzman_address_id', $request->address)
            ->get();

        if (collect($comparision)->isEmpty()) {
            $pizzman_address_food = new PizzmanAddressFood();
            $pizzman_address_food->food_id = $request->food;
            $pizzman_address_food->pizzman_address_id = $request->address;

            $pizzman_address_food->save();
        }else {
            return redirect()->back()->with('success', 'Такая связь уже существует');
        }

        return redirect('/list/faddress')->with('success', 'Связь добавилась');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {
        $pizzman_address_food = PizzmanAddressFood::where('food_id', $request->id)
            ->where('pizzman_address_id', $request->address_id)
            ->first();

        $pizzman_address_food->delete();

        return redirect()->back()->with('success', 'Связь блюда с адресом прекращена');
    }
}
