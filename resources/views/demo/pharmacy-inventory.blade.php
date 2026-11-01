@extends('layouts.demo')
@section('title', 'Medicine Inventory & Stock')

@push('styles')
<style>
    .cat-pill {
        display: inline-block;
        background: #fff;
        border: 1px solid var(--border);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .15s;
    }
    .cat-pill:hover, .cat-pill.active {
        background: var(--green);
        color: #fff;
        border-color: var(--green-dk);
    }
</style>
@endpush

@section('content')
<div class="page-title">Pharmacy Medicine Inventory &amp; Stock Catalog</div>
<div class="page-subtitle">Track batch stock, dosage forms, manufacturer details, and automated reorder flags.</div>

{{-- Search & Filters --}}
<div class="card" style="margin-bottom:1.4rem;">
    <div class="card-body" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div style="flex:1;min-width:240px;">
            <input type="text" id="med-search" oninput="filterMeds()" class="form-control" placeholder="🔍 Search by brand name, generic name, or batch number...">
        </div>
        <div style="display:flex;gap:6px;flex-wrap:wrap;">
            <span class="cat-pill active" onclick="setCategory(this, 'all')">All</span>
            <span class="cat-pill" onclick="setCategory(this, 'Analgesic')">Analgesic</span>
            <span class="cat-pill" onclick="setCategory(this, 'Antibiotic')">Antibiotic</span>
            <span class="cat-pill" onclick="setCategory(this, 'Antacid')">Antacid</span>
            <span class="cat-pill" onclick="setCategory(this, 'Respiratory')">Respiratory</span>
        </div>
        <button onclick="showToast('Add new batch simulation opened')" class="btn btn-green btn-sm">+ Add Medicine</button>
    </div>
</div>

{{-- Inventory Table --}}
<div class="card">
    <div class="card-header">
        <span>Formulary Items Table</span>
        <span class="badge badge-gold">6 Cataloged Batches</span>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table" id="inventory-table">
            <thead>
                <tr>
                    <th>Medicine Name &amp; Generic</th>
                    <th>Category</th>
                    <th>Form &amp; Strength</th>
                    <th>Batch #</th>
                    <th>Stock Level</th>
                    <th>Expiry Date</th>
                    <th>Stock Adjustment</th>
                </tr>
            </thead>
            <tbody>
                <tr data-category="Analgesic">
                    <td>
                        <strong>Paracetamol 500mg</strong><br>
                        <small style="color:var(--muted);">Paracetamol</small>
                    </td>
                    <td>Analgesic</td>
                    <td>Tablet &bull; 500mg</td>
                    <td>PARA-2026-A</td>
                    <td><strong style="color:var(--green);font-size:1.1rem;">1,200</strong> strips</td>
                    <td>{{ date('Y') + 2 }}-05-30</td>
                    <td>
                        <button onclick="adjustStock(this, 100)" class="btn btn-outline btn-sm">+100</button>
                        <button onclick="adjustStock(this, -50)" class="btn btn-outline btn-sm">-50</button>
                    </td>
                </tr>
                <tr data-category="Antacid">
                    <td>
                        <strong>Omeprazole 20mg</strong><br>
                        <small style="color:var(--muted);">Omeprazole</small>
                    </td>
                    <td>Antacid</td>
                    <td>Capsule &bull; 20mg</td>
                    <td>OMEP-2026-C</td>
                    <td><strong style="color:var(--green);font-size:1.1rem;">800</strong> caps</td>
                    <td>{{ date('Y') + 1 }}-11-15</td>
                    <td>
                        <button onclick="adjustStock(this, 50)" class="btn btn-outline btn-sm">+50</button>
                    </td>
                </tr>
                <tr data-category="Antibiotic" style="background:#fffcf5;">
                    <td>
                        <strong>Amoxicillin 500mg</strong><br>
                        <small style="color:var(--muted);">Amoxicillin Trihydrate</small>
                    </td>
                    <td>Antibiotic</td>
                    <td>Capsule &bull; 500mg</td>
                    <td>AMOX-2026-D</td>
                    <td><strong>450</strong> caps</td>
                    <td>{{ date('Y') + 1 }}-08-20</td>
                    <td>
                        <button onclick="adjustStock(this, 50)" class="btn btn-outline btn-sm">+50</button>
                    </td>
                </tr>
                <tr data-category="Respiratory">
                    <td>
                        <strong>Salbutamol Inhaler 100mcg</strong><br>
                        <small style="color:var(--muted);">Salbutamol</small>
                    </td>
                    <td>Respiratory</td>
                    <td>Inhaler &bull; 100mcg</td>
                    <td>SALB-2026-E</td>
                    <td><strong>85</strong> units</td>
                    <td>{{ date('Y') + 1 }}-04-10</td>
                    <td>
                        <button onclick="adjustStock(this, 20)" class="btn btn-outline btn-sm">+20</button>
                    </td>
                </tr>
                <tr data-category="Antibiotic" style="background:#fdf6f6;">
                    <td>
                        <strong>Azithromycin 500mg</strong><br>
                        <small style="color:var(--muted);">Azithromycin</small>
                    </td>
                    <td>Antibiotic</td>
                    <td>Tablet &bull; 500mg</td>
                    <td>AZI-2026-L2</td>
                    <td><span class="badge badge-red">10 strips (Low)</span></td>
                    <td>{{ date('Y') + 1 }}-02-14</td>
                    <td>
                        <button onclick="adjustStock(this, 50)" class="btn btn-green btn-sm">+ Restock 50</button>
                    </td>
                </tr>
                <tr data-category="Analgesic" style="background:#fdfcf4;">
                    <td>
                        <strong>Oral Rehydration Salts (ORS)</strong><br>
                        <small style="color:var(--muted);">Electrolyte Powder</small>
                    </td>
                    <td>Electrolyte</td>
                    <td>Sachet &bull; Standard</td>
                    <td>ORS-2026-E1</td>
                    <td>150 sachets</td>
                    <td><span class="badge badge-yellow">Exp: 28 Days</span></td>
                    <td>
                        <button onclick="showToast('Batch flagged for inspection')" class="btn btn-outline btn-sm">Inspect</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterMeds() {
        const query = document.getElementById('med-search').value.toLowerCase();
        const rows = document.querySelectorAll('#inventory-table tbody tr');
        rows.forEach(r => {
            const text = r.innerText.toLowerCase();
            r.style.display = text.includes(query) ? '' : 'none';
        });
    }

    function setCategory(el, cat) {
        document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
        el.classList.add('active');
        const rows = document.querySelectorAll('#inventory-table tbody tr');
        rows.forEach(r => {
            if (cat === 'all' || r.getAttribute('data-category') === cat) {
                r.style.display = '';
            } else {
                r.style.display = 'none';
            }
        });
    }

    function adjustStock(btn, amount) {
        showToast('Stock adjustment simulated (' + (amount > 0 ? '+' : '') + amount + ')');
    }
</script>
@endsection
