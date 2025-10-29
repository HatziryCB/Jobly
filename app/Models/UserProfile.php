<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'profile_picture',
        'verification_status',
        'average_rating',
        'work_categories',
        'bio',
        'experience',
        'department',
        'municipality',
        'zone',
        'neighborhood',
        'birth_date',
        'gender',
    ];

    protected $casts = [
        'work_categories' => 'array',
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
