<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'token_number',
        'queue_date',
        'patient_id',
        'doctor_id',
        'appointment_id',
        'department',
        'status',
        'called_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'queue_date' => 'date',
            'called_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public static function generateNextToken(?Carbon $date = null): string
    {
        $date = $date ?? Carbon::today();
        $lastToken = static::whereDate('queue_date', $date)->max('token_number');
        $nextNum = 101;

        if ($lastToken && preg_match('/T-(\d+)/', $lastToken, $matches)) {
            $nextNum = ((int) $matches[1]) + 1;
        }

        return "T-{$nextNum}";
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('queue_date', Carbon::today());
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByRaw("CASE WHEN status = 'in_consultation' THEN 1 WHEN status = 'waiting' THEN 2 ELSE 3 END")
            ->orderBy('id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['waiting', 'in_consultation']);
    }

    public function scopeForDoctor(Builder $query, User $doctor): Builder
    {
        return $query->where(function ($q) use ($doctor) {
            $q->where('doctor_id', $doctor->id)
                ->orWhereNull('doctor_id')
                ->orWhere('department', 'like', "%{$doctor->department}%");
        });
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}
