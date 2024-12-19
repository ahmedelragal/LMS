<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pyramakerz LMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand, .nav-link {
            color: #f97233 !important;
            font-weight: bold;
        }

        .header {
            text-align: center;
            padding: 100px 20px;
            background-color: white;
            border-bottom: 1px solid #ddd;
        }

        .header h1 {
            color: #f97233;
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .content {
            padding: 40px 20px;
        }

        .card-custom {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border-radius: 10px;
            background-color: white;
        }

        .card-header {
            background-color: #f97233;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            font-size: 1.5rem;
        }

        .btn-custom {
            background-color: #f97233;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #d85a26;
            color: white;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f97233;
            color: white;
        }

        .footer a {
            color: white;
            text-decoration: underline;
        }

        .section-title {
            color: #f97233;
        }

        .card-body ul {
            padding-left: 1.5rem;
        }

        .card-body ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="https://pyramakerz.com/">Pyramakerz LMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1>Pyramakerz LMS</h1>
            <p>Empowering digital learning from PreK1 to Grade 12 with cutting-edge technology.</p>
            <a href="{{route('login')}}" class="btn btn-custom btn-lg">Login Now</a>
        </div>
    </header>

    <!-- Main Content -->
    <section class="content container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header">About Pyramakerz LMS</div>
                    <div class="card-body">
                        <p>
                            Pyramakerz LMS is designed to provide a seamless digital learning experience for students, teachers, and administrators. 
                            It offers a wide range of tools for managing eBooks, quizzes, assignments, and more, making it an essential platform 
                            for modern education.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Key Features Section -->
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-header">Key Features</div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Digital Learning Resources:</strong> Access eBooks, quizzes, and assignments from any device.</li>
                            <li><strong>Assignment Management:</strong> Teachers can assign tasks and monitor student progress with ease.</li>
                            <li><strong>Performance Analytics:</strong> Real-time data allows schools to analyze student performance.</li>
                            <li><strong>Customizable Curriculum:</strong> Design lessons, courses, and assessments tailored to student needs.</li>
                            <li><strong>Interactive Classrooms:</strong> Engage students with interactive lessons and quizzes.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Section -->
        <div class="card card-custom">
            <div class="card-header">Why Choose Pyramakerz LMS?</div>
            <div class="card-body">
                <p>
                    Pyramakerz LMS is not just a platform—it’s a complete digital learning ecosystem. With seamless integration, 
                    real-time performance metrics, and a user-friendly interface, it empowers educators to create immersive learning 
                    experiences. Whether you’re a teacher managing multiple classrooms or a student accessing learning materials on the go, 
                    our LMS simplifies the process for all users.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Pyramakerz LMS. All Rights Reserved. Visit us at <a href="https://pyramakerz.com/">pyramakerz.com</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
