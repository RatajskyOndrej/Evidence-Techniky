<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Evidence techniky</title>

    <!-- Načtení Bootstrapu pro vzhled aplikace -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Horní navigační lišta -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('equipment.index') }}">
            Evidence techniky
        </a>
    </div>
</nav>

<!-- Hlavní obsah stránky -->
<main class="container py-4">

    <!-- Zobrazíme zprávu po úspěšné akci -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Zobrazíme chyby validace -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Sem se vloží obsah konkrétní stránky -->
    @yield('content')

</main>

</body>
</html>
