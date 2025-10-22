<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'location_text',
        'pay_min',
        'pay_max',
        'status',
        'lat',
        'lng',
        'category',
    ];

    // Relación con el usuario empleador
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    // Relación con las postulaciones
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // Relación con posibles calificaciones (a futuro)
    // public function ratings()
    // {
    //     return $this->hasMany(Rating::class);
    // }
}

