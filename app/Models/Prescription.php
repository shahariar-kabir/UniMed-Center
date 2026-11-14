<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_number',
        'patient_id',
        'doctor_id',
        'appointment_id',
        'diagnosis',
        'bp',
        'pulse',
        'temperature',
        'weight',
        'clinical_advice',
        'status',
        'dispensed_at',
        'dispensed_by',
    ];

    protected function casts(): array
    {
        return [
            'dispensed_at' => 'datetime',
        ];
    }

    public static function generateNumber(): string
    {
        $year = date('Y');
        $prefix = "RX-{$year}-";

        $latest = static::where('prescription_number', 'like', "{$prefix}%")
            ->latest('id')
            ->value('prescription_number');

        $nextSeq = 1;
        if ($latest && preg_match('/RX-\d{4}-(\d+)/', $latest, $m)) {
            $nextSeq = ((int) $m[1]) + 1;
        }

        do {
            $number = sprintf('RX-%s-%04d', $year, $nextSeq);
            $nextSeq++;
        } while (static::where('prescription_number', $number)->exists());

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

    public function dispensedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dispensed_by');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PrescriptionItem::class, 'prescription_id');
    }
}
