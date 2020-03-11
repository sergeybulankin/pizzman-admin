<?php

namespace App\Http\Controllers;

use App\Category;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

class CategoryController extends Controller
{
    public $path = 'categories';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        return view('components.categories.create', compact('role_id'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $categories = Category::all();

        return view('components.categories.list', compact('categories', 'role_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_category' => 'required|min:3',
            'image' => 'required'
        ]);

        $name = $request->name_category;
        $image = $this->uploadImage($request->image);

        $category = new Category();
        $category->name = $name;
        $category->icon = $image;
        $category->save();

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

        $category = Category::find($request->id);

        return view('components.categories.edit', compact('role_id', 'category'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name_category' => 'required|min:3'
        ]);

        $name = $request->name_category;
        if ($request->image != null) {
            $this->deleteImage($request->category_id);
            $image = $this->uploadImage($request->image);
        }

        $category = Category::find($request->category_id);
        $category->name = $name;
        if ($request->image != null) {
            $category->icon = $image;
        }
        $category->save();

        return redirect('/list/categories')->with('success', 'Данные обновились');
    }

    /**
     * @param $image
     * @return string
     */
    public function uploadImage($image)
    {
        $img = Image::make($image);
        $img->resize(60, null, function ($c) {
            $c->aspectRatio();
        });

        $imageName = time() . str_random(27) . '.jpg';
        Storage::disk($this->path)->put($imageName, $img->encode('jpg', 100));

        return $imageName;
    }

    /**
     * @param $id
     */
    public function deleteImage($id)
    {
        $img = Category::select('icon')->where('id', $id)->first();

        if ($img != null) {
            Storage::disk($this->path)->delete($img->icon);
        }
    }

}
