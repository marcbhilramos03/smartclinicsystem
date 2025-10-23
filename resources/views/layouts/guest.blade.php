    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'SmartClinic') }}</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

        <!-- Vendor CSS -->
        <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/css/sb-admin-2.min.css') }}" rel="stylesheet">

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">

        <style>
            body {
                background: url('{{ asset('images/background.jpg') }}') no-repeat center center fixed;
                background-size: cover;
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
                font-family: 'Nunito', sans-serif;
                overflow: hidden;
            }

            /* Light blue and white gradient overlay */
            .overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, #007bff, #20c997);
                background-size: 200% 200%;
                animation: gradientShift 5s ease-in-out infinite alternate;
                z-index: 1;
            }

            @keyframes gradientShift {
                0% { background-position: left top; }
                100% { background-position: right bottom; }
            }

            .content {
                position: relative;
                z-index: 2;
                text-align: center;
                color: #1a1a1a;
                animation: fadeIn 1s ease forwards;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Glass-like login card */
            .auth-card {
                background: rgba(255, 255, 255, 0.85);
                border: 1px solid rgba(255, 255, 255, 0.5);
                backdrop-filter: blur(10px);
                border-radius: 20px;
                padding: 2.5rem;
                text-align: center;
                color: #003366;
                box-shadow: 0 8px 25px rgba(0,0,0,0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .auth-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            }

            .auth-card h1 {
                font-weight: 800;
                font-size: 2.5rem;
                margin-bottom: 1rem;
                color: #00509e;
            }

            .auth-card p {
                font-size: 1.1rem;
                opacity: 0.9;
                color: #333;
            }

            .btn-get-started {
                background: linear-gradient(to right, #007bff, #00bfff);
                color: #fff;
                border-radius: 50px;
                padding: 12px 35px;
                font-size: 1.1rem;
                font-weight: 600;
                border: none;
                transition: all 0.3s ease;
            }

            .btn-get-started:hover {
                background: linear-gradient(to right, #0062cc, #009acd);
                transform: translateY(-2px);
                box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
            }

            footer {
                position: absolute;
                bottom: 15px;
                width: 100%;
                text-align: center;
                color: #555;
                font-size: 0.9rem;
                letter-spacing: 0.5px;
                z-index: 2;
            }
        </style>
    </head>

    <body>
        <div class="overlay"></div>

        <div class="content">
            @yield('content')
        </div>


        <!-- Vendor JS -->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <script src="{{ asset('vendor/js/sb-admin-2.min.js') }}"></script>
    </body>
    </html>
