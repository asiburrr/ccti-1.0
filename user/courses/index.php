<?php
require '../session.php';
requireLogin();
// Function to fetch enrolled courses for a user
function getEnrolledCourses($conn, $user_id)
{
    try {
        $sql = "
            SELECT 
                c.course_id,
                c.name AS course_name,
                c.slug,
                c.photo,
                c.edition,
                c.duration_months,
                c.original_price,
                c.discounted_price,
                c.slug,
                e.enrollment_id,
                e.original_price AS enrolled_original_price,
                e.enrolled_amount,
                e.is_approved,
                e.created_at
            FROM enrollments e
            JOIN courses c ON e.course_id = c.course_id
            WHERE e.user_id = ? AND c.is_active = 1
            ORDER BY e.created_at DESC
        ";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }
        return $courses;
    } catch (Exception $e) {
        error_log("Error in getEnrolledCourses: " . $e->getMessage());
        return [];
    }
}

$user_id = $_SESSION['user_id'];
$enrolled_courses = getEnrolledCourses($conn, $user_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses | <?php echo htmlspecialchars($_SESSION['first_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00008b;
            --primary-light: rgba(0, 0, 139, 0.08);
            --white: #ffffff;
            --light-bg: #F7F8FB;
            --dark: #1a1a1a;
            --gray: #6b7280;
            --light-gray: #e5e7eb;
            --success: #10b981;
            --warning: #f59e0b;
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: var(--light-bg);
            color: var(--dark);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
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

        /* Course Cards */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid var(--light-gray);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        .course-media {

            position: relative;
            overflow: hidden;
        }

        .course-media img {
            width: 100%;
            max-height: 240px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .course-card:hover .course-media img {
            transform: scale(1.03);
        }

        .course-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            z-index: 2;
        }

        .badge-approved {
            background: var(--success);
            color: white;
        }

        .badge-pending {
            background: var(--warning);
            color: white;
        }

        .course-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .course-title {
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 0.75rem;
            color: var(--dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: var(--gray);
        }

        .course-meta span {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .price-container {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px dashed var(--light-gray);
        }

        .price-original {
            text-decoration: line-through;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .price-current {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary);
        }

        .course-footer {
            padding: 1rem 1.5rem;
            background: var(--light-bg);
            border-top: 1px solid var(--light-gray);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .enrollment-date {
            font-size: 0.8rem;
            color: var(--gray);
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
            font-weight: 500;
            border-radius: var(--radius-sm);
            padding: 0.5rem 1rem;
            transition: var(--transition);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
            border-radius: var(--radius-sm);
            padding: 0.5rem 1rem;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: #000070;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 139, 0.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            max-width: 500px;
            margin: 2rem auto;
            animation: fadeIn 0.6s ease-out;
        }

        .empty-icon {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            opacity: 0.8;
        }

        .empty-title {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: var(--gray);
            margin-bottom: 1.5rem;
            max-width: 350px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .staggered-animation {
            animation: fadeIn 0.6s ease-out forwards;
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.4s ease-out;
        }

        .section-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 0.75rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
        }

        /* Status Indicator */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-approved .status-dot {
            background: var(--success);
        }

        .status-pending .status-dot {
            background: var(--warning);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .header-actions {
                width: 100%;
                justify-content: space-between;
            }
        }
    </style>
</head>

<body>
    <?php include '../sidebar-nav.php'; ?>
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

        <section class="courses-section">
            <div class="section-header">
                <h2 class="section-title">My Courses</h2>
            </div>

            <?php if (empty($enrolled_courses)): ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3 class="empty-title">No Courses Enrolled</h3>
                    <p class="empty-text">You haven't enrolled in any courses yet. Browse our catalog to find your perfect course.</p>
                    <a href="courses.php" class="btn btn-primary">
                        Browse Courses <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            <?php else: ?>
                <div class="course-grid">
                    <?php foreach ($enrolled_courses as $index => $course): ?>
                        <div class="course-card staggered-animation" style="animation-delay: <?php echo $index * 0.1; ?>s">
                            <div class="course-media">
                                <?php if (!empty($course['photo'])): ?>
                                    <img src="<?php echo htmlspecialchars($course['photo']); ?>" alt="<?php echo htmlspecialchars($course['course_name']); ?>">
                                <?php else: ?>
                                    <div style="background: var(--primary-light); height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-book fa-3x" style="color: var(--primary); opacity: 0.5;"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="course-badge <?php echo $course['is_approved'] ? 'badge-approved' : 'badge-pending'; ?>">
                                    <?php echo $course['is_approved'] ? 'Approved' : 'Pending'; ?>
                                </span>
                            </div>

                            <div class="course-content">
                                <h3 class="course-title"><?php echo htmlspecialchars($course['course_name']); ?></h3>

                                <div class="course-meta">
                                    <span>
                                        <i class="fas fa-calendar-alt"></i>
                                        <?php echo htmlspecialchars($course['edition']); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        <?php echo htmlspecialchars($course['duration_months']); ?> months
                                    </span>
                                </div>

                                <div class="price-container">
                                    <?php if ($course['discounted_price'] < $course['original_price']): ?>
                                        <span class="price-original">৳<?php echo number_format($course['original_price'], 2); ?></span>
                                    <?php endif; ?>
                                    <div class="price-current">৳<?php echo number_format($course['discounted_price'], 2); ?></div>
                                </div>
                            </div>

                            <div class="course-footer">
                                <span class="enrollment-date">
                                    Enrolled <?php echo date('M d, Y', strtotime($course['created_at'])); ?>
                                </span>
                                <div>
                                    <?php if ($course['is_approved']): ?>
                                        <a href="<?php echo BASE_PATH; ?>/course/view/<?php echo htmlspecialchars($course['slug']); ?>" class="btn btn-primary btn-sm">
                                            View Details <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="status-indicator status-pending">
                                            <span class="status-dot"></span>
                                            Pending Approval
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add subtle animation to cards on hover
        document.querySelectorAll('.course-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                const img = card.querySelector('.course-media img');
                if (img) {
                    img.style.transform = 'scale(1.05)';
                }
            });

            card.addEventListener('mouseleave', () => {
                const img = card.querySelector('.course-media img');
                if (img) {
                    img.style.transform = 'scale(1)';
                }
            });
        });

        // Add ripple effect to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;

                const ripple = document.createElement('span');
                ripple.className = 'ripple-effect';
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 1000);
            });
        });
    </script>
</body>

</html>