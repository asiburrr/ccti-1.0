<?php
require '../../common.php';
require '../../connection.php';
require '../../function.php';

// Get slug from URL
$request_uri = trim($_SERVER['REQUEST_URI'], '/');
$parts = explode('/', $request_uri);
$slug = end($parts); // Get the last part of the URL (coa2025)

// Fetch course
$course = getCoursesWithInstructors($conn, $slug);

// Check if course exists, redirect if not
if (!$course) {
    $_SESSION['errorMessages'] = ["Course not found"];
    header("Location: " . BASE_PATH . '/');
    exit();
}

// Handle enrollment request via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        $_SESSION['errorMessages'] = ["Please Login to enroll"];
    } else {
        $user_id = $_SESSION['user_id'];
        $course_id = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);

        // Fetch course details from DB to ensure pricing integrity
        $course = getCoursesWithInstructors($conn, $slug);
        if ($course && $course['course_id'] == $course_id) {
            $status = getEnrollmentStatus($conn, $course_id, $user_id);
            if ($status === null) { // Not enrolled yet
                $sql = "INSERT INTO enrollments (course_id, user_id, original_price, enrolled_amount, is_approved) 
                        VALUES (?, ?, ?, ?, 0)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iidd", $course_id, $user_id, $course['original_price'], $course['discounted_price']);
                if ($stmt->execute()) {
                    $_SESSION['successMessages'] = ["Enrollment request sent successfully"];
                } else {
                    $_SESSION['errorMessages'] = ["Failed to send enrollment request"];
                }
            } else {
                $_SESSION['errorMessages'] = ["You have already requested enrollment"];
            }
        } else {
            $_SESSION['errorMessages'] = ["Invalid course data"];
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Check enrollment status if authenticated
$enrollment_status = (isset($_SESSION['authenticated']) && $_SESSION['authenticated'])
    ? getEnrollmentStatus($conn, $course['course_id'], $_SESSION['user_id'])
    : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['name']); ?> | CoreDeft</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #00008b;
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
    /* Enrollment Modal Styles */
    .enrollModal__custom .enrollModal__content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 8px 24px rgba(0, 0, 139, 0.15);
    }
    
    .enrollModal__header {
        background-color: #00008b;
        color: #ffffff;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }
    
    .enrollModal__title {
        font-weight: 600;
        font-size: 1.25rem;
    }
    
    .enrollModal__close {
        filter: invert(1);
        opacity: 0.8;
    }
    
    .enrollModal__body {
        padding: 1.5rem;
        background-color: #F7F8FB;
    }
    
    .enrollModal__payment-summary {
        background: #ffffff;
        padding: 1.25rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 139, 0.05);
    }
    
    .enrollModal__payment-title {
        color: #00008b;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .enrollModal__payment-row {
        margin-bottom: 0.5rem;
    }
    
    .enrollModal__payment-label {
        color: #555;
    }
    
    .enrollModal__payment-value {
        font-weight: 500;
    }
    
    .enrollModal__payment-total {
        color: #00008b;
        font-size: 1.1rem;
    }
    
    .enrollModal__divider {
        border-top: 1px dashed #ddd;
        margin: 1rem 0;
    }
    
    .enrollModal__coupon-label {
        color: #00008b;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .enrollModal__coupon-group {
        margin-bottom: 0.5rem;
    }
    
    .enrollModal__coupon-input {
        border: 1px solid #ddd;
        padding: 0.5rem 1rem;
    }
    
    .enrollModal__coupon-btn {
        background-color: #e9ecef;
        color: #555;
        border: 1px solid #ddd;
    }
    
    .enrollModal__coupon-note {
        font-size: 0.8rem;
    }
    
    .enrollModal__terms {
        background: #ffffff;
        padding: 1rem;
        border-radius: 8px;
    }
    
    .enrollModal__terms-intro {
        color: #555;
        margin-bottom: 0.5rem;
    }
    
    .enrollModal__terms-list {
        padding-left: 1rem;
    }
    
    .enrollModal__terms-item {
        margin-bottom: 0.25rem;
    }
    
    .enrollModal__terms-link {
        color: #00008b;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .enrollModal__terms-link:hover {
        color: #0000cd;
        text-decoration: underline;
    }
    
    .enrollModal__footer {
        background-color: #F7F8FB;
        border-top: 1px solid #eee;
        padding: 1rem 1.5rem;
        border-radius: 0 0 12px 12px;
    }
    
    .enrollModal__cancel-btn {
        background-color: #f0f0f0;
        color: #555;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 6px;
        transition: all 0.2s;
    }
    
    .enrollModal__cancel-btn:hover {
        background-color: #e0e0e0;
    }
    
    .enrollModal__submit-btn {
        background-color: #00008b;
        color: white;
        border: none;
        padding: 0.5rem 1.25rem;
        border-radius: 6px;
        transition: all 0.2s;
    }
    
    .enrollModal__submit-btn:hover {
        background-color: #0000cd;
    }
    
    /* Login Modal Styles */
    .loginModal__custom .loginModal__content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 8px 24px rgba(0, 0, 139, 0.15);
    }
    
    .loginModal__header {
        background-color: #00008b;
        color: #ffffff;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }
    
    .loginModal__title {
        font-weight: 600;
        font-size: 1.25rem;
    }
    
    .loginModal__close {
        filter: invert(1);
        opacity: 0.8;
    }
    
    .loginModal__body {
        padding: 1.5rem;
        text-align: center;
        background-color: #F7F8FB;
    }
    
    .loginModal__message {
        color: #555;
        margin-bottom: 1.5rem;
        font-size: 1rem;
    }
    
    .loginModal__login-btn {
        background-color: #00008b;
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 6px;
        transition: all 0.2s;
    }
    
    .loginModal__login-btn:hover {
        background-color: #0000cd;
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
    <?php include('../../nav.php'); ?>
    <!-- Hero Section -->
    <section class="course-hero">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-pro animate__animated animate__fadeInDown" style="animation-delay: 0.2s;">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_PATH; ?>"><i class="fas fa-home fa-sm"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Courses</a></li>
                    <li class="breadcrumb-item"><a href="#"><?php echo htmlspecialchars($course['category_name'] ?? 'Uncategorized'); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($course['name']); ?></li>
                </ol>
            </nav>
            <div class="row align-items-center">
                <!-- Image Column -->
                <div class="col-lg-5 order-1 order-lg-2 mb-4 mb-lg-0">
                    <div class="glass-card rounded-4 shadow-sm overflow-hidden position-relative animate__animated animate__zoomIn" style="animation-delay: 0.4s;">
                        <div class="ratio">
                            <img src="<?php echo htmlspecialchars($course['photo'] ?? 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4'); ?>"
                                class="img-fluid rounded-4"
                                alt="<?php echo htmlspecialchars($course['name']); ?>"
                                loading="lazy">
                        </div>
                        <?php if ($course['badge']): ?>
                            <div class="position-absolute top-0 end-0 m-3">
                                13 <span class="badge bg-warning text-light rounded-pill px-2 py-1 animate__animated animate__pulse animate__infinite"><?php echo htmlspecialchars($course['badge']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Content Column -->
                <div class="col-lg-7 order-2 order-lg-1 text-lg-start text-left" style="text-align: left;">
                    <h1 class="display-4 fw-bold mb-4 text-dark animate__animated animate__fadeInLeft" style="animation-delay: 0.3s;">
                        <?php echo htmlspecialchars($course['name']); ?>
                    </h1>
                    <div class="d-flex flex-wrap justify-content-between justify-content-lg-start gap-3 mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
                        <span class="badge bg-gradient-primary text-light rounded-pill px-3 py-2 shadow-sm">
                            <i class="fas fa-star me-1"></i> <?php echo htmlspecialchars($course['five_star']); ?>+ 5 Stars
                        </span>
                        <span class="badge bg-dark text-light rounded-pill px-3 py-2 shadow-sm">
                            <i class="fas fa-users me-1"></i> <?php echo htmlspecialchars($course['enrolled'] ?? '0'); ?>+ Students
                        </span>
                        <span class="badge edition-badge text-light rounded-pill px-3 py-2 shadow-sm">
                            <i class="fas fa-calendar-alt me-1"></i> <?php echo htmlspecialchars($course['edition']); ?>
                        </span>
                    </div>

                    <p class="lead mb-4 text-muted animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                        <?php echo htmlspecialchars($course['short_des'] ?? $course['description']); ?>
                    </p>
                    <div class="mt-4 d-grid gap-3 d-lg-flex animate__animated animate__fadeInUp" style="animation-delay: 0.7s;">

                        <?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']): ?>
                            <?php if ($enrollment_status === 0): ?>
                                <button class="btn btn-secondary btn-lg rounded-pill shadow-sm px-5" disabled>
                                    <i class="fas fa-hourglass-half me-2"></i> Pending
                                </button>
                            <?php elseif ($enrollment_status === 1): ?>
                                <button class="btn btn-success btn-lg rounded-pill shadow-sm px-5" disabled>
                                    <i class="fas fa-check me-2"></i> Enrolled
                                </button>
                            <?php else: ?>
                                <button class="btn btn-primary btn-lg rounded-pill shadow-sm px-5" data-bs-toggle="modal" data-bs-target="#enrollModal">
                                    <i class="fas fa-rocket me-2"></i> Enroll Now - ৳<?php echo number_format($course['discounted_price'], 0); ?>
                                    <small class="opacity-75 fs-6 ms-2"><del>৳<?php echo number_format($course['original_price'], 0); ?></del></small>
                                </button>
                            <?php endif; ?>
                        <?php else: ?>
                            <button class="btn btn-primary btn-lg rounded-pill shadow-sm px-5" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-rocket me-2"></i> Enroll Now - ৳<?php echo number_format($course['discounted_price'], 0); ?>
                                <small class="opacity-75 fs-6 ms-2"><del>৳<?php echo number_format($course['original_price'], 0); ?></del></small>
                            </button>
                        <?php endif; ?>
                        <a href="#details" class="btn btn-outline-dark btn-lg rounded-pill shadow-sm px-5 btn-cta">
                            <i class="fas fa-info-circle me-2"></i> Explore Details
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
                <!-- Sidebar -->
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
                                    <small><?php echo $course['duration_months']; ?> Months</small>
                                </div>
                            </li>
                            <li class="d-flex align-items-center py-3 border-bottom">
                                <div class="icon-box d-flex justify-content-center align-items-center">
                                    <i class="fas fa-chalkboard-teacher color-primary"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1">Total Classes</h6>
                                    <small><?php echo $course['num_classes']; ?>+ Classes</small>
                                </div>
                            </li>
                            <li class="d-flex align-items-center py-3">
                                <div class="icon-box d-flex justify-content-center align-items-center">
                                    <i class="fas fa-question-circle color-primary"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1 fw-medium">Total Exams</h6>
                                    <small><?php echo $course['num_exams']; ?>+ Exams</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Instructor Card -->
                    <div class="glass-card p-4 shadow-sm">
                        <h5 class="text-uppercase color-primary fw-semibold mb-3">Instructors</h5>
                        <?php foreach ($course['instructor_names'] as $index => $instructor): ?>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="avatar">
                                    <img src="<?php echo htmlspecialchars($course['instructor_photos'][$index] ?? 'https://asiburrahman.com/img/aravi_3.jpg'); ?>"
                                        width="50" height="50" class="rounded-circle shadow-sm" style="object-fit: cover;"
                                        alt="<?php echo htmlspecialchars($instructor); ?>">
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-semibold text-dark"><?php echo htmlspecialchars($instructor); ?></h5>
                                    <div class="d-flex align-items-center">
                                        <small class="text-muted">Experience TBD</small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-8 order-lg-1">
                    <!-- Overview -->
                    <div class="glass-card p-4 mb-4 shadow-sm">
                        <h5 class="text-uppercase color-primary fw-semibold mb-3 mb-2">Overview</h5>
                        <?php echo ($course['description']); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- Enrollment Modal -->
<?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']): ?>
    <div class="modal fade enrollModal__custom" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
        <div class="modal-dialog enrollModal__dialog">
            <div class="modal-content enrollModal__content">
                <div class="modal-header enrollModal__header">
                    <h5 class="modal-title enrollModal__title" id="enrollModalLabel">Enroll in <?php echo htmlspecialchars($course['name']); ?></h5>
                    <button type="button" class="btn-close enrollModal__close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" class="enrollModal__form">
                    <div class="modal-body enrollModal__body">
                        <!-- Payment Information (Read-only from DB) -->
                        <div class="mb-4 enrollModal__payment-summary">
                            <h6 class="enrollModal__payment-title">Payment Summary</h6>
                            <div class="enrollModal__payment-row d-flex justify-content-between">
                                <span class="enrollModal__payment-label">Sub Total:</span>
                                <span class="enrollModal__payment-value">৳<?php echo number_format($course['original_price'], 0); ?></span>
                            </div>
                            <div class="enrollModal__payment-row d-flex justify-content-between text-success">
                                <span class="enrollModal__payment-label">Discount:</span>
                                <span class="enrollModal__payment-value">-৳<?php echo number_format($course['original_price'] - $course['discounted_price'], 0); ?></span>
                            </div>
                            <hr class="enrollModal__divider">
                            <div class="enrollModal__payment-row d-flex justify-content-between fw-bold">
                                <span class="enrollModal__payment-label">Total Amount:</span>
                                <span class="enrollModal__payment-total">৳<?php echo number_format($course['discounted_price'], 0); ?></span>
                            </div>
                        </div>

                        <!-- Coupon System -->
                        <div class="mb-4 enrollModal__coupon">
                            <label for="coupon" class="form-label enrollModal__coupon-label">Apply Coupon</label>
                            <div class="input-group enrollModal__coupon-group">
                                <input type="text" class="form-control enrollModal__coupon-input" id="coupon" disabled placeholder="Coming Soon">
                                <button class="btn enrollModal__coupon-btn" type="button" disabled>Apply</button>
                            </div>
                            <small class="text-muted enrollModal__coupon-note">Coupon system coming soon!</small>
                        </div>

                        <!-- Terms & Policies -->
                        <div class="mb-3 enrollModal__terms">
                            <p class="enrollModal__terms-intro">By enrolling, you agree to our:</p>
                            <ul class="list-unstyled enrollModal__terms-list">
                                <li class="enrollModal__terms-item"><a href="/terms" target="_blank" class="enrollModal__terms-link">Terms & Conditions</a></li>
                                <li class="enrollModal__terms-item"><a href="/privacy" target="_blank" class="enrollModal__terms-link">Privacy Policy</a></li>
                                <li class="enrollModal__terms-item"><a href="/refund" target="_blank" class="enrollModal__terms-link">Return & Refund Policy</a></li>
                            </ul>
                        </div>

                        <!-- Hidden course_id only, prices fetched from DB -->
                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['course_id']); ?>">
                        <input type="hidden" name="enroll" value="1">
                    </div>
                    <div class="modal-footer enrollModal__footer">
                        <button type="button" class="btn enrollModal__cancel-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn enrollModal__submit-btn">Send Enrollment Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Login Modal -->
<div class="modal fade loginModal__custom" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog loginModal__dialog">
        <div class="modal-content loginModal__content">
            <div class="modal-header loginModal__header">
                <h5 class="modal-title loginModal__title" id="loginModalLabel">Login Required</h5>
                <button type="button" class="btn-close loginModal__close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body loginModal__body">
                <p class="loginModal__message">Please login to enroll in this course.</p>
                <a href="<?php echo BASE_PATH; ?>/auth/login/" class="btn loginModal__login-btn">Go to Login</a>
            </div>
        </div>
    </div>
</div>

    <?php include('../../footer.php'); ?>
    <?php include('../../toast.php'); ?>
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

            reviewCard.className = 'review-card p-3 shadow-sm';
            reviewCard.innerHTML = `
                <div class="d-flex align-items-center gap-3 mb-3">
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
<?php
// Close connection
$conn->close();
?>