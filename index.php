<!-- File: header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoreDeft</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="card.css?1112">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }

        .animated-entry {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.6s forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-section {
            background: linear-gradient(150deg, #f8fafc 50%, rgba(99, 102, 241, 0.05) 100%);
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            right: -10%;
            top: -50%;
            width: 70%;
            height: 200%;
            background: var(--gradient);
            opacity: 0.05;
            transform: rotate(15deg);
            z-index: 0;
        }

        .avatar-lg {
            width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid white;
    margin-left: -10px;
    /* Overlap avatars slightly */
    transition: transform 0.3s ease;
        }
        .avatar-lg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}
        .stat-pill {
            background: rgba(99, 102, 241, 0.2);
            color: var(--primary-color);
            padding: 8px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .category-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            border-color: var(--primary);
        }


        .instructor-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .instructor-card:hover .instructor-overlay {
            opacity: 1;
        }

        .instructor-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.6);
            opacity: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php include('nav.php'); ?>

    <!-- Hero Section -->
    <section class="hero-section hero-gradient">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 animated-entry" style="animation-delay: 0.2s">
                    <h1 class="display-3 fw-bold mb-4">Master In-Demand<br><span class="color-primary">Professional Skills</span></h1>
                    <p class="lead text-muted mb-5">Every career growth journey is unique. We're here to guide you every step of the way.</p>
                    
                    <div class="d-flex gap-3 mb-5">
                        <a href="#" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">Explore Courses</a>
                        <a href="#" class="btn btn-outline-dark btn-lg px-5 py-3 rounded-pill">Watch Demo</a>
                    </div>
                    <!---
                    <div class="d-flex gap-4">
                        <div class="stat-pill">
                            <span class="fw-medium">1000+</span> Active Learners
                        </div>
                        <div class="stat-pill">
                            <span class="fw-medium">850+</span> Expert Courses
                        </div>
                    </div>
    -->
                </div>
                
                <div class="col-lg-6 animated-entry" style="animation-delay: 0.4s">
                    <div class="position-relative">
                        <img src="undraw_personal-finance_98p3.svg" class="img-fluid rounded-4" alt="Online Learning">
                        <div class="position-absolute bottom-0 start-0 translate-middle-y ms-5 bg-white p-3 rounded-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class=" avatar-lg">
                                    <img src="https://cctiapp.coredeft.com/uploads/afifurrahman.jpg" class="rounded-circle" alt="Instructor">
                                </div>
                                <div>
                                    <div class="h6 mb-0 fw-medium">Afifur Rahman Arnob</div>
                                    <small class="text-muted">Chief Executive Officer(CEO)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trending Categories 
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row mb-5 animated-entry">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">Explore Trending Categories</h2>
                    <p class="text-muted">Discover courses in popular fields</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-2 animated-entry">
                    <div class="category-card text-center">
                        <div class="icon-wrapper mb-3">
                            <div class="icon-box bg-primary-light">
                                <i class="fas fa-code text-primary fs-4"></i>
                            </div>
                        </div>
                        <h5 class="mb-1">Development</h5>
                        <small class="text-muted">12 Courses</small>
                    </div>
                </div>

            </div>
        </div>
    </section>
    -->

    <!-- Featured Courses -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5 animated-entry">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h2 class="display-5 fw-bold mb-0">Featured Courses</h2>
                    <a href="#" class="btn btn-link text-decoration-none">
                        View All <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            <div class="row g-4">
                <?php include('card.php'); ?>
            </div>
        </div>
    </section>

    <!-- Instructor Section 
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5 animated-entry">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">Meet Our Experts</h2>
                    <p class="text-muted">Learn from industry-leading professionals</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 animated-entry">
                    <div class="instructor-card">
                        <img src="https://skillgro.websolutionus.com/uploads/custom-images/wsus-img-2024-06-26-06-06-24-6800.webp" class="img-fluid" alt="Instructor">
                        <div class="instructor-overlay">
                            <div class="text-center text-white">
                                <h5 class="mb-1">Ethan Granger</h5>
                                <p class="small mb-3">Senior Frontend Developer</p>
                                <div class="h4 mb-0">$1.2M+</div>
                                <small>Student Earnings</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    -->
    <?php include('footer.php'); ?>

    <!-- GSAP Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script>
        gsap.from(".animated-entry", {
            duration: 1,
            y: 50,
            opacity: 0,
            stagger: 0.1,
            ease: "power4.out"
        });
    </script>
</body>
</html>