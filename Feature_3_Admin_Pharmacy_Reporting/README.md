# Feature 3: Admin Module, Pharmacy Inventory & Reporting

Standalone Laravel application implementing **Feature 3** of the University Medical Center Management System.

---

## 🚀 How to Run

```bash
cd feature_apps/Feature_3_Admin_Pharmacy_Reporting
php artisan serve --port=8003
```

Visit: **[http://localhost:8003](http://localhost:8003)**

---

## 🔑 Demo Credentials

| Role | Email | Password | Quick Link |
|---|---|---|---|
| **System Administrator** | `admin@bu.edu.bd` | `password` | Top Bar > `1-Click Admin Login` |
| **Head Pharmacist** | `pharma@bu.edu.bd` | `password` | Top Bar > `1-Click Pharmacist Login` |

---

## 📦 What is Included in this App

### 1. Controllers & Models
- `app/Http/Controllers/AdminController.php` (Analytics Dashboard, User CRUD, Account Status)
- `app/Http/Controllers/PharmacyController.php` (Pharmacy Dashboard, Inventory CRUD, Low-Stock / Near-Expiry Filters, Dispense Counter with Stock Deduction)
- `app/Http/Controllers/AuthController.php`
- `app/Models/Medicine.php`
- `app/Models/User.php`
- Supporting Models: `Patient.php`, `Appointment.php`, `MedicalQueue.php`, `Prescription.php`, `PrescriptionItem.php`

### 2. Migrations
- `2026_10_28_195424_create_medicines_table.php`
- Supporting migrations: users, patients, appointments, queues, prescriptions, prescription items.

### 3. Blade Views
- `resources/views/layouts/app.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/admin/dashboard.blade.php` (Operational analytics, department metrics, system overview)
- `resources/views/admin/users.blade.php` (User management, role assignment, active/deactive controls)
- `resources/views/pharmacy/dashboard.blade.php` (Dispensing statistics, low-stock alerts, near-expiry alerts)
- `resources/views/pharmacy/inventory.blade.php` (Catalog search, category filters, stock adjustments)
- `resources/views/pharmacy/dispense-list.blade.php` (Live prescription dispensing with automatic inventory deduction)

---

## 🧪 Testing

```bash
php artisan test --compact
```
All feature tests are green and passing.
