@extends('layouts.app')

@section('content')

    <!-- Nadpis a tlačítko pro přidání zařízení -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Seznam zařízení</h2>

        <a href="{{ route('equipment.create') }}" class="btn btn-primary">
            Přidat zařízení
        </a>
    </div>

    <!-- Filtrování zařízení podle stavu -->
    <form method="GET" action="{{ route('equipment.index') }}" class="mb-4">
        <div class="d-flex gap-2">
            <select name="status" class="form-select">
                <option value="">Všechny stavy</option>
                <option value="active" @selected($status === 'active')>Aktivní</option>
                <option value="service" @selected($status === 'service')>V servisu</option>
                <option value="retired" @selected($status === 'retired')>Vyřazené</option>
            </select>

            <button type="submit" class="btn btn-dark">
                Filtrovat
            </button>
        </div>
    </form>

    <!-- Tabulka všech zařízení -->
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
        <tr>
            <th>Název</th>
            <th>Evidenční číslo</th>
            <th>Stav</th>
            <th>Datum nákupu</th>
            <th>Akce</th>
        </tr>
        </thead>

        <tbody>
        @forelse($equipment as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->inventory_number }}</td>

                <!-- Stav rozlišíme barvou i textem -->
                <td>
                    @if($item->status === 'active')
                        <span class="badge bg-success">Aktivní</span>
                    @elseif($item->status === 'service')
                        <span class="badge bg-warning text-dark">V servisu</span>
                    @else
                        <span class="badge bg-danger">Vyřazeno</span>
                    @endif
                </td>

                <td>{{ $item->purchased_at }}</td>

                <td>
                    <!-- Detail zařízení -->
                    <a href="{{ route('equipment.show', $item) }}"
                       class="btn btn-info btn-sm">Detail</a>

                    <!-- Úprava zařízení -->
                    <a href="{{ route('equipment.edit', $item) }}"
                       class="btn btn-warning btn-sm">Upravit</a>

                    <!-- Smazání zařízení -->
                    <form action="{{ route('equipment.destroy', $item) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Opravdu smazat zařízení?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Smazat
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <!-- Zpráva, pokud nejsou nalezena žádná zařízení -->
            <tr>
                <td colspan="5" class="text-center">
                    Žádná zařízení nebyla nalezena.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection
