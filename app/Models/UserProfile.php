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

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Etiqueta legible del estado
    public function getVerificationStatusLabelAttribute(): string
    {
        return match ($this->verification_status) {
            'pending' => 'En revisión',
            'verified' => 'Verificado',
            'rejected' => 'Rechazado',
            default => 'No verificado',
        };
    }

    // Helpers para control lógico
    public function canEditSensitiveData(): bool
    {
        return in_array($this->verification_status, ['none', 'rejected']);
    }

    public function isPendingVerification(): bool
    {
        return $this->verification_status === 'pending';
    }

    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    public function isRejected(): bool
    {
        return $this->verification_status === 'rejected';
    }
    public function lockLevel(): int
    {
        return match ($this->verification_status) {
            'pending'       => 2,
            'verified'      => 1,
            'full_verified' => 2,
            default         => 0,
        };
    }

}
