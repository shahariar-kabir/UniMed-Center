<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Prescription {{ $prescription->prescription_number }} &bull; UniMedCenter</title>
    <style>
        @page {
            margin: 22px 28px 24px 28px;
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Institutional Header */
        .header-table {
            width: 100%;
            margin-bottom: 8px;
        }
        .brand-monogram {
            width: 38px;
            height: 38px;
            background: #091e3a;
            border: 2px solid #0d9488;
            border-radius: 6px;
            text-align: center;
            line-height: 36px;
            color: #ffffff;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        .header-title {
            font-size: 16px;
            font-weight: bold;
            color: #091e3a;
            margin: 0;
            padding: 0;
            letter-spacing: -0.3px;
        }
        .header-sub {
            font-size: 9px;
            color: #475569;
            margin: 2px 0 0 0;
        }
        .header-contact {
            font-size: 8px;
            color: #64748b;
            margin: 1px 0 0 0;
        }
        .rx-badge {
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            border-radius: 4px;
            padding: 4px 8px;
            text-align: right;
            display: inline-block;
        }
        .rx-number {
            font-size: 13px;
            font-weight: bold;
            color: #091e3a;
            font-family: 'Courier New', Courier, monospace;
        }
        .rx-meta-sub {
            font-size: 8.5px;
            color: #64748b;
            margin-top: 2px;
        }
        .status-pill {
            display: inline-block;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 1.5px 6px;
            border-radius: 3px;
            margin-top: 3px;
        }
        .status-dispensed {
            background: #ccfbf1;
            color: #0f766e;
            border: 1px solid #5eead4;
        }
        .status-active {
            background: #f0f9ff;
            color: #0284c7;
            border: 1px solid #bae6fd;
        }

        /* Top Accent Rule */
        .header-rule {
            border-bottom: 2.5px solid #091e3a;
            border-top: 1.5px solid #0d9488;
            height: 1px;
            margin-bottom: 10px;
        }

        /* Patient & Doctor Box */
        .parties-table {
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            margin-bottom: 10px;
            border-collapse: collapse;
        }
        .party-cell {
            padding: 7px 10px;
            vertical-align: top;
            width: 50%;
            font-size: 9.5px;
            line-height: 1.5;
        }
        .party-header {
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            color: #091e3a;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 3px;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        /* Vitals Strip */
        .vitals-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 4px;
            padding: 5px 10px;
            margin-bottom: 8px;
            font-size: 9.5px;
            color: #0369a1;
        }
        .vitals-label {
            font-weight: bold;
            color: #0284c7;
            text-transform: uppercase;
            font-size: 8.5px;
            margin-right: 8px;
        }
        .vital-item {
            margin-right: 12px;
        }
        .vital-item strong {
            color: #0f172a;
        }

        /* Diagnosis Box */
        .diagnosis-box {
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-left: 3.5px solid #0d9488;
            border-radius: 3px;
            padding: 6px 10px;
            margin-bottom: 10px;
            font-size: 10px;
        }
        .diagnosis-label {
            font-size: 8.5px;
            font-weight: bold;
            color: #0d9488;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .diagnosis-val {
            font-weight: bold;
            color: #0f172a;
            font-size: 10.5px;
        }

        /* Rx Section Heading */
        .rx-header-row {
            margin: 8px 0 6px 0;
        }
        .rx-glyph {
            font-family: 'Times New Roman', Times, Georgia, serif;
            font-size: 24px;
            font-weight: bold;
            color: #091e3a;
            line-height: 1;
        }
        .rx-glyph sub {
            font-size: 15px;
            font-style: italic;
            vertical-align: baseline;
            position: relative;
            top: 2px;
            margin-left: -1px;
        }
        .rx-section-label {
            display: inline-block;
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            color: #0d9488;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 2px 8px;
            border-radius: 3px;
            vertical-align: middle;
            margin-left: 8px;
        }

        /* Medicines Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .items-table th {
            background: #091e3a;
            color: #ffffff;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 5px 7px;
            text-align: left;
            border: none;
        }
        .items-table th.center { text-align: center; }
        .items-table td {
            padding: 6px 7px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9.5px;
            vertical-align: middle;
        }
        .items-table tr.odd {
            background: #f8fafc;
        }
        .items-table tr.even {
            background: #ffffff;
        }
        .med-name {
            font-weight: bold;
            color: #0f172a;
            font-size: 10px;
        }
        .med-generic {
            font-size: 8px;
            color: #64748b;
            margin-top: 1px;
        }
        .dosage-badge {
            font-weight: bold;
            color: #0f766e;
            background: #f0fdfa;
            border: 1px solid #99f6e4;
            padding: 1.5px 5px;
            border-radius: 3px;
            font-size: 9px;
            display: inline-block;
            font-family: 'Courier New', Courier, monospace;
        }
        .qty-badge {
            font-weight: bold;
            color: #0f172a;
        }

        /* Clinical Advice */
        .advice-box {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 3.5px solid #0d9488;
            border-radius: 3px;
            padding: 7px 10px;
            margin-bottom: 14px;
            page-break-inside: avoid;
        }
        .advice-label {
            font-size: 8.5px;
            font-weight: bold;
            color: #0d9488;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }
        .advice-content {
            font-size: 9px;
            line-height: 1.5;
            color: #334155;
        }

        /* Footer & Official Authentication */
        .footer-table {
            width: 100%;
            border-top: 1px solid #cbd5e1;
            padding-top: 8px;
            page-break-inside: avoid;
        }
        .footer-left {
            width: 58%;
            vertical-align: top;
            font-size: 8px;
            color: #64748b;
            line-height: 1.45;
        }
        .footer-right {
            width: 42%;
            vertical-align: top;
            text-align: right;
        }

        .seal-card {
            border: 1px solid #99f6e4;
            background: #f0fdfa;
            border-radius: 4px;
            padding: 4px 8px;
            display: inline-block;
            text-align: left;
            margin-bottom: 4px;
            width: 195px;
        }
        .seal-title {
            font-size: 8px;
            font-weight: bold;
            color: #091e3a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .seal-sub {
            font-size: 7.5px;
            color: #475569;
        }

        .signature-graphic {
            height: 34px;
            margin-bottom: 2px;
            text-align: right;
        }

        .signature-line-box {
            border-top: 1.5px solid #091e3a;
            width: 195px;
            margin-left: auto;
            text-align: center;
            padding-top: 3px;
        }
        .sig-doc-name {
            font-size: 10px;
            font-weight: bold;
            color: #091e3a;
        }
        .sig-doc-role {
            font-size: 8px;
            color: #475569;
        }
        .sig-doc-dept {
            font-size: 7.5px;
            color: #64748b;
        }
    </style>
</head>
<body>

@php
    function formatVitalValue(?string $val, string $unit): string {
        if (empty($val)) return 'N/A';
        $trimmed = trim($val);
        if (stripos($trimmed, $unit) !== false) return $trimmed;
        return $trimmed . ' ' . $unit;
    }

    $formattedBp = formatVitalValue($prescription->bp, 'mmHg');
    $formattedPulse = formatVitalValue($prescription->pulse, 'bpm');
    $formattedTemp = formatVitalValue($prescription->temperature, 'F');
    $formattedWeight = formatVitalValue($prescription->weight, 'kg');
@endphp

{{-- 1. Institutional Medical Header --}}
<table class="header-table">
    <tr>
        <td style="width: 44px; vertical-align: middle;">
            <div class="brand-monogram">UMC</div>
        </td>
        <td style="vertical-align: middle; padding-left: 8px;">
            <div class="header-title">UniMedCenter | University Medical Centre</div>
            <div class="header-sub">Health &amp; Clinical Services Division | Central Campus, Dhaka</div>
            <div class="header-contact">Central Pharmacy | 24/7 Emergency Shifts | Medical Hotline: 01888-888888</div>
        </td>
        <td style="text-align: right; vertical-align: middle;">
            <div class="rx-badge">
                <div class="rx-number">{{ $prescription->prescription_number }}</div>
                <div class="rx-meta-sub">Issued: {{ $prescription->created_at->format('d M Y, h:i A') }}</div>
                <div>
                    @if($prescription->status === 'dispensed')
                        <span class="status-pill status-dispensed">Dispensed at Pharmacy</span>
                    @else
                        <span class="status-pill status-active">Active Prescription</span>
                    @endif
                </div>
            </div>
        </td>
    </tr>
</table>

<div class="header-rule"></div>

{{-- 2. Patient Information & Attending Physician --}}
<table class="parties-table">
    <tr>
        <td class="party-cell" style="border-right: 1px solid #cbd5e1;">
            <div class="party-header">PATIENT INFORMATION</div>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 85px; color: #64748b; padding: 1.5px 0;">Name:</td>
                    <td style="padding: 1.5px 0;"><strong>{{ $prescription->patient->full_name }}</strong></td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">University ID:</td>
                    <td style="padding: 1.5px 0; font-family: monospace; font-weight: bold; color: #091e3a;">{{ $prescription->patient->university_id }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">Category:</td>
                    <td style="padding: 1.5px 0;">{{ ucfirst($prescription->patient->role_category) }} ({{ $prescription->patient->department ?? 'General' }})</td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">Age / Gender:</td>
                    <td style="padding: 1.5px 0;">{{ $prescription->patient->dob ? $prescription->patient->dob->age . ' yrs' : 'N/A' }} / {{ $prescription->patient->gender }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">Blood Group:</td>
                    <td style="padding: 1.5px 0;"><strong style="color: #091e3a;">{{ $prescription->patient->blood_group ?: 'Not Recorded' }}</strong></td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">Drug Allergies:</td>
                    <td style="padding: 1.5px 0;">
                        @if($prescription->patient->allergies)
                            <strong style="color: #dc2626;">{{ $prescription->patient->allergies }}</strong>
                        @else
                            <span style="color: #15803d;">None reported</span>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
        <td class="party-cell">
            <div class="party-header">ATTENDING PHYSICIAN</div>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 85px; color: #64748b; padding: 1.5px 0;">Doctor:</td>
                    <td style="padding: 1.5px 0;"><strong>Dr. {{ $prescription->doctor->name }}</strong></td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">Designation:</td>
                    <td style="padding: 1.5px 0;">{{ $prescription->doctor->designation ?? 'Senior Medical Officer' }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">Department:</td>
                    <td style="padding: 1.5px 0;">{{ $prescription->doctor->department ?? 'General Medicine' }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">Practitioner ID:</td>
                    <td style="padding: 1.5px 0; font-family: monospace;">UMC-DOC-{{ str_pad($prescription->doctor->id, 4, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">Direct Contact:</td>
                    <td style="padding: 1.5px 0;">{{ $prescription->doctor->phone ?? 'Central Hotline: 01888-888888' }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 1.5px 0;">Consultation:</td>
                    <td style="padding: 1.5px 0; color: #15803d;">Verified Clinical OPD</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- 3. Patient Vitals Strip --}}
<div class="vitals-box">
    <span class="vitals-label">Patient Vitals:</span>
    <span class="vital-item">BP: <strong>{!! $formattedBp !!}</strong></span>
    <span class="vital-item">Pulse: <strong>{!! $formattedPulse !!}</strong></span>
    <span class="vital-item">Temp: <strong>{!! $formattedTemp !!}</strong></span>
    <span class="vital-item">Weight: <strong>{!! $formattedWeight !!}</strong></span>
</div>

{{-- 4. Clinical Diagnosis --}}
<div class="diagnosis-box">
    <div class="diagnosis-label">Provisional Clinical Diagnosis</div>
    <div class="diagnosis-val">{{ $prescription->diagnosis }}</div>
</div>

{{-- 5. Rx Symbol Header (Typographic, 100% font-safe, never renders as '?') --}}
<div class="rx-header-row">
    <span class="rx-glyph">R<sub>x</sub></span>
    <span class="rx-section-label">Prescribed Medicines &amp; Dosing Schedule</span>
</div>

{{-- 6. Prescribed Medicines Table --}}
<table class="items-table">
    <thead>
        <tr>
            <th style="width: 22px;" class="center">#</th>
            <th>Medicine &amp; Formulation</th>
            <th class="center" style="width: 75px;">Dosage</th>
            <th class="center" style="width: 65px;">Duration</th>
            <th>Instructions / Advice</th>
            <th class="center" style="width: 65px;">Total Qty</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prescription->items as $idx => $item)
            @php
                $unit = $item->medicine?->unit ?? 'units';
            @endphp
            <tr class="{{ $idx % 2 === 0 ? 'even' : 'odd' }}">
                <td class="center" style="color: #64748b; font-weight: bold;">{{ $idx + 1 }}</td>
                <td>
                    <div class="med-name">{{ $item->medicine_name }}</div>
                    @if($item->medicine)
                        <div class="med-generic">{{ $item->medicine->generic_name }} | {{ $item->medicine->strength }}</div>
                    @endif
                </td>
                <td class="center">
                    <span class="dosage-badge">{{ $item->dosage }}</span>
                </td>
                <td class="center" style="font-weight: 500;">
                    {{ $item->duration }}
                </td>
                <td style="color: #334155;">
                    {{ $item->instructions ?: 'As directed by physician' }}
                </td>
                <td class="center">
                    <span class="qty-badge">{{ $item->quantity }} {{ $unit }}</span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- 7. Clinical Advice Box --}}
@if($prescription->clinical_advice)
    <div class="advice-box">
        <div class="advice-label">Clinical Advice &amp; Patient Instructions</div>
        <div class="advice-content">{!! nl2br(e($prescription->clinical_advice)) !!}</div>
    </div>
@endif

{{-- 8. Official Verification & Doctor Signature --}}
<table class="footer-table">
    <tr>
        <td class="footer-left">
            <div style="font-weight: bold; color: #091e3a; margin-bottom: 2px;">
                ELECTRONICALLY VERIFIED DIGITAL PRESCRIPTION
            </div>
            <div>
                This prescription is electronically certified by the University Medical Centre authority. Subsidized medicines can be collected directly from the Central Pharmacy counter with your student / staff ID.
            </div>
            <div style="margin-top: 4px; color: #475569;">
                <strong>Ref ID:</strong> {{ $prescription->prescription_number }} |
                <strong>Printed:</strong> {{ date('d M Y, h:i A') }}
            </div>
            {{-- Stylized security barcode / verification strip --}}
            <div style="font-family: 'Courier New', Courier, monospace; letter-spacing: 2px; font-size: 8px; color: #091e3a; margin-top: 3px;">
                ||||| | ||||| ||| ||||||| |||| | |||| |||||| |||
            </div>
        </td>
        <td class="footer-right">
            {{-- Digital Verification Seal --}}
            <div class="seal-card">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 16px; vertical-align: middle; padding: 0;">
                            <div style="width: 13px; height: 13px; background: #0d9488; border-radius: 50%; color: #ffffff; font-size: 8px; font-weight: bold; text-align: center; line-height: 13px;">V</div>
                        </td>
                        <td style="padding-left: 5px; vertical-align: middle;">
                            <div class="seal-title">Digitally Certified &amp; Signed</div>
                            <div class="seal-sub">Officer: Dr. {{ $prescription->doctor->name }}</div>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Doctor Electronic Handwritten Signature (Typographic, GD-safe, 100% reliable) --}}
            <div class="signature-graphic" style="height: auto; padding: 3px 0 2px 0; text-align: center; width: 195px; margin-left: auto;">
                <div style="font-family: 'Times-BoldItalic', 'Times New Roman', Times, serif; font-style: italic; font-size: 20px; font-weight: bold; color: #091e3a; letter-spacing: 0.5px; line-height: 1.1;">
                    Dr. {{ $prescription->doctor->name }}
                </div>
                <div style="font-family: 'Courier New', Courier, monospace; font-size: 7.5px; color: #0d9488; letter-spacing: 0.8px; margin-top: 1px;">
                    ~ electronically signed ~
                </div>
            </div>

            {{-- Signature Line with Doctor Details --}}
            <div class="signature-line-box">
                <div class="sig-doc-name">Dr. {{ $prescription->doctor->name }}</div>
                <div class="sig-doc-role">{{ $prescription->doctor->designation ?? 'Senior Medical Officer' }}</div>
                <div class="sig-doc-dept">Dept. of {{ $prescription->doctor->department ?? 'General Medicine' }} | Central Campus</div>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
