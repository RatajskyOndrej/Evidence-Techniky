<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TechManager | Evidence techniky</title>

    <!-- Bootstrap pro formuláře a responzivní rozložení -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Naše vlastní styly pro tmavý design -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=2">
</head>

<body>

<!-- Horní navigační panel -->
<nav class="topbar">
    <div class="container">
        <a href="{{ route('equipment.index') }}" class="brand">
            <span class="brand-icon">T</span>
            <span>
                TechManager
                <small>Evidence firemního vybavení</small>
            </span>
        </a>

        <a href="{{ route('equipment.index') }}" class="nav-item-link">
            Přehled zařízení
        </a>
    </div>
</nav>

<!-- Hlavní obsah aplikace -->
<main class="container main-content">

    <!-- Zpráva po úspěšné akci -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Chyby při vyplnění formuláře -->
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Formulář obsahuje chyby:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Obsah konkrétní Blade stránky -->
    @yield('content')

</main>

</body>
</html>
