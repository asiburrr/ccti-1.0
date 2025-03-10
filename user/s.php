<?php
require 'session.php';
requireLogin();
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
    <title>Dashboard | <?php echo htmlspecialchars($_SESSION['first_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg-light);
            color: #1f2937;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            line-height: 1.6;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        .animated-entry {
            animation: fadeInUp 0.5s ease forwards;
        }

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
    <?php include 'sidebar-nav.php'; ?>

    <main class="main-content">
        <header class="d-flex justify-content-between align-items-center mb-5 animated-entry">
            <div class="d-flex align-items-center gap-3">
                <h1 class="h4 fw-semibold m-0" style="color: var(--primary-color);">Hello, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</h1>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="#" class="text-muted" title="Notifications"><i class="fa-regular fa-bell fa-lg"></i></a>
                <a href="#" class="text-muted" title="Profile"><i class="fa-regular fa-user fa-lg"></i></a>
            </div>
        </header>

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

        <div class="row g-4">
            <div class="col-lg-8">
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

            <div class="col-lg-4">
                <section class="dashboard-card animated-entry" style="animation-delay: 0.1s;">
                    <div class="profile-header">
                        <img src="<?php echo htmlspecialchars($_SESSION['photo']); ?>" class="rounded-circle mb-3 border border-3" style="border-color: var(--secondary-color) !important;" width="100" height="100" alt="Profile">
                        <h2 class="h6 fw-semibold mb-1"><?php echo htmlspecialchars($_SESSION['first_name']); ?></h2>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.hover-scale').forEach(item => {
            item.addEventListener('mouseover', () => item.style.transform = 'scale(1.02)');
            item.addEventListener('mouseout', () => item.style.transform = 'scale(1)');
        });
    </script>
</body>
</html>