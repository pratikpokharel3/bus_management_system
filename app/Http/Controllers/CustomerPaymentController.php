<?php

namespace App\Http\Controllers;

use App\Models\Payment;

class CustomerPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('customer_id', auth()->id())
            ->with('bank', 'booking')
            ->paginate(10);

        return view('customer.payment.index', [
            'payments' => $payments
        ]);
    }
}
