<?php

namespace App\Http\Controllers;

class CustomerBankInformationController extends Controller
{
    public function customer()
    {
        return $this->belongsTo(User::class, 'id', 'bank_id');
    }
}
