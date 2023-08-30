<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;

use App\Enums\Gender;
use App\Enums\UserRole;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Enum;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', auth()->id())
            ->whereIn('user_role', ['admin', 'staff'])
            ->latest()
            ->filter(request(['search']))
            ->paginate(10);

        return view('user.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('user.create', [
            'locations' => Location::all()
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|max:255|unique:users,email',
                'gender' =>  ['required', new Enum(Gender::class)],
                'phone_number' => 'required|digits:10|unique:users,phone_number',
                'location_id' => 'required',
                'user_role' =>  ['required', new Enum(UserRole::class)],
                'password' => ['required', Rules\Password::defaults()],
            ],
            [
                'location_id.required' => 'The location field is required.'
            ]
        );

        //TODO: Don't allow users to change their user_role to super_admin
        $user = new User($attributes);
        $user->user_role = $request->user_role;
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'User Added Successfully.');
    }

    public function show(User $user)
    {
        return view('user.show', [
            'user' => $user->load('location')
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate(
            [
                'user_id' => 'required',
                'user_role' =>  ['required', new Enum(UserRole::class)],
            ]
        );

        $user->user_role = $request->user_role;
        $user->save();

        return back()->with('success', 'User Role Changed Successfully.');
    }
}
