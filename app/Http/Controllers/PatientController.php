<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalQueue;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PatientController extends Controller
{
    private function getPatient(): Patient
    {
        return Auth::user()->getOrCreatePatient();
    }

    public function dashboard(): View
    {
        $patient = $this->getPatient();
        $today = Carbon::today();

        $activeQueue = MedicalQueue::where('patient_id', $patient->id)
            ->today()
            ->active()
            ->first();

        $upcomingAppointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->whereDate('appointment_date', '>=', $today)
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        $prescriptions = Prescription::with(['doctor', 'items'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->take(5)
            ->get();

        $patientsAhead = 0;
        if ($activeQueue && $activeQueue->status === 'waiting') {
            $patientsAhead = MedicalQueue::today()
                ->where('status', 'waiting')
                ->where('id', '<', $activeQueue->id)
                ->count();
        }

        return view('patient.dashboard', compact('patient', 'activeQueue', 'patientsAhead', 'upcomingAppointments', 'prescriptions'));
    }

    public function profile(): View
    {
        $patient = $this->getPatient();

        return view('patient.profile', compact('patient'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $patient = $this->getPatient();

        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'emergency_name' => 'nullable|string|max:100',
            'emergency_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'allergies' => 'nullable|string|max:500',
            'medications' => 'nullable|string|max:500',
        ]);

        $patient->update($validated);

        return back()->with('success', 'Profile and emergency contact information updated successfully.');
    }

    public function queue(): View
    {
        $patient = $this->getPatient();

        $todayQueues = MedicalQueue::with(['patient', 'doctor'])
            ->today()
            ->ordered()
            ->get();

        $nowCalling = $todayQueues->where('status', 'in_consultation')->first();
        $waitingCount = $todayQueues->where('status', 'waiting')->count();
        $completedCount = $todayQueues->where('status', 'completed')->count();

        $myToken = $todayQueues->where('patient_id', $patient->id)->whereIn('status', ['waiting', 'in_consultation'])->first();

        $patientsAhead = 0;
        if ($myToken && $myToken->status === 'waiting') {
            $patientsAhead = $todayQueues->where('status', 'waiting')->where('id', '<', $myToken->id)->count();
        }

        return view('patient.queue', compact('patient', 'todayQueues', 'nowCalling', 'waitingCount', 'completedCount', 'myToken', 'patientsAhead'));
    }

    public function joinQueue(Request $request): RedirectResponse
    {
        $patient = $this->getPatient();

        $existing = MedicalQueue::where('patient_id', $patient->id)
            ->today()
            ->active()
            ->first();

        if ($existing) {
            return back()->with('info', "You already have an active queue token for today: {$existing->token_number}");
        }

        $department = $request->input('department', 'General Medicine');
        $doctor = User::where('role', 'doctor')
            ->where('department', 'like', "%{$department}%")
            ->first() ?? User::where('role', 'doctor')->first();

        $queue = MedicalQueue::create([
            'token_number' => MedicalQueue::generateNextToken(),
            'queue_date' => Carbon::today(),
            'patient_id' => $patient->id,
            'doctor_id' => $doctor?->id,
            'department' => $department,
            'status' => 'waiting',
        ]);

        return redirect()->route('patient.queue')->with('success', "Queue token generated: {$queue->token_number}. Please proceed to the waiting area.");
    }

    public function appointments(): View
    {
        $patient = $this->getPatient();
        $doctors = User::where('role', 'doctor')->where('is_active', true)->get();

        $appointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->latest('appointment_date')
            ->get();

        return view('patient.appointments', compact('patient', 'doctors', 'appointments'));
    }

    public function storeAppointment(Request $request): RedirectResponse
    {
        $patient = $this->getPatient();

        $validated = $request->validate([
            'department' => 'required|string',
            'doctor_id' => 'nullable|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'reason' => 'nullable|string|max:500',
        ]);

        $appointment = $this->createAppointmentRecord($patient, $validated);

        return redirect()->route('patient.appointments')->with('success', "Appointment booked successfully! Reference: {$appointment->appointment_number}");
    }

    public function publicAppointments(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->dashboardRoute());
        }

        $doctors = User::where('role', 'doctor')->where('is_active', true)->get();
        $recentAppointments = Appointment::with(['doctor', 'patient'])->latest()->take(6)->get();

        return view('appointments.index', compact('doctors', 'recentAppointments'));
    }

    public function publicStoreAppointment(Request $request): RedirectResponse
    {
        $appointmentDate = $request->input('appointment_date') ?: $request->input('date');
        $timeSlot = $request->input('time_slot') ?: $request->input('time');
        $doctorId = $request->input('doctor_id') ?: $request->input('doctor');

        $request->merge([
            'appointment_date' => $appointmentDate,
            'time_slot' => $timeSlot,
        ]);

        $request->validate([
            'department' => 'required|string',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
        ]);

        if (Auth::check()) {
            $patient = Auth::user()->getOrCreatePatient();
        } else {
            $request->validate([
                'patient_name' => 'required|string|max:100',
                'university_id' => 'required|string|max:50',
            ]);

            $patient = Patient::where('university_id', $request->input('university_id'))->first();
            if (! $patient) {
                $nameParts = explode(' ', (string) $request->input('patient_name'), 2);
                $patient = Patient::create([
                    'first_name' => $nameParts[0],
                    'last_name' => $nameParts[1] ?? 'User',
                    'university_id' => $request->input('university_id'),
                    'dob' => '2002-01-01',
                    'gender' => 'Other',
                    'email' => strtolower(str_replace(' ', '', (string) $nameParts[0])).'@bu.edu.bd',
                    'phone' => '0188888888',
                    'role_category' => 'student',
                    'is_verified' => true,
                ]);
            }
        }

        $resolvedDoctorId = is_numeric($doctorId) ? (int) $doctorId : null;
        if (! $resolvedDoctorId && $doctorId) {
            $resolvedDoctorId = User::where('role', 'doctor')
                ->where(function ($q) use ($doctorId) {
                    $q->where('department', 'like', "%{$doctorId}%")
                        ->orWhere('name', 'like', "%{$doctorId}%");
                })->value('id');
        }
        if (! $resolvedDoctorId) {
            $resolvedDoctorId = User::where('role', 'doctor')
                ->where('department', 'like', "%{$request->input('department')}%")
                ->value('id') ?? User::where('role', 'doctor')->value('id');
        }

        $appointment = $this->createAppointmentRecord($patient, [
            'doctor_id' => $resolvedDoctorId,
            'department' => $request->input('department'),
            'appointment_date' => $appointmentDate,
            'time_slot' => $timeSlot,
            'reason' => $request->input('reason'),
        ]);

        $queueMsg = '';
        if (Carbon::parse($appointmentDate)->isToday() && $appointment->queue) {
            $queueMsg = " Live Queue Token assigned: {$appointment->queue->token_number}.";
        }

        return redirect('/appointments')->with('success', "Appointment booked successfully! Reference: {$appointment->appointment_number}. Date: {$appointment->appointment_date->format('d M Y')} at {$appointment->time_slot}.{$queueMsg}");
    }

    private function createAppointmentRecord(Patient $patient, array $data): Appointment
    {
        $appointment = Appointment::create([
            'appointment_number' => Appointment::generateNumber(),
            'patient_id' => $patient->id,
            'doctor_id' => $data['doctor_id'] ?? null,
            'department' => $data['department'],
            'appointment_date' => $data['appointment_date'],
            'time_slot' => $data['time_slot'],
            'reason' => $data['reason'] ?? null,
            'status' => 'confirmed',
        ]);

        if (Carbon::parse($data['appointment_date'])->isToday()) {
            MedicalQueue::create([
                'token_number' => MedicalQueue::generateNextToken(),
                'queue_date' => Carbon::today(),
                'patient_id' => $patient->id,
                'doctor_id' => $appointment->doctor_id,
                'appointment_id' => $appointment->id,
                'department' => $appointment->department,
                'status' => 'waiting',
            ]);
        }

        return $appointment;
    }

    public function prescriptions(): View
    {
        $patient = $this->getPatient();

        $prescriptions = Prescription::with(['doctor', 'items.medicine'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->get();

        return view('patient.prescriptions', compact('patient', 'prescriptions'));
    }

    public function showPrescription(Prescription $prescription): View
    {
        $patient = $this->getPatient();

        if (Auth::user()->isPatient() && $prescription->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access to prescription.');
        }

        $prescription->load(['doctor', 'patient', 'items.medicine']);

        return view('prescriptions.show', compact('prescription'));
    }

    public function downloadPrescriptionPdf(Prescription $prescription): Response
    {
        $patient = $this->getPatient();

        if (Auth::user()->isPatient() && $prescription->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access to prescription.');
        }

        $prescription->load(['doctor', 'patient', 'items.medicine']);

        $pdf = Pdf::loadView('prescriptions.pdf', compact('prescription'))
            ->setPaper('a4', 'portrait');

        $fileName = "Prescription-{$prescription->prescription_number}.pdf";

        return $pdf->download($fileName);
    }
}
