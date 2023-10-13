<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'departure_id',
        'total_tickets',
        'seats_booked',
        'total_amount',
        'vat',
        'grand_total',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function bus_departure()
    {
        return $this->hasOne(BusDeparture::class, 'id', 'departure_id');
    }

    public function bank()
    {
        //bookings(id, customer_id)
        //customers_bank_information(id, customer_id, bank_id)
        //banks(id, bank_name)

        return $this->hasOneThrough(
            Bank::class, //Name of the final model
            CustomersBankInformation::class, //Name of the intermediate model
            'customer_id', //Foreign key on the intermediate model
            'id', //Foreign key on the final model
            'customer_id', //local key
            'bank_id' //Local key of the intermediate model
        );
    }

    public function scopeFilter($query, $filters)
    {
        $user_role = auth()->user()->user_role;

        if ($user_role == UserRole::CUSTOMER->value) {
            $query->when($filters['search'] ?? false, function ($query, $search) {
                $query->whereHas('bus_departure', function ($query) use ($search) {
                    $query->whereHas('bus', function ($query) use ($search) {
                        $query->where('bus_name', 'like', '%' . $search . '%');
                    });
                });
            });

            return;
        }

        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('customer', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        });
    }
}
