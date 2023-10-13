<?php

namespace App\Http\Controllers;

use App\Models\Bank;

class CustomerBankInformationController extends Controller
{
    public function get_all_banks()
    {
        $banks = Bank::all();

        return response()->json($banks);
    }
}
