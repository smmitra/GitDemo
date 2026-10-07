<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScratchCard</title>
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar Navigation -->
        @include('layouts.sidebar');

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            

           @yield('main_content')

        </main>
    </div>
</body>
</html>