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
    <title>Learning Dashboard | Course Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #00008b; /* Deep navy blue */
            --accent-color: #4169e1; /* Royal blue */
            --secondary-color: #ffffff; /* White */
            --bg-gradient: linear-gradient(135deg, #00008b, #4169e1);
            --card-bg: rgba(255, 255, 255, 0.95);
            --glow: 0 0 15px rgba(65, 105, 225, 0.3);
            --shadow: 0 8px 32px rgba(0, 0, 139, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f4ff, #e6e9ff);
            color: #1a1a3d;
            overflow-x: hidden;
            margin: 0;
            padding-bottom: 100px; /* Space for bottom nav */
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes glowPulse {
            0% { box-shadow: var(--glow); }
            50% { box-shadow: 0 0 25px rgba(65, 105, 225, 0.5); }
            100% { box-shadow: var(--glow); }
        }


        .dashboard-card {
            background: var(--card-bg);
            border-radius: 24px;
            border: none;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0, 0, 139, 0.25);
            animation: glowPulse 1.5s infinite;
        }

        .header-gradient {
            background: var(--bg-gradient);
            border-radius: 24px 24px 0 0;
            padding: 2.5rem;
            color: var(--secondary-color);
            position: relative;
            overflow: hidden;
        }

        .header-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent);
            opacity: 0.3;
            transform: rotate(30deg);
        }

        .navy-badge {
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            color: var(--secondary-color);
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 12px;
            box-shadow: var(--glow);
        }

        .progress {
            height: 12px;
            border-radius: 20px;
            background: rgba(0, 0, 139, 0.1);
        }

        .progress-bar {
            background: var(--bg-gradient);
            border-radius: 20px;
            box-shadow: var(--glow);
            transition: width 0.6s ease-in-out;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 90px;
            background: var(--card-bg);
            box-shadow: 0 -8px 40px rgba(0, 0, 139, 0.15);
            border-radius: 30px 30px 0 0;
            backdrop-filter: blur(10px);
            z-index: 1000;
        }

        .nav-item {
            color: #666;
            transition: all 0.4s ease;
            padding: 10px;
        }

        .nav-item.active {
            color: var(--primary-color);
            transform: translateY(-15px);
            background: var(--bg-gradient);
            border-radius: 15px;
            color: var(--secondary-color);
            box-shadow: var(--glow);
        }

        .nav-item i {
            font-size: 1.8rem;
        }

        .btn-primary {
            background: var(--bg-gradient);
            border: none;
            border-radius: 15px;
            padding: 12px 24px;
            color: var(--secondary-color);
            font-weight: 600;
            transition: all 0.4s ease;
            box-shadow: var(--glow);
        }

        .btn-primary:hover {
            transform: scale(1.08);
            box-shadow: 0 0 20px rgba(65, 105, 225, 0.5);
        }

        .invoice-btn {
            background: rgba(0, 0, 139, 0.08);
            color: var(--primary-color);
            border-radius: 20px;
            padding: 8px 16px;
            text-decoration: none;
            transition: all 0.4s ease;
        }

        .invoice-btn:hover {
            background: var(--bg-gradient);
            color: var(--secondary-color);
            box-shadow: var(--glow);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: var(--glow);
        }

        .bg-success-soft { background: linear-gradient(90deg, #28a745, #34c759); color: var(--secondary-color); }
        .bg-warning-soft { background: linear-gradient(90deg, #ffc107, #ffdb58); color: #1a1a3d; }
        .bg-danger-soft { background: linear-gradient(90deg, #dc3545, #ff5769); color: var(--secondary-color); }

        .hover-scale {
            transition: transform 0.4s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(65, 105, 225, 0.15), transparent);
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <main class="container-xl py-5">
        <!-- Header Section -->
        <header class="d-flex justify-content-between align-items-center mb-5 animated-entry">
            <h1 class="h2 fw-bold" style="background: var(--bg-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Welcome, <?= explode(' ', $user['name'])[0] ?>!
            </h1>
            <div class="d-flex align-items-center gap-4">
                <a href="#" class="text-muted" style="font-size: 1.8rem;"><i class="fa-regular fa-bell hover-scale"></i></a>
                <a href="#" class="text-muted" style="font-size: 1.8rem;"><i class="fa-regular fa-user hover-scale"></i></a>
            </div>
        </header>

        <!-- Stats Overview -->
        <section class="row g-4 mb-5">
            <?php foreach([
                ['count' => $stats['total_courses'], 'label' => 'Courses Enrolled', 'icon' => 'fa-book-open', 'color' => 'text-primary'],
                ['count' => $stats['completed'], 'label' => 'Courses Completed', 'icon' => 'fa-check-double', 'color' => 'text-success'],
                ['count' => $stats['spent'], 'label' => 'Total Spent', 'icon' => 'fa-wallet', 'color' => 'text-info']
            ] as $index => $stat): ?>
            <div class="col-md-4 animated-entry" style="animation-delay: <?= $index * 0.2 ?>s;">
                <div class="dashboard-card stat-card p-4 hover-scale">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle me-4" style="background: var(--bg-gradient);">
                            <i class="fa-solid <?= $stat['icon'] ?> fa-2x text-white"></i>
                        </div>
                        <div>
                            <h2 class="h3 mb-0 fw-bold" style="color: var(--primary-color);"><?= $stat['count'] ?></h2>
                            <p class="text-muted mb-0"><?= $stat['label'] ?></p>
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
                <section class="dashboard-card p-5 mb-4 animated-entry" style="animation-delay: 0.2s;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 fw-bold" style="color: var(--primary-color);">Course Progress</h2>
                        <a href="#" class="btn btn-primary">Explore More <i class="fa-solid fa-arrow-right ms-2"></i></a>
                    </div>
                    <?php foreach ($purchased_courses as $course): ?>
                    <div class="course-item mb-4 pb-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h3 class="h5 mb-1 fw-semibold"><?= $course['title'] ?></h3>
                                <small class="text-muted">Enrolled: <?= $course['date'] ?></small>
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
                <section class="dashboard-card p-5 animated-entry" style="animation-delay: 0.3s;">
                    <h2 class="h4 fw-bold mb-4" style="color: var(--primary-color);">Recent Transactions</h2>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead>
                                <tr style="color: var(--primary-color); font-weight: 600;">
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
                                    <td class="fw-semibold"><?= $txn['amount'] ?></td>
                                    <td>
                                        <span class="status-badge <?= match($txn['status']) {
                                            'Completed' => 'bg-success-soft',
                                            'Pending' => 'bg-warning-soft',
                                            'Failed' => 'bg-danger-soft'
                                        } ?>">
                                            <?= $txn['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($txn['invoice']): ?>
                                        <a href="#" class="invoice-btn"><i class="fa-regular fa-file-pdf me-2"></i>Download</a>
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
                    <div class="header-gradient text-center">
                        <img src="<?= $user['profile_pic'] ?>" class="rounded-circle mb-4 border border-4" style="border-color: var(--secondary-color) !important;" width="140" height="140" alt="Profile">
                        <h2 class="h4 fw-bold mb-2"><?= $user['name'] ?></h2>
                        <p class="mb-2 opacity-75"><?= $user['email'] ?></p>
                        <small class="opacity-60">Joined: <?= $user['join_date'] ?></small>
                    </div>
                    <div class="p-5">
                        <div class="d-grid gap-3">
                            <a href="#" class="btn btn-primary"><i class="fa-regular fa-pen-to-square me-2"></i>Edit Profile</a>
                            <a href="#" class="btn btn-outline-primary" style="border-color: var(--primary-color); color: var(--primary-color);"><i class="fa-regular fa-credit-card me-2"></i>Payment Methods</a>
                        </div>
                    </div>
                </section>

                <!-- Quick Links -->
                <section class="dashboard-card p-5 mt-4 animated-entry" style="animation-delay: 0.4s;">
                    <h2 class="h4 fw-bold mb-4" style="color: var(--primary-color);">Quick Actions</h2>
                    <div class="list-group list-group-flush">
                        <?php foreach([
                            ['icon' => 'fa-certificate', 'label' => 'Certificates'],
                            ['icon' => 'fa-shield-halved', 'label' => 'Security'],
                            ['icon' => 'fa-question-circle', 'label' => 'Support']
                        ] as $action): ?>
                        <a href="#" class="list-group-item list-group-item-action border-0 py-3 hover-scale">
                            <i class="fa-regular <?= $action['icon'] ?> me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <span class="fw-medium"><?= $action['label'] ?></span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav d-lg-none">
        <div class="container h-100">
            <div class="d-flex h-100 justify-content-around align-items-center">
                <?php foreach([
                    ['icon' => 'fa-house', 'label' => 'Home', 'active' => true],
                    ['icon' => 'fa-book-open', 'label' => 'Courses', 'active' => false],
                    ['icon' => 'fa-wallet', 'label' => 'Wallet', 'active' => false],
                    ['icon' => 'fa-user', 'label' => 'Profile', 'active' => false]
                ] as $nav): ?>
                <a href="#" class="nav-item text-center text-decoration-none <?= $nav['active'] ? 'active' : '' ?>">
                    <i class="fa-solid <?= $nav['icon'] ?> mb-1"></i>
                    <small class="d-block"><?= $nav['label'] ?></small>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Interactive animations
        document.querySelectorAll('.hover-scale').forEach(item => {
            item.addEventListener('mouseover', () => item.style.transform = 'scale(1.05)');
            item.addEventListener('mouseout', () => item.style.transform = 'scale(1)');
        });

        // Bottom navigation active state
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>