@extends('layouts.app')

@section('content')

    <h2 class="mb-4">{{ $equipment->name }}</h2>

    <!-- Základní informace o zařízení -->
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Evidenční číslo:</strong> {{ $equipment->inventory_number }}</p>

            <p>
                <strong>Stav:</strong>

                @if($equipment->status === 'active')
                    <span class="badge bg-success">Aktivní</span>
                @elseif($equipment->status === 'service')
                    <span class="badge bg-warning text-dark">V servisu</span>
                @else
                    <span class="badge bg-danger">Vyřazeno</span>
                @endif
            </p>

            <p><strong>Datum nákupu:</strong> {{ $equipment->purchased_at }}</p>

            <!-- Celková cena všech servisních zásahů -->
            <p>
                <strong>Celkové servisní náklady:</strong>
                {{ number_format($totalCost, 2, ',', ' ') }} Kč
            </p>
        </div>
    </div>

    <!-- Servisní historie zařízení -->
    <h3>Servisní historie</h3>

    <table class="table table-bordered">
        <thead class="table-dark">
        <tr>
            <th>Datum servisu</th>
            <th>Popis</th>
            <th>Cena</th>
        </tr>
        </thead>

        <tbody>
        @forelse($equipment->serviceRecords as $record)
            <tr>
                <td>{{ $record->serviced_at }}</td>
                <td>{{ $record->description }}</td>
                <td>{{ number_format($record->cost, 2, ',', ' ') }} Kč</td>
            </tr>
        @empty
            <!-- Zařízení zatím nemá žádný servis -->
            <tr>
                <td colspan="3" class="text-center">
                    Žádné servisní záznamy.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <a href="{{ route('equipment.index') }}" class="btn btn-secondary">
        Zpět na seznam
    </a>

@endsection
