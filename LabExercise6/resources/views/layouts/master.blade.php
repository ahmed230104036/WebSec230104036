<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basic Website - @yield('title')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    @include('layouts.menu')
    <div class="container">
        @yield('content')
    </div>

    <!-- Floating Action Button for Cryptography -->
    <div style="position: fixed; bottom: 30px; right: 30px; z-index: 1000;">
        <a href="{{ route('crypto.simple') }}" class="btn btn-danger btn-lg rounded-circle shadow-lg"
           style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;"
           data-bs-toggle="tooltip" data-bs-placement="left" title="Cryptography Tools">
            <i class="fas fa-lock fa-lg"></i>
        </a>
    </div>

    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>