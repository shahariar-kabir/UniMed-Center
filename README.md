# University Medical Centre &mdash; UI Concept & Prototype Demo App

This is an **initial UI Demo / Prototype Application** created to showcase the visual design, screen layout ideas, component ergonomics, and user flows of the University Medical Center Management System.

> [!NOTE]
> In this demo application, the **frontend UI design ideas are implemented**, while the **complex backend database engines/transactions are decoupled/not yet implemented**. All screens are fully interactive and pre-populated with realistic healthcare mockups, allowing immediate click-through exploration without database constraints or authentication hurdles.

---

## 🚀 How to Run the Demo App

```bash
cd demo_ui_app
php artisan serve --port=8000
```

Open your browser at: **[http://localhost:8000](http://localhost:8000)**

---

## 🎭 1-Click Role Switcher Toolbar

At the very top of every screen, an interactive toolbar allows you to instantly preview different system perspectives:

- **🌐 Landing Page & Overview** (`/`): System landing portal and service directories.
- **👤 Patient Portal** (`/patient/dashboard`):
  - **Dashboard**: Live queue ticket overview, upcoming visits, recent prescriptions.
  - **Book Appointment** (`/patient/appointments`): Department & doctor selectors, interactive time-slot chips.
  - **Live Queue Display** (`/patient/queue`): Real-time counter display with interactive "Advance Simulated Queue" button.
  - **Medical Profile** (`/patient/profile`): Emergency contact and allergy records.
  - **Patient Registration** (`/patient/register`): Intake form with institutional student/staff identity validation idea.
- **🩺 Doctor Desk** (`/doctor/dashboard`):
  - **Consultation Queue** (`/doctor/queue`): Calling waiting patients, skip/complete actions.
  - **Patient Medical History** (`/doctor/patient-history`): Timeline of past diagnoses, vitals baseline, and critical allergy alert banner.
  - **E-Prescription Builder** (`/doctor/prescriptions/create`): Dynamic multi-row medication builder where you can dynamically add/remove medicine rows with JavaScript.
  - **Printable Rx Document** (`/doctor/prescription/preview`): Formatted printable prescription layout with doctor letterhead, Rx symbol, items table, and signature block.
- **💊 Pharmacy Module** (`/pharmacy/dashboard`):
  - **Pharmacy Dashboard**: Stock alerts and orders awaiting fulfillment.
  - **Medicine Inventory** (`/pharmacy/inventory`): Search bar and category filters (Analgesic, Antibiotic, Antacid, etc.) with stock adjustment simulations.
  - **Dispense Counter** (`/pharmacy/dispense`): Active prescription orders with interactive "Dispense & Deduct Stock" status toggle.
- **📊 Admin Executive Analytics** (`/admin/dashboard`):
  - **Analytics Dashboard**: Footfall gauges, department workload distribution progress bars, and recent system audit logs.
  - **User & Role Management** (`/admin/users`): Campus healthcare user directory with interactive role filters (Doctors, Pharmacists, Admins, Patients).

---

## 🧪 Automated Test Verification

All 16 routes and screens are tested and verified:
```bash
php artisan test --compact
```
Result: 100% passing tests (17 assertions, 0 errors).
