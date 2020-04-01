<?php

namespace App\Http\Controllers;

use App\Account;
use App\BlackList;
use App\Http\Resources\AccountResource;
use App\Http\Resources\PointResource;
use App\PizzmanAddress;
use App\Role;
use App\User;
use App\UserPoint;
use App\UserRole;
use App\Library\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public $path = 'userpic';

    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user()->id;

        $account = User::with('account')->where('id', $user)->first();

        $roles = Role::all();

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $points = PizzmanAddress::all();

        return view('components.users.create', compact('roles', 'account', 'points', 'role_id'));
    }

    /**
     * @return mixed
     */
    public function show()
    {
        $user = Auth::user()->id;

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $account = User::with('account')->where('id', $user)->first();

        $accounts = Account::with('user', 'role', 'black_list')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('components.users.list', compact('accounts', 'account', 'role_id'));
    }

    /**
     * @return mixed
     */
    public function edit(Request $request)
    {
        $user = Auth::user()->id;

        $account = User::with('account')->where('id', $user)->first();

        $account_user = Account::with('user')
            ->where('id', $request->id)
            ->first();

        $roles = Role::all();

        $role = UserRole::with('role')->where('user_id', $user)->first();

        $role_id = $role['role_id'];

        $points = PizzmanAddress::all();

        return view('components.users.edit', compact('roles', 'account', 'points', 'account_user', 'role_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $phone = $request->name;
        $password = $request->password;
        $name = $request->name_account;
        $role = $request->role;
        $point = $request->point;
        $user_id = $request->user_id;

        $user = User::all()->where('id', $user_id)->first();
        $user->name = $phone;
        $user->password = bcrypt($password);
        $user->save();

        $account = Account::all()->where('user_id', $user_id)->first();
        $account->name = $name;
        $account->second_name = '';
        $account->save();

        $user_role = UserRole::all()->where('user_id', $user_id)->first();
        $user_role->role_id = $role;
        $user_role->save();

        if ($point != 0) {
            $p = UserPoint::all()->where('user_id', $user_id)->first();
            $p->pizzman_address_id = $point;
            $p->save();
        }

        return redirect('/list/accounts')->with('success', 'Данные обновились');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|min:10',
            'password' => 'required|min:4'
        ]);

        $phone = $request->name;
        $password = $request->password;
        $name = $request->name_account;
        $role = $request->role;
        $point = $request->point;

        $user = new User();
        $user->name = $phone;
        $user->password = bcrypt($password);
        $user->email = 'admin@admin.com';
        $user->api_token = str_random(60);
        $user->remember_token = str_random(100);
        $user->save();

        $user_id = $user->id;

        $account = new Account();
        $account->user_id = $user_id;
        $account->name = $name;
        $account->second_name = '';
        $account->save();

        $user_role = new UserRole();
        $user_role->user_id = $user_id;
        $user_role->role_id = $role;
        $user_role->save();

        if ($point != 0) {
            $p = new UserPoint();
            $p->user_id = $user_id;
            $p->pizzman_address_id = $point;
            $p->save();
        }

        return redirect()->back()->with('success', 'Данные добавились');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function blackList(Request $request)
    {
        $account = Account::all()->where('id', $request->id)->first();

        $user = User::select('id')->where('id', $account->user_id)->first();

        $blocked = new BlackList();
        $blocked->user_id = $user->id;
        $blocked->note = 'бывает...';
        $blocked->save();

        return redirect()->back()->with('success', 'Пользователь занесен в черный список');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function unlockedUser(Request $request)
    {
        $account = Account::all()->where('id', $request->id)->first();

        $user = User::select('id')->where('id', $account->user_id)->first();

        BlackList::where('user_id', $user->id)->delete();

        return redirect()->back()->with('success', 'Пользователь выведен из черного списка');
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function selectDrivers()
    {
        $accounts = Account::whereHas('role', function ($query) {
            $query->where('role_id', 3);
        })->get();

        return AccountResource::collection($accounts);
    }

    /**
     * @param Request $request
     * @return AccountResource
     */
    public function account(Request $request)
    {
        $user = $request->user;

        $account = User::with('account')
            ->where('id', $user)
            ->get();

        return AccountResource::collection($account);
    }

    /**
     * Точка, на которой работает пользователь
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function accountPoint(Request $request)
    {
        $point = UserPoint::where('user_id', $request->user)->first();

        $address = PizzmanAddress::with('address_delivery')
            ->where('address_id', $point->pizzman_address_id)
            ->get();

        $result = [];
        foreach ($address as $key => $value) {
            $result[] = $value->address_delivery;
        }

        return PointResource::collection(collect($result));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editAccount(Request $request)
    {
        $account = Account::all()->where('user_id', $request->id)->first();

        $role = UserRole::with('role')->where('user_id', $request->id)->first();

        $role_id = $role['role_id'];

        return view('components.user.edit', compact('role_id', 'account'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAccount(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:5'
        ]);

        $phone = $request->name;
        $password = $request->password;
        $name = $request->name_account;
        $user_id = $request->user_id;
        if ($request->image != null) {
            UploadImage::delete($request->user_id, $this->path, Account::class, 'link');
            $image = UploadImage::upload($request->image, $this->path);
        }

        $user = User::all()->where('id', $user_id)->first();
        $user->name = $phone;
        $user->password = bcrypt($password);
        $user->save();

        $account = Account::all()->where('user_id', $user_id)->first();
        $account->name = $name;
        $account->second_name = '';
        if ($request->image != null) {
            $account->link = $image;
        }
        $account->save();

        return redirect('/list/accounts')->with('success', 'Данные обновились');
    }
}
