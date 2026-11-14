<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user());
        }

        return view('auth.login');
    }

    public function showAdminRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user());
        }

        return view('auth.admin-register');
    }

    public function registerAdmin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('users', 'email')->where(fn ($q) => $q->where('role', 'admin')),
            ],
            'password' => 'required|string|min:6|confirmed',
            'university_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'university_id')->where(fn ($q) => $q->where('role', 'admin')),
            ],
            'designation' => 'required|string|max:100',
            'department' => 'nullable|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'university_id' => $validated['university_id'],
            'phone' => $validated['phone'],
            'department' => $validated['department'] ?? 'Medical Administration',
            'designation' => $validated['designation'],
            'is_active' => true,
        ]);

        Auth::login($admin);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', "Administrator account for {$admin->name} registered successfully!");
    }

    public function showDoctorRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user());
        }

        return view('auth.doctor-register');
    }

    public function registerDoctor(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('users', 'email')->where(fn ($q) => $q->where('role', 'doctor')),
            ],
            'password' => 'required|string|min:6|confirmed',
            'university_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'university_id')->where(fn ($q) => $q->where('role', 'doctor')),
            ],
            'department' => 'required|string|max:100',
            'designation' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        $doctor = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'doctor',
            'university_id' => $validated['university_id'],
            'phone' => $validated['phone'],
            'department' => $validated['department'],
            'designation' => $validated['designation'],
            'is_active' => true,
        ]);

        Auth::login($doctor);
        $request->session()->regenerate();

        return redirect()->route('doctor.dashboard')->with('success', "Doctor account for Dr. {$doctor->name} registered successfully!");
    }

    public function showPharmacyRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectForRole(Auth::user());
        }

        return view('auth.pharmacy-register');
    }

    public function registerPharmacy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('users', 'email')->where(fn ($q) => $q->where('role', 'pharmacist')),
            ],
            'password' => 'required|string|min:6|confirmed',
            'university_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('users', 'university_id')->where(fn ($q) => $q->where('role', 'pharmacist')),
            ],
            'designation' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        $pharmacist = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pharmacist',
            'university_id' => $validated['university_id'],
            'phone' => $validated['phone'],
            'department' => 'Central Pharmacy',
            'designation' => $validated['designation'],
            'is_active' => true,
        ]);

        Auth::login($pharmacist);
        $request->session()->regenerate();

        return redirect()->route('pharmacy.dashboard')->with('success', "Pharmacist account for {$pharmacist->name} registered successfully!");
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'nullable|string|in:admin,doctor,pharmacist,patient',
        ]);

        $remember = $request->boolean('remember');
        $targetRole = $request->input('role');

        // Case 1: Specific role requested in the login form
        if ($targetRole) {
            $attempt = [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'role' => $targetRole,
            ];

            if (Auth::attempt($attempt, $remember)) {
                $user = Auth::user();

                if (! $user->is_active) {
                    Auth::logout();

                    return back()->withInput($request->only('email', 'role'))->withErrors(['email' => 'This account has been deactivated.']);
                }

                $request->session()->regenerate();

                return $this->redirectForRole($user)->with('success', "Welcome back, {$user->name}!");
            }

            return back()->withInput($request->only('email', 'role'))->withErrors([
                'email' => 'The provided credentials do not match our records for the selected portal role.',
            ]);
        }

        // Case 2: Auto-detect — find all active accounts matching this email
        $matchingUsers = User::where('email', $credentials['email'])
            ->where('is_active', true)
            ->get();

        $validUsers = $matchingUsers->filter(function ($u) use ($credentials) {
            return Hash::check($credentials['password'], $u->password);
        });

        if ($validUsers->isEmpty()) {
            return back()->withInput($request->only('email'))->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        // Single role account found: log directly in
        if ($validUsers->count() === 1) {
            $user = $validUsers->first();
            Auth::login($user, $remember);
            $request->session()->regenerate();

            return $this->redirectForRole($user)->with('success', "Welcome back, {$user->name}!");
        }

        // Multiple role accounts found: prompt user to choose destination portal
        session([
            'multi_role_users' => $validUsers->pluck('id')->toArray(),
            'multi_role_remember' => $remember,
        ]);

        return redirect()->route('login.choose-portal');
    }

    public function showChoosePortal(): View|RedirectResponse
    {
        $userIds = session('multi_role_users');
        if (! $userIds || empty($userIds)) {
            return redirect()->route('login');
        }

        $users = User::whereIn('id', $userIds)->where('is_active', true)->get();
        if ($users->isEmpty()) {
            return redirect()->route('login');
        }

        return view('auth.choose-portal', compact('users'));
    }

    public function selectPortal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userIds = session('multi_role_users');
        if (! $userIds || ! in_array((int) $validated['user_id'], array_map('intval', $userIds), true)) {
            return redirect()->route('login')->with('error', 'Session expired. Please sign in again.');
        }

        $user = User::find($validated['user_id']);
        if (! $user || ! $user->is_active) {
            return redirect()->route('login')->with('error', 'Account not found or deactivated.');
        }

        $remember = session('multi_role_remember', false);
        session()->forget(['multi_role_users', 'multi_role_remember']);

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return $this->redirectForRole($user)->with('success', "Welcome back, {$user->name}!");
    }

    public function switchRole(string $role): RedirectResponse
    {
        $current = Auth::user();
        if (! $current) {
            return redirect()->route('login');
        }

        $target = User::where('email', $current->email)
            ->where('role', $role)
            ->where('is_active', true)
            ->first();

        if (! $target) {
            return back()->with('error', "No active account found for role '{$role}' under your email address.");
        }

        Auth::login($target);
        request()->session()->regenerate();

        return redirect()->route($target->dashboardRoute())->with('success', 'Switched to '.ucfirst($target->role).' portal.');
    }

    public function quickLogin(string $role): RedirectResponse
    {
        $targetEmail = match ($role) {
            'admin' => 'admin@bu.edu.bd',
            'doctor' => 'doctor@bu.edu.bd',
            'pharmacist' => 'pharma@bu.edu.bd',
            'patient' => 'patient@bu.edu.bd',
            default => null,
        };

        if (! $targetEmail) {
            return redirect()->route('login')->with('error', 'Invalid role requested.');
        }

        $user = User::where('email', $targetEmail)->first();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Demo account not found. Please run seeder.');
        }

        Auth::login($user);
        request()->session()->regenerate();

        $roleLabel = $user->designation ?? ucfirst($user->role);

        return $this->redirectForRole($user)->with('success', "Logged in as {$user->name} ({$roleLabel})");
    }

    public function registerPatient(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'university_id' => [
                'required',
                'string',
                'max:50',
                'unique:patients,university_id',
                Rule::unique('users', 'university_id')->where(fn ($q) => $q->where('role', 'patient')),
            ],
            'dob' => 'required|date',
            'gender' => 'required|string',
            'blood_group' => 'nullable|string|max:5',
            'nationality' => 'nullable|string|max:50',
            'role' => 'required|string',
            'department' => 'nullable|string|max:100',
            'year' => 'nullable|string|max:50',
            'email' => [
                'required',
                'email',
                'max:200',
                Rule::unique('users', 'email')->where(fn ($q) => $q->where('role', 'patient')),
            ],
            'phone' => 'required|string|max:20',
            'emergency_name' => 'nullable|string|max:100',
            'emergency_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'allergies' => 'nullable|string|max:500',
            'conditions' => 'nullable|array',
            'medications' => 'nullable|string|max:500',
            'declaration' => 'accepted',
        ]);

        // Create User account for the patient and patient profile atomically
        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => "{$validated['first_name']} {$validated['last_name']}",
                'email' => $validated['email'],
                'password' => Hash::make('password'), // default initial password
                'role' => 'patient',
                'university_id' => $validated['university_id'],
                'phone' => $validated['phone'],
                'department' => $validated['department'] ?? null,
                'designation' => ucfirst($validated['role']),
                'is_active' => true,
            ]);

            Patient::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'university_id' => $validated['university_id'],
                'dob' => $validated['dob'],
                'gender' => $validated['gender'],
                'blood_group' => $validated['blood_group'] ?? null,
                'nationality' => $validated['nationality'] ?? 'Bangladeshi',
                'role_category' => $validated['role'],
                'department' => $validated['department'] ?? null,
                'year_semester' => $validated['year'] ?? null,
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'emergency_name' => $validated['emergency_name'] ?? null,
                'emergency_phone' => $validated['emergency_phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'allergies' => $validated['allergies'] ?? null,
                'conditions' => $validated['conditions'] ?? [],
                'medications' => $validated['medications'] ?? null,
                'is_verified' => true,
            ]);

            return $user;
        });

        // Log the newly registered patient in
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('patient.dashboard')->with('success', 'Registration successful! Your patient account has been verified and created.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    private function redirectForRole(User $user): RedirectResponse
    {
        return redirect()->route($user->dashboardRoute());
    }
}
