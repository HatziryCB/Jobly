<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class   User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'tos_accepted',
        'tos_accepted_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function offers()
    {
        return $this->hasMany(Offer::class, 'employer_id');
    }
    public function applications()
    {
        return $this->hasMany(Application::class, 'employee_id');
    }
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

}
