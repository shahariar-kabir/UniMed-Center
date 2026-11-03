<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'university_id',
        'phone',
        'department',
        'designation',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'user_id');
    }

    public function doctorAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function prescriptionsIssued(): HasMany
    {
        return $this->hasMany(Prescription::class, 'doctor_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isPharmacist(): bool
    {
        return $this->role === 'pharmacist';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'admin' => 'admin.dashboard',
            'doctor' => 'doctor.dashboard',
            'pharmacist' => 'pharmacy.dashboard',
            'patient' => 'patient.dashboard',
            default => 'home',
        };
    }

    /**
     * @return Collection<int, User>
     */
    public function otherRoleAccounts(): Collection
    {
        return self::where('email', $this->email)
            ->where('id', '!=', $this->id)
            ->where('is_active', true)
            ->get();
    }

    public function getOrCreatePatient(): Patient
    {
        if ($this->patient) {
            return $this->patient;
        }

        $existing = Patient::where('email', $this->email)
            ->orWhere('university_id', $this->university_id)
            ->first();

        if ($existing) {
            if (! $existing->user_id) {
                $existing->update(['user_id' => $this->id]);
            }

            return $existing;
        }

        $nameParts = explode(' ', $this->name, 2);

        return Patient::create([
            'user_id' => $this->id,
            'first_name' => $nameParts[0],
            'last_name' => $nameParts[1] ?? 'User',
            'university_id' => $this->university_id ?? 'STU-'.str_pad((string) $this->id, 4, '0', STR_PAD_LEFT),
            'dob' => '2002-01-01',
            'gender' => 'Male',
            'blood_group' => 'B+',
            'nationality' => 'Bangladeshi',
            'role_category' => 'student',
            'department' => $this->department ?? 'General',
            'email' => $this->email,
            'phone' => $this->phone ?? '0188888888',
            'is_verified' => true,
        ]);
    }
}
