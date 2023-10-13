<?php

namespace App\Http\Controllers;

use App\Models\Payment;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('customer', 'bank')
            ->latest()
            ->filter(request(['search']))
            ->paginate(10);

        return view('payment.index', [
            'payments' => $payments
        ]);
    }
}
