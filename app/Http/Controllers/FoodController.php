<?php

namespace App\Http\Controllers;

use App\Category;
use App\Food;
use App\FoodAdditive;
use App\Library\UploadImage;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public $path = 'foods';

    public function index()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $categories = Category::all();

        return view('components.foods.create', compact('role_id', 'categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $foods = Food::with('category', 'type')
            ->orderBy('category_id', 'ASC')
            ->get();

        return view('components.foods.list', compact('foods', 'role_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'price' => 'required|min:1',
            'weight' => 'required|min:1',
            'protein' => 'required|min:1',
            'fat' => 'required|min:1',
            'calories' => 'required|min:1',
            'carbohydrates' => 'required|min:1',
            'structure' => 'required|min:5',
            'image' => 'required'
        ]);

        $name = $request->name;
        $category = $request->category;
        $price = $request->price;
        $weight = $request->weight;
        $protein = $request->protein;
        $fat = $request->fat;
        $calories = $request->calories;
        $carbohydrates = $request->carbohydrates;
        $structure = $request->structure;
        $image = UploadImage::upload($request->image, $this->path, 150);

        $food = new Food();
        $food->name = $name;
        $food->category_id = $category;
        $food->price = $price;
        $food->weight = $weight;
        $food->protein = $protein;
        $food->fat = $fat;
        $food->calories = $calories;
        $food->carbohydrates = $carbohydrates;
        $food->structure = $structure;
        $food->image = $image;
        $food->note = '';
        $food->recommend = 0;
        $food->visibility = 1;
        $food->save();

        $food_additive = new FoodAdditive();
        $food_additive->food_id = $food->id;
        $food_additive->additive_id = 1;
        $food_additive->save();

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

        $food = Food::find($request->id);

        $categories = Category::all();

        return view('components.foods.edit', compact('role_id', 'food', 'categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'price' => 'required|min:1',
            'weight' => 'required|min:1',
            'protein' => 'required|min:1',
            'fat' => 'required|min:1',
            'calories' => 'required|min:1',
            'carbohydrates' => 'required|min:1',
            'structure' => 'required|min:5'
        ]);

        $name = $request->name;
        $category = $request->category;
        $price = $request->price;
        $weight = $request->weight;
        $protein = $request->protein;
        $fat = $request->fat;
        $calories = $request->calories;
        $carbohydrates = $request->carbohydrates;
        $structure = $request->structure;
        if ($request->image != null) {
            UploadImage::delete($request->id, $this->path, Type::class);
            $image = UploadImage::upload($request->image, $this->path, 150);
        }

        $food = Food::find($request->id);
        $food->name = $name;
        $food->category_id = $category;
        $food->price = $price;
        $food->weight = $weight;
        $food->protein = $protein;
        $food->fat = $fat;
        $food->calories = $calories;
        $food->carbohydrates = $carbohydrates;
        $food->structure = $structure;
        if ($request->image != null) {
            $food->icon = $image;
        }
        $food->note = '';
        $food->recommend = 0;
        $food->visibility = 1;
        $food->save();

        return redirect('/list/foods')->with('success', 'Данные обновились');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recomend(Request $request)
    {
        $recomend = Food::all()->find($request->id);

        if ($recomend->recommend == 1) {
            $recomend->recommend = 0;
        }else {
            $recomend->recommend = 1;
        }

        $recomend->save();

        return redirect()->back()->with('success', 'Рекомендация обновлена');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function visibility(Request $request)
    {
        $visibility = Food::all()->find($request->id);

        if ($visibility->visibility == 1) {
            $visibility->visibility = 0;
        }else {
            $visibility->visibility = 1;
        }

        $visibility->save();

        return redirect()->back()->with('success', 'Видимость обновлена');
    }
}
