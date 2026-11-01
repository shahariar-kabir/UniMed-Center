# Feature 1: Core Authentication, Patient Module & Live Queue Management

Standalone Laravel application implementing **Feature 1** of the University Medical Center Management System.

---

## 🚀 How to Run

```bash
cd feature_apps/Feature_1_Auth_Patient_Queue
php artisan serve --port=8001
```

Visit: **[http://localhost:8001](http://localhost:8001)**

---

## 🔑 Demo Credentials

| Role | Email | Password | Quick Link |
|---|---|---|---|
| **Patient / Student** | `patient@bu.edu.bd` | `password` | Top Bar > `1-Click Patient Login` |
| **New Patient** | Self-Registration | Custom | Top Bar > `Register New Patient` |

---

## 📦 What is Included in this App

### 1. Routes & Middleware
- `routes/web.php` (Auth, Public Appointment Booking, Patient Portal, Live Queue)
- `app/Http/Middleware/RoleMiddleware.php`

### 2. Controllers & Models
- `app/Http/Controllers/AuthController.php` (Login, Logout, 1-Click Demo Login, Patient Registration)
- `app/Http/Controllers/PatientController.php` (Dashboard, Profile, Queue, Appointments)
- `app/Models/User.php`
- `app/Models/Patient.php`
- `app/Models/Appointment.php`
- `app/Models/MedicalQueue.php`

### 3. Migrations
- `0001_01_01_000000_create_users_table.php`
- `0001_01_01_000001_create_cache_table.php`
- `0001_01_01_000002_create_jobs_table.php`
- `2026_10_28_195418_add_role_and_fields_to_users_table.php`
- `2026_10_28_195423_create_patients_table.php`
- `2026_10_28_195425_create_appointments_table.php`
- `2026_10_28_195426_create_medical_queues_table.php`

### 4. Blade Views
- `resources/views/layouts/app.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/patients/register.blade.php`
- `resources/views/patient/dashboard.blade.php`
- `resources/views/patient/profile.blade.php`
- `resources/views/patient/queue.blade.php`
- `resources/views/patient/appointments.blade.php`
- `resources/views/appointments/index.blade.php`

---

## 🧪 Testing

```bash
php artisan test --compact
```
All feature tests are green and passing.
