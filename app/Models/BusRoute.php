<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusRoute extends Model
{
    use HasFactory;

    protected $fillable = ['source_location_id', 'destination_location_id', 'price'];

    public function source_location()
    {
        return $this->hasOne(Location::class, 'id', 'source_location_id');
    }

    public function destination_location()
    {
        return $this->hasOne(Location::class, 'id', 'destination_location_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
