<?php

namespace App\Http\Controllers;

use App\Account;
use App\BlackList;
use App\Http\Resources\AccountResource;
use App\PizzmanAddress;
use App\Role;
use App\User;
use App\UserPoint;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $user = Auth::user()->id;

        $account = User::with('account')->where('id', $user)->first();

        $roles = Role::all();

        $points = PizzmanAddress::all();

        return view('components.users.create', compact('roles', 'account', 'points'));
    }

    /**
     * @return mixed
     */
    public function show()
    {
        $user = Auth::user()->id;

        $account = User::with('account')->where('id', $user)->first();

        $accounts = Account::with('user', 'role', 'black_list')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('components.users.list', compact('accounts', 'account'));
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

        $points = PizzmanAddress::all();

        return view('components.users.edit', compact('roles', 'account', 'points', 'account_user'));
    }
    
    
    public function update(Request $request)
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

        return redirect()->back()->with('success', 'Данные обновились');        
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
}
