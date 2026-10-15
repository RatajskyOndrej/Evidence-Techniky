@extends('layouts.app')

@section('content')

    <!-- Navigace zpět -->
    <a href="{{ route('equipment.index') }}" class="back-link">
        ← Zpět na seznam
    </a>

    <!-- Nadpis detailu zařízení -->
    <div class="page-heading">
        <div>
            <p class="eyebrow">DETAIL ZAŘÍZENÍ</p>
            <h1>{{ $equipment->name }}</h1>
            <p class="muted">Evidenční číslo: #{{ $equipment->inventory_number }}</p>
        </div>

        <a href="{{ route('equipment.edit', $equipment) }}"
           class="btn btn-outline-light">
            Upravit zařízení
        </a>
    </div>

    <!-- Základní informace -->
    <div class="stats-grid">
        <div class="stat-card">
            <span>Stav zařízení</span>
            <div class="stat-value">
                @if($equipment->status === 'active')
                    <span class="status status-active">Aktivní</span>
                @elseif($equipment->status === 'service')
                    <span class="status status-service">V servisu</span>
                @else
                    <span class="status status-retired">Vyřazené</span>
                @endif
            </div>
        </div>

        <div class="stat-card">
            <span>Datum nákupu</span>
            <div class="stat-value">
                {{ \Carbon\Carbon::parse($equipment->purchased_at)->format('d.m.Y') }}
            </div>
        </div>

        <div class="stat-card">
            <span>Celkové servisní náklady</span>
            <div class="stat-value price">
                {{ number_format($totalCost, 2, ',', ' ') }} Kč
            </div>
        </div>
    </div>

    <!-- Formulář pro přidání nového servisu -->
    <div class="panel mb-4">
        <div class="panel-header">
            <div>
                <h2>Nový servisní zásah</h2>
                <p class="muted mb-0">Zaznamenejte provedenou opravu nebo údržbu.</p>
            </div>
        </div>

        <form action="{{ route('service-records.store', $equipment) }}"
              method="POST" class="service-form">
            @csrf

            <!-- Popis provedeného servisu -->
            <div class="mb-3">
                <label class="form-label">Popis servisního zásahu</label>
                <textarea name="description"
                          class="form-control"
                          rows="3"
                          maxlength="2000"
                          placeholder="Např. výměna poškozeného kabelu"
                          required>{{ old('description') }}</textarea>
            </div>

            <div class="row g-3">
                <!-- Datum servisu -->
                <div class="col-md-6">
                    <label class="form-label">Datum servisu</label>
                    <input type="date"
                           name="serviced_at"
                           class="form-control"
                           value="{{ old('serviced_at', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           required>
                </div>

                <!-- Cena servisního zásahu -->
                <div class="col-md-6">
                    <label class="form-label">Cena servisu (Kč)</label>
                    <input type="number"
                           name="cost"
                           class="form-control"
                           placeholder="0.00"
                           min="0"
                           max="99999999.99"
                           step="0.01"
                           value="{{ old('cost') }}"
                           required>
                </div>
            </div>

            <!-- Uložení servisního záznamu -->
            <button type="submit" class="btn btn-primary mt-4">
                + Uložit servisní zásah
            </button>
        </form>
    </div>

    <!-- Servisní historie konkrétního zařízení -->
    <div class="panel">
        <div class="panel-header">
            <div>
                <h2>Servisní historie</h2>
                <p class="muted mb-0">Přehled všech provedených zásahů</p>
            </div>

            <span class="count-label">
            {{ $equipment->serviceRecords->count() }} záznamů
        </span>
        </div>

        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                <tr>
                    <th>Datum servisu</th>
                    <th>Popis zásahu</th>
                    <th>Cena</th>
                </tr>
                </thead>
                <tbody>
                @forelse($equipment->serviceRecords as $record)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($record->serviced_at)->format('d.m.Y') }}
                        </td>
                        <td>{{ $record->description }}</td>
                        <td class="price">
                            {{ number_format($record->cost, 2, ',', ' ') }} Kč
                        </td>
                    </tr>
                @empty
                    <!-- Zpráva, pokud zařízení zatím nemá servis -->
                    <tr>
                        <td colspan="3" class="empty-state">
                            Zatím nebyl přidán žádný servisní zásah.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
