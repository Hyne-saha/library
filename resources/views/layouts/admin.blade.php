<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel Application')</title> <!-- Default title if not defined -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- <script src="{{ asset('js/register.js') }}"></script> -->
     
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>

    <div class="container-fluid">
    <div class="row flex-nowrap">
            <!-- Sidebar -->

            @php
                    $adminusers = session('adminusers'); 
            @endphp


             @if(isset($adminusers) && !empty($adminusers))
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                    @include('admin.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col py-3">
                    @yield('content')  <!-- Content will be injected here -->
                </div>
            @else
                <div class="col py-3">
                    @yield('content')  <!-- Content will be injected here -->
                </div>
             @endif
            
        </div>
    </div>

    

    @yield('scripts')

    <!-- Footer Section  -->
    <footer>
        <p>&copy; 2025 Your Company. All rights reserved.</p>
    </footer>
    <script>
    // Pass APP_URL from Laravel to JavaScript
        window.appUrl = "{{ config('app.url') }}";
    </script>
</body>
</html>