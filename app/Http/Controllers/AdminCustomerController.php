<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;

class AdminCustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('user_role', UserRole::CUSTOMER->value)
            ->with('location')
            ->latest()
            ->filter(request(['search']))
            ->paginate(10);

        return view('admin_customer.index',
            [
                'customers' => $customers
            ]
        );
    }

    public function show(User $customer)
    {
        return view('admin_customer.show',
            [
                'customer' => $customer->load('location', 'bank')
            ]
        );
    }
}
