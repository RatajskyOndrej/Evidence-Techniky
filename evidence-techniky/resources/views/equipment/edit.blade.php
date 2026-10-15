@extends('layouts.app')

@section('content')

    <h2 class="mb-4">Upravit zařízení</h2>

    <div class="card">
        <div class="card-body">

            <!-- Formulář aktualizuje existující zařízení -->
            <form action="{{ route('equipment.update', $equipment) }}" method="POST">
                @csrf

                <!-- Laravel použije metodu PUT pro úpravu -->
                @method('PUT')

                <!-- Vložíme stejný formulář jako při vytváření -->
                @include('equipment.form')
            </form>

        </div>
    </div>

@endsection
