
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Knewave&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    {{-- BARIS INI WAJIB DITAMBAHKAN UNTUK ICON FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{asset('storage/brand/brand-circle.png')}}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

     @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>VanillaBlue Photo Studio | @yield('title')</title>
  </head>
  <body>

    @if(!isset($hideNavbar))
        @include('header')
    @endif

    <main>
        @yield('container')
        @yield('scripts')
    </main>

  </body>
</html>