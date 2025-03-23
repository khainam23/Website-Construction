<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ __('Admin Panel') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontendcss/bootstrap_4.6/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background-color: #f4f6f9;
            color: #555;
            /* Darker, more readable text */
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            /* Dark background */
            padding-top: 20px;
            color: #fff;
            /* White text */
            position: fixed;
            /* Fixed sidebar */
            top: 0;
            left: 0;
            width: 250px;
            /* Adjust width as needed */
            overflow-x: hidden;
            /* Prevent horizontal scroll */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            /* Smooth transition for sidebar */
        }

        .img-logo {
            max-width: 100%;
            /* Make the logo responsive */
            height: auto;
            /* Maintain aspect ratio */
            padding: 10px;
            /* Add some padding around the logo */
            display: block;
            /* Ensure it takes up the full width */
            margin: 0 auto;
            /* Center the logo horizontally */
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            /* Add a subtle border below the logo */
        }

        .sidebar a {
            padding: 12px 20px;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            /* Lighter background on hover */
        }

        .sidebar .nav-link.active {
            background-color: #007bff;
            /* Highlight active link */
            color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            /* Add a subtle shadow to the active link */
        }

        .content {
            padding: 20px;
            margin-left: 250px;
            /* Match sidebar width */
            transition: margin-left 0.3s ease;
            /* Smooth transition for content */
        }

        .card {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 20px;
            border-radius: 10px;
            /* Rounded corners for cards */
            transition: all 0.3s ease;
            /* Add transition for hover effect */
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            /* Increase shadow on hover */
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 15px;
            font-weight: 600;
            color: #333;
            border-radius: 10px 10px 0 0;
            /* Rounded corners for card header */
        }

        .card-body {
            padding: 15px;
        }

        .btn-primary {
            border-radius: 5px;
            /* Rounded corners for buttons */
            transition: all 0.3s ease;
            /* Add transition for hover effect */
        }

        .btn-primary:hover {
            background-color: #0069d9;
            /* Darken background on hover */
            border-color: #0062cc;
            /* Darken border on hover */
        }

        .btn-secondary {
            border-radius: 5px;
            /* Rounded corners for buttons */
            transition: all 0.3s ease;
            /* Add transition for hover effect */
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            /* Darken background on hover */
            border-color: #545b62;
            /* Darken border on hover */
        }

        .table {
            border-radius: 10px;
            /* Rounded corners for tables */
            overflow: hidden;
            /* Ensure rounded corners are visible */
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);
            /* Add shadow to tables */
        }

        .table thead th {
            border-bottom: 2px solid #e9ecef;
            background-color: #f8f9fa;
            /* Light background for table headers */
            color: #333;
            /* Darker text for table headers */
        }

        /* Style for the logout button */
        .logout-button {
            padding: 12px 20px;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
            background-color: #dc3545;
            /* Red background color */
            border-radius: 5px;
            /* Rounded corners */
            text-align: left;
            /* Align text to the left */
        }

        .logout-button:hover {
            background-color: #c82333;
            /* Darker red on hover */
        }

        /* Add more styles as needed */
        .form-control {
            border-radius: 5px;
            /* Rounded corners for form inputs */
        }

        .input-group-append .btn {
            border-radius: 5px;
            /* Rounded corners for search button */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky">
                    <img class="img-logo" src="{{ asset('frontendcss/images/logobmq1.png')}}" alt="">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> {{ __('Dashboard') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users"></i> {{ __('User Management') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
                                href="{{ route('admin.products.index') }}">
                                <i class="fas fa-boxes"></i> {{ __('Product Management') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}"
                                href="{{ route('admin.orders.index') }}">
                                <i class="fas fa-shopping-cart"></i> {{ __('Order Management') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"
                                href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-list"></i> {{ __('Category Management') }}
                            </a>
                        </li>
                        <!-- Add more sidebar items here -->
                    </ul>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('api.logout.post') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="nav-link logout-button" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontendcss/bootstrap_4.6/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontendcss/bootstrap_4.6/js/bootstrap.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var currentRoute = window.location.href;
            var navLinks = document.querySelectorAll('.sidebar .nav-link');

            navLinks.forEach(function (link) {
                if (link.href === currentRoute) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
    @yield('js')
</body>

</html>