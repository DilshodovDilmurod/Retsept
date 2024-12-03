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
                        <li class="nav-item">
                            <a href="#" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
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
    <footer>
        <p>&copy; {{ date('Y') }} Recipe Management. Developed with 👨🏻‍💻 by <a href="#">Dilmurod</a>.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
