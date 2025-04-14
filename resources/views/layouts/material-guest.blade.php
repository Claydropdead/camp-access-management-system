<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CAMS') }}</title>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #1565c0;
            --secondary-color: #0d47a1;
            --accent-color: #bbdefb;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
        }
        
        main {
            flex: 1 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .auth-card {
            width: 450px;
            border-radius: 8px;
        }
        
        .auth-card .card-title {
            font-weight: 500;
            padding-bottom: 20px;
        }
        
        .auth-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .auth-logo i {
            font-size: 48px;
            color: var(--primary-color);
        }
        
        .input-field .prefix.active {
            color: var(--primary-color);
        }

        .input-field input:focus + label,
        .input-field .helper-text {
            color: var(--primary-color) !important;
        }

        .input-field input:focus {
            border-bottom: 1px solid var(--primary-color) !important;
            box-shadow: 0 1px 0 0 var(--primary-color) !important;
        }
        
        /* Checkbox styling */
        [type="checkbox"].filled-in:checked + span:not(.lever):after {
            border: 2px solid var(--primary-color);
            background-color: var(--primary-color);
        }
        
        .btn-custom {
            background-color: var(--primary-color);
        }
        
        .btn-custom:hover {
            background-color: var(--secondary-color);
        }
        
        .link-custom {
            color: var(--primary-color);
        }
        
        .link-custom:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .error-text {
            color: #f44336;
            font-size: 12px;
            margin-top: -15px;
            margin-bottom: 10px;
        }
        
        .status-success {
            padding: 10px;
            background-color: #dcedc8;
            color: #33691e;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Page Content -->
    <main>
        <div class="container">
            <div class="row">
                <div class="col s12 m8 offset-m2 l6 offset-l3">
                    <div class="card auth-card">
                        <div class="card-content">
                            <div class="auth-logo">
                                <a href="/">
                                    <i class="material-icons">security</i>
                                </a>
                            </div>
                            <!-- Title is now managed in each individual auth view -->
                            
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });
    </script>
</body>
</html>