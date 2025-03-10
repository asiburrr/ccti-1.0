<!-- ccti/sidebar-nav.php -->
<?php
// Get the current page URL path
$currentPage = $_SERVER['REQUEST_URI'];
// Normalize by removing BASE_PATH and ensuring consistency
$currentPage = str_replace(BASE_PATH, '/', $currentPage);
// Remove query strings or fragments for cleaner comparison
$currentPage = parse_url($currentPage, PHP_URL_PATH);
?>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="profile-section">
            <img src="<?php echo htmlspecialchars($_SESSION['photo']); ?>" width="48" height="48" alt="Profile" class="profile-img">
            <div class="user-info">
                <span class="username"><?php echo htmlspecialchars($_SESSION['first_name']); ?></span>
                <span class="user-role text-muted"><?php echo htmlspecialchars($_SESSION['user_id']); ?></span>
            </div>
        </div>
    </div>
    <nav class="nav flex-column">
        <?php
        $navItems = [
            ['href' => BASE_PATH . '/user/', 'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
            ['href' => BASE_PATH . '/user/profile/', 'icon' => 'fa-user-alt', 'label' => 'Profile'],
            ['href' => BASE_PATH . '/user/courses/', 'icon' => 'fa-book-open', 'label' => 'My Courses'],
            ['href' => BASE_PATH . '/user/transactions/', 'icon' => 'fa-wallet', 'label' => 'Transactions'],
            ['href' => BASE_PATH . '/user/invoices/', 'icon' => 'fa-file-invoice', 'label' => 'Invoices'],
            ['href' => BASE_PATH . '/user/certificates/', 'icon' => 'fa-certificate', 'label' => 'Certificates'],
            ['href' => BASE_PATH . '/user/support/', 'icon' => 'fa-question-circle', 'label' => 'Support'],
            ['href' => BASE_PATH . '/user/logout', 'icon' => 'fa-sign-out-alt', 'label' => 'Logout', 'class' => 'mt-auto']
        ];

        foreach ($navItems as $item) {
            // Extract the path from href for comparison
            $itemPath = parse_url($item['href'], PHP_URL_PATH);
            // Exact match: current page must equal the item's path
            $isActive = ($currentPage === $itemPath);
            $activeClass = $isActive ? 'active' : '';
            $extraClass = isset($item['class']) ? $item['class'] : '';
            echo "<a href='{$item['href']}' class='nav-link $activeClass $extraClass'>";
            echo "<i class='fa-solid {$item['icon']}'></i> <span>{$item['label']}</span>";
            echo "</a>";
        }
        ?>
    </nav>
</aside>

<nav class="bottom-nav d-lg-none" id="bottom-nav">
    <div class="d-flex h-100 justify-content-around align-items-center">
        <?php
        $bottomNavItems = [
            ['href' => BASE_PATH . '/user/', 'icon' => 'fa-house', 'label' => 'Home'],
            ['href' => BASE_PATH . '/user/courses/', 'icon' => 'fa-book-open', 'label' => 'Courses'],
            ['href' => BASE_PATH . '/user/transactions/', 'icon' => 'fa-wallet', 'label' => 'Transactions'],
            ['href' => '#', 'icon' => 'fa-bars', 'label' => 'Menu', 'toggle' => true]
        ];

        foreach ($bottomNavItems as $nav) {
            $itemPath = parse_url($nav['href'], PHP_URL_PATH);
            $isActive = !$nav['toggle'] && ($currentPage === $itemPath);
            $activeClass = $isActive ? 'active' : '';
            $toggleClass = $nav['toggle'] ? 'profile-toggle' : '';
            $toggleAttr = $nav['toggle'] ? 'onclick="toggleSidebar()"' : '';
            echo "<a href='{$nav['href']}' class='nav-item $activeClass $toggleClass' $toggleAttr>";
            echo "<i class='fa-solid {$nav['icon']}'></i>";
            echo "<small>{$nav['label']}</small>";
            echo "</a>";
        }
        ?>
    </div>
</nav>

<style>
    :root {
        --primary-color: #00008b;
        --secondary-color: #ffffff;
        --accent-color: #4169e1;
        --bg-light: #f8fafc;
        --text-dark: #1f2937;
        --text-muted: #6b7280;
        --shadow-sm: 0 2px 10px rgba(0, 0, 139, 0.06);
        --shadow-md: 0 4px 20px rgba(0, 0, 139, 0.1);
        --sidebar-width: 280px;
        --transition: all 0.3s ease;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: var(--secondary-color);
        box-shadow: var(--shadow-md);
        padding: 1.75rem;
        z-index: 1050;
        transform: translateX(-100%);
        transition: var(--transition);
        overflow-y: auto;
    }

    .sidebar.active {
        transform: translateX(0);
    }

    @media (min-width: 992px) {
        .sidebar {
            transform: translateX(0);
        }
    }

    .sidebar-header {
        border-bottom: 1px solid rgba(0, 0, 139, 0.1);
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .profile-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .profile-img {
        border-radius: 50%;
        border: 2px solid var(--primary-color);
        object-fit: cover;
        transition: transform 0.2s ease;
    }

    .profile-section:hover .profile-img {
        transform: scale(1.05);
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .username {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1.2;
    }

    .user-role {
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    .sidebar .nav-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.875rem 1.25rem;
        color: var(--text-muted);
        text-decoration: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background: var(--bg-light);
        color: var(--primary-color);
        box-shadow: inset 0 0 0 1px rgba(0, 0, 139, 0.1);
    }

    .sidebar .nav-link i {
        font-size: 1.25rem;
        width: 20px;
        text-align: center;
    }

    .sidebar .nav-link.mt-auto {
        margin-top: auto;
        color: #dc3545;
    }

    .sidebar .nav-link.mt-auto:hover {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .bottom-nav {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 400px;
        height: 70px;
        background: var(--secondary-color);
        border-radius: 50px;
        box-shadow: var(--shadow-md);
        z-index: 1000;
        padding: 0 10px;
        transition: var(--transition);
    }

    .bottom-nav:hover {
        box-shadow: 0 6px 25px rgba(0, 0, 139, 0.15);
    }

    .nav-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        text-decoration: none;
        transition: var(--transition);
    }

    .nav-item i {
        font-size: 1.5rem;
        margin-bottom: 0.25rem;
        transition: transform 0.2s ease;
    }

    .nav-item small {
        font-size: 0.75rem;
        font-weight: 500;
        opacity: 0.8;
    }

    .nav-item.active {
        color: var(--primary-color);
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

    @keyframes slideIn {
        from { transform: translateX(-100%); }
        to { transform: translateX(0); }
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }

    document.querySelectorAll('.nav-item:not(.profile-toggle)').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            window.location.href = this.getAttribute('href');
        });
    });
</script>