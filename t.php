<!-- header.html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 115px;
            --header-height: 70px;
            --primary-color: #00008b;
            --text-color: #ffffff;
            --hover-color: #3333a3;
            --body-bg: #f5f6f8;
            --card-bg: #ffffff;
            --card-text: #00008b;
            --shadow-color: rgba(0, 0, 139, 0.2);
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            overflow-x: hidden;
            background: var(--body-bg);
            color: var(--card-text);
        }

        .dropdown-toggle {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        /* Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--primary-color);
            color: var(--text-color);
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            box-shadow: 4px 0 12px var(--shadow-color);
        }

        #sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        #sidebar.collapsed .nav-link-text,
        #sidebar.collapsed .user-info {
            display: none;
        }

        #sidebar.collapsed .dropdown-toggle {
            margin-left: -6px;
        }

        #sidebar.collapsed .user-avatar {
            margin-left: 12px;
            transform: scale(0.9);
        }

        #sidebar.collapsed .nav-link {
            justify-content: center;
        }

        #sidebar .p-3 {
            padding: 1.75rem !important;
        }

        .nav-link {
            color: var(--text-color);
            padding: 0.85rem 1.25rem;
            margin: 0.3rem 0.75rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            animation: slideIn 0.5s ease-out forwards;
            animation-delay: calc(var(--order) * 0.1s);
        }

        .nav-link:hover {
            background: var(--hover-color);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--hover-color);
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        .nav-link:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 0, 139, 0.5);
        }

        .nav-link i {
            transition: transform 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .sidebar-heading {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.7;
        }

        /* Main Content */
        #main-content {
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (min-width: 992px) {
            #main-content {
                margin-left: var(--sidebar-width);
            }

            #main-content.collapsed {
                margin-left: var(--sidebar-collapsed-width);
            }
        }

        @media (max-width: 991.98px) {
            #main-content {
                margin-left: 0;
            }

            #sidebar {
                transform: translateX(-100%);
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            #sidebar.active {
                transform: translateX(0);
            }
        }

        /* Header */
        #header {
            height: var(--header-height);
            background: var(--primary-color);
            color: var(--text-color);
            box-shadow: 0 4px 15px var(--shadow-color);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        #header .d {
            padding: 12px 15px !important;
        }

        .menu-toggle {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: none;
            color: var(--text-color);
            transition: transform 0.3s ease;
        }

        .menu-toggle:hover {
            transform: rotate(90deg);
        }

        /* Mobile Backdrop */
        .mobile-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 139, 0.5);
            z-index: 998;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }

        .mobile-backdrop.show {
            opacity: 1;
            pointer-events: auto;
        }

        /* Close Button */
        .close-sidebar {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background: transparent;
            border: none;
            color: var(--text-color);
            font-size: 1.75rem;
            transition: transform 0.3s ease;
        }

        .close-sidebar:hover {
            transform: scale(1.2);
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <!-- Mobile Backdrop -->
    <div class="mobile-backdrop"></div>

    <!-- Sidebar -->
    <aside id="sidebar" aria-label="Main navigation">
        <button class="close-sidebar d-lg-none" aria-label="Close sidebar">
            <i class="fas fa-times"></i>
        </button>
        <div class="p-3">
            <div class="d-flex align-items-center gap-3 animate__animated animate__fadeIn">
                <img src="https://placehold.co/40" class="rounded-circle user-avatar" alt="Profile"
                    style="width: 40px; height: 40px; border: 2px solid var(--text-color);">
                <div class="user-info">
                    <h6 class="mb-0">Asibur Rahman</h6>
                    <small>Administrator</small>
                </div>
            </div>
        </div>
        <nav>
            <ul class="nav flex-column p-2">
                <li class="nav-item" style="--order: 1;">
                    <a href="#" class="nav-link active has-tooltip" data-bs-placement="right" title="Dashboard">
                        <i class="fas fa-chart-pie me-2"></i><span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item" style="--order: 2;">
                    <a href="#" class="nav-link has-tooltip" data-bs-placement="right" title="Courses">
                        <i class="fas fa-book-open me-2"></i><span class="nav-link-text">Courses</span>
                    </a>
                </li>
                <li class="nav-item" style="--order: 3;">
                    <a href="#" class="nav-link has-tooltip" data-bs-placement="right" title="Students">
                        <i class="fas fa-users me-2"></i><span class="nav-link-text">Students</span>
                    </a>
                </li>
                <li class="nav-item" style="--order: 4;">
                    <a href="#" class="nav-link has-tooltip" data-bs-placement="right" title="Instructors">
                        <i class="fas fa-chalkboard-teacher me-2"></i><span class="nav-link-text">Instructors</span>
                    </a>
                </li>
                <li class="nav-item mt-auto">
                    <h6 class="sidebar-heading px-3 mt-4 mb-1">Account</h6>
                </li>
                <li class="nav-item dropdown" style="--order: 5;">
                    <a class="nav-link has-tooltip" href="#" id="settingsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-placement="right" title="Settings">
                        <i class="fas fa-cog me-2"></i><span class="nav-link-text">Settings</span><span
                            class="dropdown-toggle"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="settingsDropdown">
                        <li><a class="dropdown-item" href="#">Profile Settings</a></li>
                        <li><a class="dropdown-item" href="#">Account Settings</a></li>
                        <li><a class="dropdown-item" href="#">Notification Settings</a></li>
                    </ul>
                </li>
                <li class="nav-item" style="--order: 6;">
                    <a class="nav-link has-tooltip" href="#" data-bs-placement="right" title="Logout">
                        <i class="fas fa-sign-out-alt me-2"></i><span class="nav-link-text">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Header -->
    <div id="main-content">
        <header id="header" class="sticky-top">
            <div class="d-flex align-items-center justify-content-between d">
                <div class="d-flex align-items-center">
                    <button class="btn menu-toggle" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h5 class="ms-3 mb-0 animate__animated animate__fadeIn">Dashboard</h5>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-icon position-relative" aria-label="Notifications" style="color: #ffffff;">
                        <i class="fas fa-bell animate__animated animate__pulse animate__infinite"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-circle animate__animated animate__bounceIn"></span>
                    </button>
                    <div class="dropdown">
                        <a class="btn btn-link p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://placehold.co/40" class="rounded-circle" alt="Profile"
                                style="width: 40px; height: 40px; border: 2px solid var(--text-color);">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#"><i
                                    class="fas fa-sign-out-alt me-2"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const mobileBackdrop = document.querySelector('.mobile-backdrop');
            const menuToggle = document.querySelector('.menu-toggle');
            const closeSidebarBtn = document.querySelector('.close-sidebar');

            function setInitialState() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('active');
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('collapsed');
                    sidebar.setAttribute('aria-expanded', 'true');
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('collapsed');
                    sidebar.setAttribute('aria-expanded', 'false');
                }
            }
            setInitialState();

            function toggleSidebar() {
                if (window.innerWidth >= 992) {
                    const isCollapsed = sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed', isCollapsed);
                    sidebar.setAttribute('aria-expanded', !isCollapsed);
                } else {
                    const isActive = sidebar.classList.toggle('active');
                    mobileBackdrop.classList.toggle('show', isActive);
                    sidebar.setAttribute('aria-expanded', isActive);
                }
            }

            function closeSidebar() {
                sidebar.classList.remove('active');
                mobileBackdrop.classList.remove('show');
                sidebar.setAttribute('aria-expanded', 'false');
            }

            menuToggle.addEventListener('click', toggleSidebar);
            mobileBackdrop.addEventListener('click', closeSidebar);
            closeSidebarBtn.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('active');
                    mobileBackdrop.classList.remove('show');
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    sidebar.setAttribute('aria-expanded', !isCollapsed);
                } else {
                    const isActive = sidebar.classList.contains('active');
                    sidebar.setAttribute('aria-expanded', isActive);
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('collapsed');
                }
            });

            const tooltipTriggerList = document.querySelectorAll('.has-tooltip');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        });
    </script>
</body>

</html>