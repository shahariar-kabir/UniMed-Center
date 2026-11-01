<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_number',
        'patient_id',
        'doctor_id',
        'department',
        'appointment_date',
        'time_slot',
        'reason',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
        ];
    }

    public static function generateNumber(): string
    {
        $count = static::count() + 1;

        return 'APT-'.date('Y').'-'.str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function queue(): HasOne
    {
        return $this->hasOne(MedicalQueue::class, 'appointment_id');
    }

    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class, 'appointment_id');
    }
}
