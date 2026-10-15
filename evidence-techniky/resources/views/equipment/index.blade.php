@extends('layouts.app')

@section('content')

    <!-- Nadpis stránky -->
    <div class="page-heading">
        <div>
            <p class="eyebrow">SPRÁVA VYBAVENÍ</p>
            <h1>Přehled zařízení</h1>
            <p class="muted">Evidence firemního nářadí a servisních zásahů</p>
        </div>

        <a href="{{ route('equipment.create') }}" class="btn btn-primary">
            + Přidat zařízení
        </a>
    </div>

    <!-- Souhrnné statistiky -->
    <div class="stats-grid">
        <div class="stat-card">
            <span>Celkem zařízení</span>
            <div class="stat-value">{{ $equipment->count() }}</div>
        </div>

        <div class="stat-card">
            <span>Aktivní zařízení</span>
            <div class="stat-value">
                {{ $equipment->where('status', 'active')->count() }}
            </div>
        </div>

        <div class="stat-card">
            <span>Servisní náklady</span>
            <div class="stat-value price">
                {{ number_format($equipment->sum('service_records_sum_cost'), 2, ',', ' ') }} Kč
            </div>
        </div>
    </div>

    <!-- Filtrování podle stavu -->
    <div class="panel">
        <form method="GET"
              action="{{ route('equipment.index') }}"
              class="service-form">

            <label class="form-label">Filtrovat podle stavu</label>

            <div class="row g-2">
                <div class="col-md-10">
                    <select name="status" class="form-select">
                        <option value="">Všechna zařízení</option>
                        <option value="active" @selected($status === 'active')>
                            Aktivní
                        </option>
                        <option value="service" @selected($status === 'service')>
                            V servisu
                        </option>
                        <option value="retired" @selected($status === 'retired')>
                            Vyřazená
                        </option>
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">
                        Filtrovat
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabulka všech zařízení -->
    <div class="panel">
        <div class="panel-header">
            <div>
                <h2>Seznam vybavení</h2>
                <p class="muted mb-0">Správa a servis jednotlivých zařízení</p>
            </div>
            <span class="count-label">{{ $equipment->count() }} zařízení</span>
        </div>

        <div class="table-responsive">
            <table class="table custom-table mb-0">
                <thead>
                <tr>
                    <th>Název</th>
                    <th>Evidenční číslo</th>
                    <th>Stav</th>
                    <th>Datum nákupu</th>
                    <th>Servisní náklady</th>
                    <th>Akce</th>
                </tr>
                </thead>

                <tbody>
                @forelse($equipment as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->name }}</td>

                        <td>#{{ $item->inventory_number }}</td>

                        <!-- Barevné označení stavu zařízení -->
                        <td>
                            @if($item->status === 'active')
                                <span class="status status-active">
                                    Aktivní
                                </span>
                            @elseif($item->status === 'service')
                                <span class="status status-service">
                                    V servisu
                                </span>
                            @else
                                <span class="status status-retired">
                                    Vyřazené
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->purchased_at)->format('d.m.Y') }}
                        </td>

                        <!-- Součet všech servisních zásahů zařízení -->
                        <td class="price">
                            {{ number_format($item->service_records_sum_cost ?? 0, 2, ',', ' ') }} Kč
                        </td>

                        <!-- Tlačítka pro CRUD -->
                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('equipment.show', $item) }}"
                                   class="btn btn-primary btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('equipment.edit', $item) }}"
                                   class="btn btn-outline-light btn-sm">
                                    Upravit
                                </a>

                                <form action="{{ route('equipment.destroy', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Opravdu smazat zařízení?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-outline-danger btn-sm">
                                        Smazat
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <!-- Pokud neexistuje žádné zařízení -->
                    <tr>
                        <td colspan="6" class="empty-state">
                            Nebyla nalezena žádná zařízení.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
