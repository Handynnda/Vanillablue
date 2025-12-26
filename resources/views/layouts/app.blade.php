<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VanillaBlue')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styleprofil.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer" />
  
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }
        .auth-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 80px 20px;
        }
        .auth-container {
            width: 100%;
            max-width: 950px;
            background: linear-gradient(135deg, #4a5a7c, #2a3b53);
            padding: 40px 50px;
            border-radius: 18px;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        h2 { font-size: 28px; font-weight: 700; margin-bottom: 30px; letter-spacing: 1px; text-align: center; }
        form { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 40px; }
        label { display: block; font-size: 13px; margin-bottom: 5px; }
        input { width: 92%; padding: 10px; border: none; background-color: #e0e0e0; border-radius: 4px; transition: 0.3s; color: #000; }
        input:focus { border: 2px solid #00BFFF; outline: none; background-color: #fff; }
        .btn-submit { grid-column: 2 / 1; margin-top: 20px; background-color: #00BFFF; color: #fff; font-weight: 600; padding: 12px 0; width: 150px; border: none; border-radius: 14px; cursor: pointer; font-size: 15px; transition: 0.3s; }
        .btn-submit:hover { background-color: #0099cc; }
        .text-link { text-align: right; font-size: 13px; color: #ddd; margin-top: 10px; }
        .text-link a { color: #00BFFF; text-decoration: none; font-weight: 600; }
        @media (max-width: 768px) { form { grid-template-columns: 1fr; } .text-link { text-align: left; } }
    </style>
</head>
<body>
    <section class="auth-section">
        <div class="auth-container">
            @yield('content')
            @yield('scripts')
        </div>
    </section>
</body>
</html>