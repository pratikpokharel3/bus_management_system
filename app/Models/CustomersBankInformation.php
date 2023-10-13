<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomersBankInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'bank_id',
        'account_number'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
