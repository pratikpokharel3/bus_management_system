<?php

namespace App\Http\Controllers;

use App\Models\Payment;

class CustomerPaymentController extends Controller
{
    public function get_all_payments()
    {
        $payments = Payment::where('customer_id', auth()->id())
            ->with('bank')
            ->paginate(10);

        return response()->json($payments);
    }
}
