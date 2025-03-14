<header class="shadow-sm sticky-top">
    <nav class="navbar navbar-expand-xl navbar-light bg-white nav-glass">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_PATH; ?>/">
                <img src="https://app.coredeft.com/img/favicon.ico" alt="CoreDeft Logo" width="50" class="me-2">
                <span class="brand-name fw-bold color-primary">CoreDeft</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="toggler-bar top-bar"></span>
                <span class="toggler-bar middle-bar"></span>
                <span class="toggler-bar bottom-bar"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="mainNav">
                <!-- Left Navigation -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="<?php echo BASE_PATH; ?>/">
                            <i class="fas fa-home me-2"></i> Home
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-th-large me-2"></i> Categories
                        </a>
                        <ul class="dropdown-menu  shadow">
                            <li><a class="dropdown-item d-flex align-items-center" href="courses.php?category=all">
                                    <i class="fas fa-list me-2"></i> All Courses
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!--
                            <li><a class="dropdown-item d-flex align-items-center" href="courses.php?category=programming">
                                    <i class="fas fa-code me-2"></i> Programming
                                </a></li>
                            <li><a class="dropdown-item d-flex align-items-center" href="courses.php?category=design">
                                    <i class="fas fa-palette me-2"></i> Design
                                </a></li>
                            <li><a class="dropdown-item d-flex align-items-center" href="courses.php?category=business">
                                    <i class="fas fa-chart-line me-2"></i> Business
                                </a></li>
                            <li><a class="dropdown-item d-flex align-items-center" href="courses.php?category=marketing">
                                    <i class="fas fa-bullhorn me-2"></i> Marketing
                                </a></li>
                            -->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="about.php">
                            <i class="fas fa-info-circle me-2"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="contact.php">
                            <i class="fas fa-envelope me-2"></i> Contact
                        </a>
                    </li>
                </ul>

                <!-- Search Bar -->
                <form class="d-flex searchh" action="search.php" method="GET">
                    <div class="input-group ">
                        <input class="form-control rounded-pill focus search" type="search" name="query" placeholder="Search courses..." aria-label="Search">
                        <button class="btn btn-primary rounded-pill" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <div class="d-flex align-items-center gap-3 cu">
                    <?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']): ?>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none" role="button" data-bs-toggle="dropdown">
                                <img src="<?php echo htmlspecialchars($_SESSION['photo']); ?>" alt="User Avatar" class="rounded-circle me-2" width="40" height="40">
                                <span class="color-primary fw-semibold"><?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
                            </a>
                            <ul class="dropdown-menu shadow">
                                <li><a class="dropdown-item d-flex align-items-center" href="<?php echo BASE_PATH; ?>/user/">
                                        <i class="fas fa-user me-2"></i> Profile
                                    </a></li>
                                <li><a class="dropdown-item d-flex align-items-center" href="orders.php">
                                        <i class="fas fa-shopping-bag me-2"></i> My Orders
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item d-flex align-items-center" href="<?php echo BASE_PATH; ?>/user/logout">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo BASE_PATH; ?>/auth/login" class="btn btn-outline-primary rounded-pill px-4 btnl">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </a>
                        <a href="<?php echo BASE_PATH; ?>/auth/register" class="btn btn-primary rounded-pill px-4 btnr">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Add Custom CSS for Enhanced Design -->
<style>
    body {
        font-family: 'Roboto', sans-serif !important;
    }

    :root {
        --primary-color: #00008b;
        --secondary-color: #6366f1;
    }

    .color-primary {
        color: var(--primary-color);
    }

    .primary {
        background-color: var(--primary-color);
    }

    .btn-outline-primary {
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        border: 1px solid var(--primary-color);
        background-color: var(--primary-color);
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: 1px solid var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border: 1px solid var(--secondary-color);
    }

    .search {
        border: 1px solid var(--primary-color);
    }

    .focus:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 2px 0.1rem rgba(0, 0, 139, 0.25);
    }

    .nav-glass {
        background: rgba(255, 255, 255, 0.8) !important;
        background: linear-gradient(145deg, #0a1022 0%, #1a2540 100%);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Animated Hamburger Icon */
    .navbar-toggler {
        padding: 0.5rem;
        transition: all 0.3s ease;
    }

    .toggler-bar {
        display: block;
        width: 25px;
        height: 3px;
        background: var(--primary-color);
        margin: 5px 0;
        transition: all 0.3s ease;
    }

    .navbar-toggler[aria-expanded="true"] .top-bar {
        transform: translateY(8px) rotate(45deg);
    }

    .navbar-toggler[aria-expanded="true"] .middle-bar {
        opacity: 0;
    }

    .navbar-toggler[aria-expanded="true"] .bottom-bar {
        transform: translateY(-8px) rotate(-45deg);
    }

    /* Brand Name Styling */
    .brand-name {
        font-size: 1.5rem;
        letter-spacing: 1px;
        transition: color 0.3s ease;
    }

    .brand-name:hover {
        color: #0d6efd;
        /* Primary color on hover */
    }

    /* Dropdown Menu Styling */
    .dropdown-menu {
        border-radius: 10px;
        border: none;
    }

    .dropdown-item {
        font-size: 0.9rem;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }

    /* Search Bar Styling */
    .input-group .form-control {
        border-top-right-radius: 0px !important;
        border-bottom-right-radius: 0px !important;
    }

    .input-group .btn {
        border-top-left-radius: 0px !important;
        border-bottom-left-radius: 0px !important;
    }

    .searchh {
        margin-right: .6rem;
        max-width: 260px;
    }

    /* Cart Badge Styling */
    .badge {
        font-size: 0.75rem;
        padding: 0.25em 0.5em;
    }


    @media screen and (max-width: 1400px) and (min-width: 1200px) {

        .btnl,
        .btnr {
            padding: 8px;
            font-size: 12px;
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 1199px) {
        .navbar-brand img {
            width: 50px;
        }

        .brand-name {
            font-size: 2rem;
        }

        .btn {
            font-size: 0.9rem;
        }

        .cu {
            margin-top: 10px;
            display: flex;
            text-align: center;
            justify-content: center;
        }

        .searchh {
            margin-right: 0;
            max-width: 100%;
        }
    }

    /* Hover Effects for Icons */
    .nav-link i,
    .dropdown-item i {
        transition: transform 0.3s ease, color 0.3s ease;
    }


    .nav-link:hover i,
    .dropdown-item:hover i {
        transform: scale(1.2);
    }
</style>