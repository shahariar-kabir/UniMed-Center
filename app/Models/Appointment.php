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
        $year = date('Y');
        $prefix = "APT-{$year}-";

        $latest = static::where('appointment_number', 'like', "{$prefix}%")
            ->latest('id')
            ->value('appointment_number');

        $nextSeq = 1;
        if ($latest && preg_match('/APT-\d{4}-(\d+)/', $latest, $m)) {
            $nextSeq = ((int) $m[1]) + 1;
        }

        do {
            $number = sprintf('APT-%s-%04d', $year, $nextSeq);
            $nextSeq++;
        } while (static::where('appointment_number', $number)->exists());

        return $number;
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
