<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IdentityVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dpi',
        'dpi_front',
        'selfie',
        'voucher',
        'status',
        'rejection_reason',
        'location_verified',
        'expires_at',
    ];
    protected $dates = ['expires_at', 'created_at', 'updated_at'];

    protected $casts = [
        'location_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Determina si la solicitud está expirada
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }

    // Determina si la verificación incluye residencia
    public function getHasLocationVerificationAttribute(): bool
    {
        return $this->location_verified === true && !empty($this->voucher);
    }

    // Etiqueta legible del estado
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'En revisión',
            'approved' => 'Aprobada',
            'rejected' => 'Rechazada',
            'expired' => 'Expirada',
            default => 'Desconocido',
        };
    }

    // Verifica si la solicitud sigue vigente
    public function isActive(): bool
    {
        return $this->status === 'pending' && !$this->is_expired;
    }

    // Marca como expirada
    public function expire(): void
    {
        $this->update(['status' => 'expired']);
    }
}
