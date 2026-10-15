@extends('layouts.app')

@section('content')

    <h2 class="mb-4">Přidat nové zařízení</h2>

    <div class="card">
        <div class="card-body">

            <!-- Formulář pošle data do metody store -->
            <form action="{{ route('equipment.store') }}" method="POST">
                @csrf

                <!-- Vložíme společný formulář -->
                @include('equipment.form')
            </form>

        </div>
    </div>

@endsection
