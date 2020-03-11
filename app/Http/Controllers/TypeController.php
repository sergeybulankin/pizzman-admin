<?php

namespace App\Http\Controllers;

use App\Type;
use App\UserRole;
use Illuminate\Http\Request;
use App\Library\UploadImage;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    public $path = 'types';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        return view('components.types.create', compact('role_id'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $types = Type::all();

        return view('components.types.list', compact('types', 'role_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name_type' => 'required|min:3',
            'image' => 'required'
        ]);

        $name = $request->name_type;
        $image = UploadImage::upload($request->image, $this->path);

        $type = new Type();
        $type->name = $name;
        $type->icon = $image;
        $type->save();

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

        $type = Type::find($request->id);

        return view('components.types.edit', compact('role_id', 'type'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name_type' => 'required|min:3'
        ]);

        $name = $request->name_type;
        if ($request->image != null) {
            UploadImage::delete($request->type_id, $this->path, Type::class);
            $image = UploadImage::upload($request->image, $this->path);
        }

        $type = Type::find($request->type_id);
        $type->name = $name;
        if ($request->image != null) {
            $type->icon = $image;
        }
        $type->save();

        return redirect('/list/types')->with('success', 'Данные обновились');
    }
}
