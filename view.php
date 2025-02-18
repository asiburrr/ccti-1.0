<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Office Mastery | Skill Academy Pro</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --gradient: linear-gradient(135deg, var(--primary), var(--accent));
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 40px 70px -12px rgba(0, 0, 0, 0.15);
        }

        body {
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .bg-gradient-primary {
            background: var(--gradient);
        }

        /* Modern Breadcrumb */
        .breadcrumb-pro {
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            backdrop-filter: blur(10px);

            margin-bottom: 2rem;
            margin-top: -2rem;
        }

        .breadcrumb-pro .breadcrumb-item {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--dark);
        }

        .breadcrumb-pro .breadcrumb-item a {
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .breadcrumb-pro .breadcrumb-item a:hover {
            color: var(--primary);
            transform: translateX(4px);
        }

        .breadcrumb-pro .breadcrumb-item.active {
            color: var(--primary);
            font-weight: 600;
        }

        /* Modern Glassmorphism Effects */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-0.5rem);
        }

        /* Hero Section */
        .course-hero {
            background: linear-gradient(145deg, rgba(248, 250, 252, 0.99) 0%, rgba(99, 102, 241, 0.04) 100%);
            padding: 5rem 0 4rem;
            position: relative;
        }

        .course-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(99, 102, 241, 0.07)" fill-opacity="1" d="M0,256L48,245.3C96,235,192,213,288,197.3C384,181,480,171,576,192C672,213,768,267,864,282.7C960,299,1056,277,1152,240C1248,203,1344,149,1392,122.7L1440,96L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>');
            background-position: bottom center;
            background-size: cover;
            background-repeat: no-repeat;
            z-index: -1;
        }

        .icon-box {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 139, 0.1);
            border-radius: 50%;
        }

        .exp {
            padding: 2px;
            background: rgba(0, 0, 139, 0.1);
            border-radius: 20px;
        }

        .icon-box i {
            font-size: 18px;
        }

        /* CTA Buttons */
        .btn-cta {
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Review System */
        .review-form {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            padding: 1.5rem;
            backdrop-filter: blur(15px);
        }

        .ratio {
            aspect-ratio: 3 / 2;
        }


        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            font-size: 1.5rem;
            color: #e0e0e0;
            transition: color 0.3s ease;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: var(--accent);
        }

        /* Review Cards */
        .review-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .review-card:hover {
            transform: translateY(-5px);
        }
        .edition-badge {
    background: #00008b;
}
        /* Responsive Design */
        @media (max-width: 992px) {
            .course-hero {
                padding: 3rem 0;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .display-4 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <?php include('nav.php'); ?>

    <!-- Hero Section -->
    <section class="course-hero">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-pro">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home fa-sm"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Course</a></li>
                    <li class="breadcrumb-item"><a href="#">Computer</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Computer Office Application</li>
                </ol>
            </nav>

            <div class="row align-items-center">
    <!-- Image Column - Order first on mobile -->
    <div class="col-lg-5 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="glass-card rounded-4 shadow-sm overflow-hidden">
            <div class="ratio">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71"
                    class="img-fluid rounded-4"
                    alt="Course Preview"
                    loading="lazy">
            </div>
        </div>
    </div>

    <!-- Content Column - Order second on mobile -->
    <div class="col-lg-7 order-2 order-lg-1 text-lg-start text-left" style="text-align: left;">
        <h1 class="display-4 fw-bold mb-lg-5">Computer Office Application</h1>
        <div class="d-flex flex-wrap justify-content-between justify-content-lg-start gap-3 mb-3">
            <span class="badge bg-gradient-primary text-light rounded-pill px-3 py-2">
                <i class="fas fa-star me-1"></i> 5/5
            </span>
            <span class="badge bg-dark text-light rounded-pill px-3 py-2">
                <i class="fas fa-users me-1"></i> 1k+ Students
            </span>
            <span class="badge edition-badge text-light rounded-pill px-3 py-2">JAN-JUNE-2025</span>
        </div>

        <div class="mt-4 d-grid gap-3 d-lg-flex">
            <a href="#" class="btn btn-primary btn-lg rounded-pill shadow-sm px-4">
                <i class="fas fa-rocket me-2"></i>Enroll Now - ৳6500
                <small class="opacity-75 fs-6 text-light"><del>৳8500</del></small>
            </a>
            <a href="#details" class="btn btn-outline-dark btn-lg rounded-pill shadow-sm px-4">
                <i class="fas fa-file-contract me-2"></i>Details
            </a>
        </div>
    </div>
</div>

        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4" id="details">
        <div class="container">
            <div class="row g-3">
                <!-- Sidebar for mobile first -->
                <div class="col-lg-4 order-lg-2">

                    <div class="glass-card p-4 mb-3 rounded-lg shadow-sm bg-white">
                        <h5 class="text-uppercase color-primary fw-semibold mb-3">Key Features</h5>
                        <ul class="list-unstyled m-0">
                            <li class="d-flex align-items-center py-3 border-bottom">
                                <div class="icon-box d-flex justify-content-center align-items-center">
                                    <i class="far fa-clock color-primary"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 fw-medium">Duration</h6>
                                    <small class="">6 Months</small>
                                </div>
                            </li>
                            <li class="d-flex align-items-center py-3 border-bottom">
                                <div class="icon-box d-flex justify-content-center align-items-center">
                                    <i class="fas fa-chalkboard-teacher color-primary"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 ">Total Classes</h6>
                                    <small class="">24+ Class</small>
                                </div>
                            </li>
                            <li class="d-flex align-items-center py-3">
                                <div class="icon-box d-flex justify-content-center align-items-center">
                                    <i class="fas fa-question-circle color-primary"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 fw-medium">Total Exams</h6>
                                    <small class="">6+ Exam</small>
                                </div>
                            </li>
                        </ul>
                    </div>



                    <!-- Instructor Card -->
                    <div class="glass-card p-4 shadow-sm">
                        <h5 class="text-uppercase color-primary fw-semibold mb-3">Instructors</h5>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="avatar">
                                <img src="https://asiburrahman.com/img/aravi_3.jpg" width="50" height="50" class="rounded-circle shadow-sm" style="object-fit: cover;" alt="Asibur Rahman Aravi">
                            </div>

                            <div>
                                <h5 class="mb-1 fw-semibold text-dark">Asibur Rahman Aravi</h5>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted">3+ Years Experience</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-8 order-lg-1">
                    <!-- Overview -->
                    <div class="glass-card p-4 mb-4 shadow-sm">
                        <h5 class="text-uppercase color-primary fw-semibold mb-3 mb-2">Overview</h5>
                        Details
                    </div>
                    <!-- Review Form -->
                    <div class="glass-card shadow-sm">
                        <form id="reviewForm" class="review-form">
                            <h4 class="color-primary">Write a Review</h4>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-4">
                                    <div class="star-rating">
                                        <fieldset class="d-flex gap-1 flex-row-reverse">
                                            <input type="radio" id="star5" name="rating" value="5">
                                            <label for="star5"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star4" name="rating" value="4">
                                            <label for="star4"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star3" name="rating" value="3">
                                            <label for="star3"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star2" name="rating" value="2">
                                            <label for="star2"><i class="fas fa-star"></i></label>
                                            <input type="radio" id="star1" name="rating" value="1">
                                            <label for="star1"><i class="fas fa-star"></i></label>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="3" name="comment" placeholder="Share your experience..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-cta w-100">Submit Review</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Reviews Section -->
                    <h5 class="mt-4 text-uppercase color-primary fw-semibold">Reviews</h5>
                    <div id="reviewsList" class="mt-4">
                        <!-- Sample Reviews -->
                        <div class="review-card p-3 shadow-sm">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="avatar avatar-sm">
                                    <img src="https://asiburrahman.com/img/aravi_3.jpg" width="40" height="40" style="object-fit: cover;" class="rounded-circle" alt="User">
                                </div>
                                <div>
                                    <h5 class="mb-0">Asbur Rahman Aravi</h5>
                                    <div class="text-accent mb-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                            </div>
                            <p>Highly recommended!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('footer.php'); ?>

    <script>
        // Review System Functionality
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const review = {
                name: formData.get('name'),
                rating: formData.get('rating'),
                comment: formData.get('comment'),
                date: new Date().toLocaleDateString()
            };

            addReviewToDOM(review);
            this.reset();
        });

        function addReviewToDOM(review) {
            const reviewsList = document.getElementById('reviewsList');
            const reviewCard = document.createElement('div');

            reviewCard.className = 'review-card p-3';
            reviewCard.innerHTML = `
                <div class="d-flex align-items-center shadow-sm gap-3 mb-3">
                    <div class="avatar avatar-sm">
                        <img src="https://i.pravatar.cc/40?${Math.random()}" class="rounded-circle" alt="User">
                    </div>
                    <div>
                        <h5 class="mb-0">${review.name}</h5>
                        <div class="text-accent mb-2">
                            ${'<i class="fas fa-star"></i>'.repeat(review.rating)}
                        </div>
                        <small class="text-muted">${review.date}</small>
                    </div>
                </div>
                <p>${review.comment}</p>
            `;

            reviewsList.prepend(reviewCard);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const stars = document.querySelectorAll(".star-rating input");

            stars.forEach(star => {
                star.addEventListener("change", function() {
                    let selectedValue = this.value;
                    let labels = document.querySelectorAll(".star-rating label");

                    labels.forEach(label => {
                        let starFor = label.getAttribute("for").replace("star", "");
                        label.style.color = starFor <= selectedValue ? "var(--accent)" : "#e0e0e0";
                    });
                });
            });
        });
    </script>
</body>

</html>