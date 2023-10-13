<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use App\Enums\Gender;
use App\Models\CustomersBankInformation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CustomerProfileController extends Controller
{
    public function get_profile_info()
    {
        $user = User::with('location')->find(auth()->id());
        $bank = CustomersBankInformation::where('customer_id', auth()->id())->first();
        $user['bank'] = $bank;

        $kyc_info = [
            'is_kyc_verified' => false,
            'message' => 'Your KYC is not verified. Please update your profile information below to get verified.'
        ];

        if ($this->check_if_kyc_is_verified($user)) {
            $kyc_info = [
                'is_kyc_verified' => true,
                'message' => 'Your KYC is verified.'
            ];
        }

        return response()->json([
            'user' => $user,
            'kyc_info' => $kyc_info
        ]);
    }

    public function store_profile_info(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'gender' => ['required', new Enum(Gender::class)],
            'phone_number' => 'required|digits:10',
            'location_id' => 'required',
            'bank_id' => 'required',
            'account_number' => 'required|max:255'
        ], [
            'location_id.required' => 'The location field is required.',
            'bank_id.required' => 'The bank field is required.',
            'account_number.required' => 'The account number field is required.',
        ]);

        $user = User::find(auth()->id());
        $user->update($attributes);

        $customer_bank_informaton = CustomersBankInformation::where('customer_id', auth()->id())->first();

        if ($customer_bank_informaton === null) {
            CustomersBankInformation::create([
                'customer_id' => auth()->id(),
                'bank_id' => $request->bank_id,
                'account_number' => $request->account_number
            ]);
        } else {
            $customer_bank_informaton->update([
                'bank_id' => $request->bank_id,
                'account_number' => $request->account_number
            ]);
        }

        return response()->json([
            'message' => 'Profile Updated Successfully.',
            'user' => $user->load('bank', 'location'),
            'kyc_info' =>  [
                'is_kyc_verified' => true,
                'message' => 'Your KYC is verified.'
            ]
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

    public function get_locations()
    {
        $locations = Location::all();

        return response()->json($locations);
    }
}
