<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    public function auditorium()
    {
        return $this->belongsTo(Auditorium::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'equipment_reservation');
    }
}
