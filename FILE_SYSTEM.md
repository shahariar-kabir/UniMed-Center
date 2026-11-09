# UniMed Center File System

Project source tree. Generated dependency and build folders (`node_modules`, `vendor`, and `public/build`) are omitted.

```text
UniMed_Center/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php
│   │   │   ├── Controller.php
│   │   │   ├── DoctorController.php
│   │   │   ├── HomeController.php
│   │   │   ├── PatientController.php
│   │   │   └── PharmacyController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   ├── Models/
│   │   ├── Appointment.php
│   │   ├── MedicalQueue.php
│   │   ├── Medicine.php
│   │   ├── Patient.php
│   │   ├── Prescription.php
│   │   ├── PrescriptionItem.php
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
├── bootstrap/
│   ├── app.php
│   └── providers.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database/
│   ├── factories/
│   │   └── UserFactory.php
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_10_28_195418_add_role_and_fields_to_users_table.php
│   │   ├── 2026_10_28_195423_create_patients_table.php
│   │   ├── 2026_10_28_195424_create_medicines_table.php
│   │   ├── 2026_10_28_195425_create_appointments_table.php
│   │   ├── 2026_10_28_195426_create_medical_queues_table.php
│   │   ├── 2026_10_28_195427_create_prescriptions_table.php
│   │   ├── 2026_10_28_195428_create_prescription_items_table.php
│   │   └── 2026_11_03_125529_allow_same_email_for_multiple_roles.php
│   ├── seeders/
│   │   └── DatabaseSeeder.php
│   └── isrgrootx1.pem
├── public/
│   ├── favicon.ico
│   ├── favicon.svg
│   ├── index.php
│   └── robots.txt
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   └── users.blade.php
│       ├── appointments/
│       │   └── index.blade.php
│       ├── auth/
│       │   ├── admin-register.blade.php
│       │   ├── choose-portal.blade.php
│       │   ├── doctor-register.blade.php
│       │   ├── login.blade.php
│       │   └── pharmacy-register.blade.php
│       ├── doctor/
│       │   ├── dashboard.blade.php
│       │   ├── patient-history.blade.php
│       │   ├── prescription-create.blade.php
│       │   └── queue.blade.php
│       ├── patient/
│       │   ├── appointments.blade.php
│       │   ├── dashboard.blade.php
│       │   ├── prescriptions.blade.php
│       │   ├── profile.blade.php
│       │   └── queue.blade.php
│       ├── patients/
│       │   └── register.blade.php
│       ├── pharmacy/
│       │   ├── dashboard.blade.php
│       │   ├── dispense-list.blade.php
│       │   └── inventory.blade.php
│       ├── prescriptions/
│       │   ├── pdf.blade.php
│       │   └── show.blade.php
│       ├── layouts/
│       │   └── app.blade.php
│       ├── home.blade.php
│       └── welcome.blade.php
├── routes/
│   ├── console.php
│   └── web.php
├── storage/
│   └── app/
│       ├── .gitignore
│       ├── private/
│       │   └── .gitignore
│       └── public/
│           └── .gitignore
├── tests/
│   ├── Feature/
│   │   ├── DemoUiTest.php
│   │   ├── ExampleTest.php
│   │   ├── Feature3Test.php
│   │   └── MedicalSystemFeatureTest.php
│   ├── Unit/
│   │   └── ExampleTest.php
│   ├── Pest.php
│   └── TestCase.php
├── .editorconfig
├── .env.example
├── .gitattributes
├── .gitignore
├── .mcp.json
├── .npmrc
├── AGENTS.md
├── artisan
├── boost.json
├── CLAUDE.md
├── composer.json
├── composer.lock
├── FILE_SYSTEM.md
├── package.json
├── package-lock.json
├── phpunit.xml
├── README.md
└── vite.config.js
```

## Frontend packages

`package-lock.json` locks the npm dependency tree. The direct packages in `package.json` include Preline, Tailwind CSS, DaisyUI, Laravel Vite Plugin, Vite, and the optional Laravel Multiplex package.
