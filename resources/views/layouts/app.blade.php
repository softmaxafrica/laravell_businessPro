<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Include Bootstrap CSS via CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS styles -->
    <style>
        body {
            background-color: #eee; /* Light grey background */
            color: #495057; /* Dark grey text */
            padding: 20px; /* Margin for all sides */
        }
        .navbar {
            margin-top: -20px;
            border-bottom: 1px solid #dee2e6;
            background-color: #343a40; /* White navbar */
            /* Light border under navbar */
        }
        .navbar-brand {
            color: orange; /* Blue color for brand */
            font-weight: bold;
            display: flex;
            align-items: center; /* Center items vertically */
        }
        .navbar-brand img {
            width: 40px; /* Logo width */
            margin-right: 10px; /* Space between logo and text */
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
            transition: 0.3s;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1); /* Shadow for sidebar */
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #ffffff;
            display: block;
            transition: 0.3s;
            border-radius: 5px; /* Rounded corners for links */
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .sidebar .active {
            background-color: #007bff;
            color: #ffffff;
        }
        .sidebar-toggler {
            margin-left: 250px;
            margin-top: 10px;
            transition: margin-left 0.3s;
        }
        .sidebar-toggler.collapsed {
            margin-left: 0;
        }
        .main-content {
            margin-left: 270px; /* Adjusted for padding */
            padding: 20px;
            transition: margin-left 0.3s;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Shadow for main content */
            border-radius: 10px; /* Rounded corners for main content */
            background-color: #ffffff; /* White background for content */
            margin-top: 20px; /* Top margin */
        }
        .collapsed-sidebar .sidebar {
            width: 0;
            padding-top: 0;
            overflow: hidden;
        }
        .collapsed-sidebar .main-content {
            margin-left: 0;
        }
        @media (max-width: 768px) {
            body {
                padding: 0;
            }
            .sidebar {
                width: 0;
                padding-top: 0;
                overflow: hidden;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggler {
                margin-left: 0;
            }
            body:not(.collapsed-sidebar) .sidebar {
                width: 250px;
                padding-top: 20px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <button class="btn btn-primary sidebar-toggler" id="sidebarToggle">☰</button>
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo"> {{ config('app.name', 'Business Pro') }}
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"> 
                <a class="nav-link" style="color: orange" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <div class="sidebar" id="sidebar">
        <a class="nav-link {{ Request::is('sales*') ? 'active' : '' }}" href="{{ route('sales.index') }}">Sales</a>
        <a class="nav-link {{ Request::is('stocks*') ? 'active' : '' }}" href="{{ route('stocks.index') }}">Stock Management</a>
        <a class="nav-link {{ Request::is('expenses*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">Expenses</a>
        <a class="nav-link {{ Request::is('transactions*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">Transactions History</a>
        <a class="nav-link {{ Request::is('summary*') ? 'active' : '' }}" href="{{ route('summary.index') }}">Daily Summary</a>
        <a class="nav-link {{ Request::is('business*') ? 'active' : '' }}" href="{{ route('business.index') }}">Business Description</a>
    </div>

    <main class="main-content">
        @yield('content')
    </main>

    <!-- Include Bootstrap JS via CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const body = document.body;

            // Initial check for screen size
            if (window.innerWidth <= 768) {
                body.classList.add('collapsed-sidebar');
            }

            sidebarToggle.addEventListener('click', function() {
                body.classList.toggle('collapsed-sidebar');
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    body.classList.add('collapsed-sidebar');
                } else {
                    body.classList.remove('collapsed-sidebar');
                }
            });
        });
    </script>
</body>
</html>
