<?php
require 'session.php';
requireLogin();
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
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
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