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
        'category',
        'description',
        'requirements',
        'duration_unit',
        'duration_quantity',
        'location_text',
        'pay_min',
        'pay_max',
        'status',
        'lat',
        'lng',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

}

