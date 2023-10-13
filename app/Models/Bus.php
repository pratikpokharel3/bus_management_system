<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_name',
        'total_seats',
        'bus_plate_number',
        'driver_name',
        'conductor_name',
        'bus_owner',
        'bus_route_id',
        'bus_status',
        'user_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class,  'id', 'user_id');
    }

    public function bus_route()
    {
        return $this->hasOne(BusRoute::class,  'id', 'bus_route_id');
    }

    public function scopeFilter($query, $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('bus_name', 'like', '%' . $search . '%');
        });
    }
}
