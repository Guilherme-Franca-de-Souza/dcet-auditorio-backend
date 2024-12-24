<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditorium extends Model
{
    protected $table = 'auditoriums';

    protected $guarded = [];

    use HasFactory;

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function equipment()
    {
        return $this->hasMany(Auditorium::class, 'equipment_auditorium');
    }
}
