<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    


    <style>
        /* Maxsus uslublar */
        body {
            background-color: #f8f9fa;
            /* background-color: white; */
        }
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        /* .navbar-brand {
            font-weight: bold;
            color: #343a40 !important;
        } */
        .nav-link {
            font-weight: 500;
            color: #495057 !important;
        }
        .nav-link:hover {
            color: #007bff !important;
        }
        main {
            min-height: 70vh;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        footer a {
            color: #fff;
            text-decoration: underline;
        }
        footer a:hover {
            color: #adb5bd;
        }

        .card:hover {
            transform: scale(1.05);
            transition: transform 0.2s;
        }
        .modal-body ul {
            padding-left: 20px;
        }
        .custom-brand {
            font-family: 'Poppins', sans-serif; /* Modern shrift */
            font-size: 24px; /* Brendning hajmini kattalashtirish */
            font-weight: bold; /* Qalin matn */
            color: #2c3e50; /* Klasik qora rang */
            text-transform: uppercase; /* Harflarni katta qilish */
            letter-spacing: 1px; /* Harflar orasini kengaytirish */
            text-decoration: none; /* Havorang chizig'ini olib tashlash */
        }

        .custom-brand:hover {
            color: #e74c3c; /* Hover effekti uchun qizil rang */
        }

        .brand-highlight {
            color: #3498db; /* Bir qismini ko'k rangda qilish */
            font-style: italic; /* Kursiv qilib ko'rsatish */
        }
        /* Modal Background Styling */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: none;
        }

        /* Modal Header Styling */
        .modal-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            border-bottom: 2px solid #e2e8f0;
        }

        .modal-header h5 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        /* Close Button Styling */
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        /* Modal Body Styling */
        .modal-body {
            padding: 20px;
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
        }

        /* Left Image Section Styling */
        .modal-body img {
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            margin-bottom: 10px;
        }

        /* Ingredients and Instructions Styling */
        .modal-body h6 {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .modal-body p {
            color: #4a5568;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        /* Modal Footer Styling */
        .modal-footer {
            background-color: #f7fafc;
            border-top: 2px solid #e2e8f0;
            justify-content: center;
        }

        .modal-footer .btn-secondary {
            border-radius: 20px;
            padding: 8px 20px;
            background-color: #edf2f7;
            color: #2d3748;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #e2e8f0;
            color: #1a202c;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <!-- <a class="navbar-brand" href="{{ route('recipes.index') }}">Recipe Management</a> -->
            <a class="navbar-brand custom-brand" href="{{ route('recipes.index') }}">
                <span class="brand-highlight">Recipe</span> Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('recipes.index') }}">Public Recipes</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('recipes.my') }}">My Recipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('recipes.create') }}">Create Recipe</a>
                        </li>
                        <!-- Shared Recipes Link -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('shared') }}">Shared Recipes</a> <!-- Yangi sahifaga yo'nalish -->
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> <!-- Bootstrap icon for profile -->
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a> <!-- Profil sahifasiga yo'nalish -->
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth


                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>
    <footer >
        <p>&copy; {{ date('Y') }} Recipe Management. Developed with 👨🏻‍💻 by <a href="https://github.com/DilshodovDilmurod">Dilmurod</a>.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
