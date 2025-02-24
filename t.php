<?php
// Simulated user data
$user = [
    'name' => 'Sarah Johnson',
    'email' => 'sarah@example.com',
    'join_date' => 'January 2023',
    'profile_pic' => 'https://placehold.co/150/00008B/FFFFFF?text=SJ'
];

$purchased_courses = [
    ['title' => 'Computer Science Basics', 'date' => '20 Dec 2024', 'progress' => 80],
    ['title' => 'Web Development 101', 'date' => '15 Jan 2025', 'progress' => 45]
];

$stats = [
    'total_courses' => 12,
    'completed' => 5,
    'spent' => '$1,299.00'
];

$transactions = [
    ['id' => '#23546', 'date' => '2024-03-15', 'amount' => '$149.99', 'status' => 'Completed', 'invoice' => true],
    ['id' => '#23489', 'date' => '2024-02-28', 'amount' => '$99.99', 'status' => 'Pending', 'invoice' => false],
    ['id' => '#23123', 'date' => '2024-01-10', 'amount' => '$79.99', 'status' => 'Failed', 'invoice' => false]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Dashboard | LearnHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #00008b; /* Navy blue */
            --secondary-color: #ffffff; /* White */
            --accent-color: #4169e1; /* Royal blue */
            --bg-light: #f9fafb; /* Light neutral background */
            --text-muted: #6b7280; /* Subtle gray */
            --shadow: 0 4px 20px rgba(0, 0, 139, 0.08);
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg-light);
            color: #1f2937;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .animated-entry {
            animation: fadeInUp 0.5s ease forwards;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--secondary-color);
            box-shadow: 2px 0 20px rgba(0, 0, 139, 0.1);
            padding: 1.5rem;
            transition: transform 0.3s ease;
            z-index: 1000;
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
            animation: slideIn 0.3s ease forwards;
        }

        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(0);
            }
        }

        .sidebar .profile-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 139, 0.1);
        }

        .sidebar .profile-section img {
            border-radius: 50%;
            border: 2px solid var(--primary-color);
        }

        .sidebar .profile-section .username {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(0, 0, 139, 0.05);
            color: var(--primary-color);
        }

        .sidebar .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 0;
            padding: 2rem;
            transition: margin-left 0.3s ease;
            padding-bottom: 100px;
        }

        @media (min-width: 992px) {
            .main-content {
                margin-left: var(--sidebar-width);
            }
        }

        .dashboard-card {
            background: var(--secondary-color);
            border-radius: 12px;
            border: none;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .profile-header {
            background: var(--primary-color);
            border-radius: 12px 12px 0 0;
            padding: 1.5rem;
            color: var(--secondary-color);
            text-align: center;
        }

        .navy-badge {
            background: rgba(0, 0, 139, 0.1);
            color: var(--primary-color);
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .progress {
            height: 10px;
            border-radius: 20px;
            background: rgba(0, 0, 139, 0.1);
        }

        .progress-bar {
            background: var(--accent-color);
            border-radius: 20px;
            transition: width 0.5s ease;
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 380px;
            height: 60px;
            background: var(--secondary-color);
            box-shadow: var(--shadow);
            border-radius: 30px;
            z-index: 1000;
            padding: 0 15px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            transition: all 0.3s ease;
        }

        .bottom-nav:hover {
            box-shadow: 0 6px 25px rgba(0, 0, 139, 0.15);
        }

        .nav-item {
            color: var(--text-muted);
            text-decoration: none;
            text-align: center;
            padding: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-item i {
            font-size: 1.3rem;
            transition: transform 0.3s ease;
        }

        .nav-item small {
            font-size: 0.7rem;
            display: block;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .nav-item.active {
            color: var(--primary-color);
            animation: bounce 1s infinite;
        }

        .nav-item.active i {
            transform: scale(1.1);
        }

        .nav-item.active small {
            opacity: 1;
        }

        .nav-item:hover {
            color: var(--accent-color);
        }

        .nav-item:hover i {
            transform: scale(1.05);
        }

        .nav-item.profile-toggle {
            cursor: pointer;
        }

        @media (min-width: 992px) {
            .bottom-nav {
                display: none;
            }
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(65, 105, 225, 0.2);
        }

        .invoice-btn {
            background: rgba(0, 0, 139, 0.05);
            color: var(--primary-color);
            border-radius: 6px;
            padding: 5px 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .invoice-btn:hover {
            background: var(--primary-color);
            color: var(--secondary-color);
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .bg-success-soft { background: rgba(40, 167, 69, 0.15); color: #28a745; }
        .bg-warning-soft { background: rgba(255, 193, 7, 0.15); color: #ffc107; }
        .bg-danger-soft { background: rgba(220, 53, 69, 0.15); color: #dc3545; }

        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="profile-section">
            <img src="<?= $user['profile_pic'] ?>" width="40" height="40" alt="Profile">
            <div class="username"><?= $user['name'] ?></div>
        </div>
        <nav class="nav flex-column">
            <a href="#" class="nav-link active"><i class="fa-solid fa-tachometer-alt"></i> Dashboard</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-book-open"></i> My Courses</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-wallet"></i> Transactions</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-file-invoice"></i> Invoices</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-certificate"></i> Certificates</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-user-shield"></i> Account Security</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-question-circle"></i> Support</a>
            <a href="#" class="nav-link mt-auto"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header Section -->
        <header class="d-flex justify-content-between align-items-center mb-5 animated-entry">
            <div class="d-flex align-items-center gap-3">
                <h1 class="h4 fw-semibold m-0" style="color: var(--primary-color);">Hello, <?= explode(' ', $user['name'])[0] ?>!</h1>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="#" class="text-muted" title="Notifications"><i class="fa-regular fa-bell fa-lg"></i></a>
                <a href="#" class="text-muted" title="Profile"><i class="fa-regular fa-user fa-lg"></i></a>
            </div>
        </header>

        <!-- Stats Overview -->
        <section class="row g-3 mb-5">
            <?php foreach([
                ['count' => $stats['total_courses'], 'label' => 'Courses Enrolled', 'icon' => 'fa-book-open', 'color' => 'text-primary'],
                ['count' => $stats['completed'], 'label' => 'Completed', 'icon' => 'fa-check-double', 'color' => 'text-success'],
                ['count' => $stats['spent'], 'label' => 'Total Spent', 'icon' => 'fa-wallet', 'color' => 'text-info']
            ] as $index => $stat): ?>
            <div class="col-md-4 animated-entry" style="animation-delay: <?= $index * 0.2 ?>s;">
                <div class="dashboard-card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light p-2 rounded-circle">
                            <i class="fa-solid <?= $stat['icon'] ?> fa-lg <?= $stat['color'] ?>"></i>
                        </div>
                        <div>
                            <h3 class="h5 mb-0 fw-semibold"><?= $stat['count'] ?></h3>
                            <p class="text-muted mb-0 small"><?= $stat['label'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </section>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Course Progress -->
                <section class="dashboard-card p-4 mb-4 animated-entry" style="animation-delay: 0.2s;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h6 fw-semibold" style="color: var(--primary-color);">My Course Progress</h2>
                        <a href="#" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <?php foreach ($purchased_courses as $course): ?>
                    <div class="course-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h3 class="h6 mb-1 fw-medium"><?= $course['title'] ?></h3>
                                <small class="text-muted">Started: <?= $course['date'] ?></small>
                            </div>
                            <span class="navy-badge"><?= $course['progress'] ?>%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?= $course['progress'] ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </section>

                <!-- Transactions -->
                <section class="dashboard-card p-4 animated-entry" style="animation-delay: 0.3s;">
                    <h2 class="h6 fw-semibold mb-3" style="color: var(--primary-color);">Recent Transactions</h2>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead>
                                <tr style="color: var(--primary-color);">
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($transactions as $txn): ?>
                                <tr class="hover-scale">
                                    <td class="fw-medium"><?= $txn['id'] ?></td>
                                    <td><?= $txn['date'] ?></td>
                                    <td class="fw-medium"><?= $txn['amount'] ?></td>
                                    <td>
                                        <span class="status-badge <?= match($txn['status']) {
                                            'Completed' => 'bg-success-soft text-success',
                                            'Pending' => 'bg-warning-soft text-warning',
                                            'Failed' => 'bg-danger-soft text-danger'
                                        } ?>">
                                            <?= $txn['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($txn['invoice']): ?>
                                        <a href="#" class="invoice-btn">Download</a>
                                        <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Profile Card -->
                <section class="dashboard-card animated-entry" style="animation-delay: 0.1s;">
                    <div class="profile-header">
                        <img src="<?= $user['profile_pic'] ?>" class="rounded-circle mb-3 border border-3" style="border-color: var(--secondary-color) !important;" width="100" height="100" alt="Profile">
                        <h2 class="h6 fw-semibold mb-1"><?= $user['name'] ?></h2>
                        <p class="mb-0 small opacity-75"><?= $user['email'] ?></p>
                        <small class="opacity-50">Joined: <?= $user['join_date'] ?></small>
                    </div>
                    <div class="p-4">
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-primary">Edit Profile</a>
                            <a href="#" class="btn btn-outline-primary">Payment Methods</a>
                        </div>
                    </div>
                </section>

                <!-- Quick Links -->
                <section class="dashboard-card p-4 mt-4 animated-entry" style="animation-delay: 0.4s;">
                    <h2 class="h6 fw-semibold mb-3" style="color: var(--primary-color);">Quick Links</h2>
                    <div class="list-group list-group-flush">
                        <?php foreach([
                            ['icon' => 'fa-certificate', 'label' => 'Certificates'],
                            ['icon' => 'fa-user-shield', 'label' => 'Security'],
                            ['icon' => 'fa-question-circle', 'label' => 'Support']
                        ] as $action): ?>
                        <a href="#" class="list-group-item list-group-item-action border-0 py-2 hover-scale">
                            <i class="fa-regular <?= $action['icon'] ?> me-2" style="color: var(--primary-color);"></i>
                            <?= $action['label'] ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav d-lg-none">
        <div class="d-flex h-100 justify-content-around align-items-center">
            <?php foreach([
                ['icon' => 'fa-house', 'label' => 'Home', 'active' => true, 'toggle' => false],
                ['icon' => 'fa-book-open', 'label' => 'Courses', 'active' => false, 'toggle' => false],
                ['icon' => 'fa-wallet', 'label' => 'Wallet', 'active' => false, 'toggle' => false],
                ['icon' => 'fa-user', 'label' => 'Profile', 'active' => false, 'toggle' => true]
            ] as $nav): ?>
            <a href="#" class="nav-item <?= $nav['active'] ? 'active' : '' ?> <?= $nav['toggle'] ? 'profile-toggle' : '' ?>" 
               <?= $nav['toggle'] ? 'onclick="toggleSidebar()"' : '' ?>>
                <i class="fa-solid <?= $nav['icon'] ?>"></i>
                <small><?= $nav['label'] ?></small>
            </a>
            <?php endforeach; ?>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }

        // Interactive animations
        document.querySelectorAll('.hover-scale').forEach(item => {
            item.addEventListener('mouseover', () => item.style.transform = 'scale(1.02)');
            item.addEventListener('mouseout', () => item.style.transform = 'scale(1)');
        });

        // Bottom nav active state
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (!this.classList.contains('profile-toggle')) {
                    e.preventDefault();
                    document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>