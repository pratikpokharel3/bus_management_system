<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusDeparture extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'bus_route_id',
        'total_tickets',
        'seats_booked',
        'departure_datetime',
        'departure_status',
        'user_id'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function bus_route()
    {
        return $this->hasOne(BusRoute::class, 'id', 'bus_route_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->whereHas('bus', function ($query) use ($search) {
                $query->where('bus_name', 'like', '%' . $search . '%');
            });
        });
    }
}
