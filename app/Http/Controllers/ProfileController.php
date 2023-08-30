<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Bank;
use App\Models\CustomersBankInformation;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $bank = Bank::all();
        $locations = Location::all();
        $user_bank_info = CustomersBankInformation::where('customer_id', auth()->user()->id)->first();

        return view('profile.edit', [
            'user' => $request->user(),
            'banks' => $bank,
            'locations' => $locations,
            'user_bank_info' => $user_bank_info
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profile Updated Successfully.');
    }

    public function update_bank_information(Request $request)
    {
        $request->validate(
            [
                'bank_id' => 'required',
                'account_number' => 'required'
            ],
            [
                'bank_id.required' => 'The bank field is required.'
            ]
        );

        $user_bank_info = CustomersBankInformation::where('customer_id', auth()->user()->id)->first();

        if ($user_bank_info === null) {
            $bank_info = new CustomersBankInformation;
            $bank_info->customer_id = auth()->user()->id;
            $bank_info->bank_id = $request->bank_id;
            $bank_info->account_number = $request->account_number;
            $bank_info->save();
        } else {
            $user_bank_info->bank_id = $request->bank_id;
            $user_bank_info->account_number = $request->account_number;
            $user_bank_info->save();
        }

        return back()->with('success', 'Bank Information Updated Successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
