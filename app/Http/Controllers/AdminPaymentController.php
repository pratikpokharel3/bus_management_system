<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Enums\PaymentStatus;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('customer', 'booking')
            ->latest()
            ->filter(request(['search']))
            ->paginate(10);

        return view(
            'payment.index',
            [
                'payments' => $payments
            ]
        );
    }
}
