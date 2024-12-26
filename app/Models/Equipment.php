<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function auditoriums()
    {
        return $this->belongsToMany(Auditorium::class, 'equipment_auditorium', 'equipment_id', 'auditorium_id');
    }
}
