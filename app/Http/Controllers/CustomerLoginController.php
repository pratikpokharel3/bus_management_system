<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerLoginController extends Controller
{
    public function check_user()
    {
        if (Auth::check()) {
            $kyc_info = [
                'is_kyc_verified' => false,
                'message' => "You can't book tickets at the moment since your KYC is not verified. Please update your profile information to get your KYC verified."
            ];

            $user = auth()->user();

            if ($this->check_if_kyc_is_verified($user)) {
                $kyc_info = [
                    'is_kyc_verified' => true,
                    'message' => 'Your KYC is verified.'
                ];
            }

            return response()->json([
                'kyc_info' => $kyc_info,
                'is_user_logged_in' => true,
                'message' => "User Authenticated!",
                'user' => auth()->user(),
            ]);
        }

        return response()->json([
            'is_user_logged_in' => false,
            'message' => "User Unauthenticated!",
        ]);
    }

    public function check_if_kyc_is_verified($user = null)
    {
        if ($user == null) {
            $user = auth()->user();
        }

        $is_kyc_verified = false;

        if ($user->gender !== null && $user->phone_number !== null && $user->location_id !== null) {
            $is_kyc_verified = true;
        }

        return $is_kyc_verified;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $kyc_info = [
                'is_kyc_verified' => false,
                'message' => "You can't book tickets at the moment since your KYC is not verified. Please update your profile information to get your KYC verified."
            ];

            if ($this->check_if_kyc_is_verified(auth()->user())) {
                $kyc_info = [
                    'is_kyc_verified' => true,
                    'message' => 'Your KYC is verified.'
                ];
            }

            return response()->json([
                'kyc_info' => $kyc_info,
                'is_user_logged_in' => true,
                'message' => "User Authenticated!",
                'user' => auth()->user(),
            ]);
        }

        return response()->json([
            'message' => 'Invalid Login Credentials!'
        ], 401);
    }

    public function register(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $attributes['password'] = Hash::make($request->password);
        $attributes['user_role'] = UserRole::CUSTOMER->value;
        User::create($attributes);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $kyc_info = [
                'is_kyc_verified' => false,
                'message' => "You can't book tickets at the moment since your KYC is not verified. Please update your profile information to get your KYC verified."
            ];

            return response()->json([
                'kyc_info' => $kyc_info,
                'is_user_logged_in' => true,
                'message' => "User Authenticated!",
                'user' => auth()->user(),
            ]);
        }

        return response()->json([
            'message' => 'Invalid Login Credentials!'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return response()->json([
            'message' => "You have been logged out."
        ]);
    }
}
