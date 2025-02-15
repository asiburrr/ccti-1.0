<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<style>
    body {
        padding: 5px;
        background: #ffffff;
        font-family: 'Arial', sans-serif;
    }

    ::-webkit-scrollbar {
        width: 0.25em;
        background-color: #000;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #fff;
        margin: 4px;
        border-radius: 4px;
    }

    .content {
        padding: 20px !important;
        background: #F7F8FB !important;
        border-radius: 8px !important;
        box-shadow: 0 0 10px rgba(255, 255, 255) !important;
        border: 2px solid #F2F9FF !important;
    }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        width: 210px;
        background: #F7F8FB;
        box-shadow: 0 0 10px rgba(255, 255, 255);
        border-right: 1px solid #fff;
        color: #ffffff;
        z-index: 100;
        transition: all 0.3s;
        overflow-y: auto;
        /* Added: Make sidebar scrollable */
    }

    .sidebar-nav {
        margin-bottom: 10px;
        background: #F7F8FB;
    }

    .welcome {
        padding: 10px 20px;
        text-align: center;
        background-color: #ebf4ff;
        color: #00008b;
    }

    .welcome a {
        color: #00008b;
        text-decoration: none;
    }

    .welcome a:hover {
        text-decoration: underline;
    }

    .sidebar.show {
        left: 0;
    }

    .sidebar .sidebar-nav-item {
        padding: 8px 18px;
        margin-left: 6px;
        margin-right: 6px;
    }

    .sidebar .sidebar-nav-link {
        color: #00008b;
        font-size: 19px;
    }

    .sidebar .sidebar-nav-item:hover,
    .sidebar .sidebar-nav-item:focus {
        color: #00008b;
        background-color: #ffffff;
        border-radius: 6px;
        border-left: 3px solid #00008b;
    }

    .sidebar-nav-link:hover {
        text-decoration: none;
    }

    .dropdown-menu {
        color: black;
        background-color: rgba(255, 255, 255);
        border-radius: 10px;
    }

    .dropdown-item {
        color: #fff;
        border-radius: 8px;
    }

    .menu-toggle {
        position: fixed;
        top: 22px;
        right: 20px;
        color: #ffffff;
        cursor: pointer;
        z-index: 200;
        display: block;
    }

    .content {
        margin-left: 210px;
        transition: all 0.3s ease-in-out;
    }

    .content.sidebar-show {
        margin-left: 0;
    }

    .menu-toggle i {
        font-size: 24px;
        display: none;
    }

    .sidebar-nav-link,
    .dropdown-item {
        color: #00008b;
        text-decoration: none;
    }

    .logout-form {
        text-align: center;
        background-color: #ebf4ff;
        padding: 5px;
    }

    .logout-form:hover {
        background-color: #ebf1ff;
    }

    .logout-form .logout-btn {
        display: inline-block;
        padding: 4px 8px;
        background-color: #ebf4ff;
        color: #00008b;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }


    @media (max-width: 767px) {
        .sidebar {
            left: -240px;
        }

        .sidebar-nav {
            top: 20px;
        }

        .content {
            margin-left: 0px;
            transition: all 0.3s ease-in-out;
            padding: 10px !important;
        }

        .menu-toggle {
            right: 20px;
            display: block;

        }

        .menu-toggle i {
            font-size: 24px;
            display: block;
            color: #333;
            right: 5px;
        }

        .sidebar-nav-link,
        .dropdown-item {
            color: #00008b;
            text-decoration: none;
        }

    }

    .unreplied-count {
        font-size: 12px;
        padding: 2px 6px;
        border-radius: 10px;
    }

    .unreplied-count-red {
        color: #fff;
        background-color: #dc3545;
    }

    .fa-bars {
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
    }
</style>
<div class="sidebar">
    <div class="sidebar-nav">
        <div class="welcome"><a href=""><i class="fa-solid fa-circle-info"></i> Welcome, <?php echo $_SESSION['username']; ?></a></div>
        <div class="sidebar-nav-item">
            <a class="sidebar-nav-link" href="http://192.168.0.103/bob_offline/admin/">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </div>
        <?php
        if ($role === "administration") {
        ?>
            <div class="sidebar-nav-item dropdown">
                <a class="sidebar-nav-link dropdown-toggle" href="#" id="studentDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-user-tie"></i>
                    Admins
                </a>
                <ul class="dropdown-menu" aria-labelledby="studentDropdown">
                    <li><a class="dropdown-item" href="http://192.168.0.103/bob_offline/admin/admin/add_admin"><i class="fas fa-user-plus"></i> Add admin</a></li>
                    <li><a class="dropdown-item" href="http://192.168.0.103/bob_offline/admin/admin/"><i class="fas fa-users"></i> Manage admins</a></li>
                </ul>
            </div>
        <?php
        }
        ?>

        <div class="sidebar-nav-item dropdown">
            <a class="sidebar-nav-link dropdown-toggle" href="#" id="studentDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i>
                Students
            </a>
            <ul class="dropdown-menu" aria-labelledby="studentDropdown">
                <li><a class="dropdown-item" href="http://192.168.0.103/bob_offline/admin/student/add_student"><i class="fas fa-user-plus"></i> Add student</a></li>
                <li><a class="dropdown-item" href="http://192.168.0.103/bob_offline/admin/student/"><i class="fas fa-users"></i> Manage students</a></li>
            </ul>
        </div>
        <div class="sidebar-nav-item">
            <a class="sidebar-nav-link" href="http://192.168.0.103/bob_offline/admin/batch/">
            <i class="fa-solid fa-list"></i>
                Batch
            </a>
        </div>
        <div class="sidebar-nav-item">
            <a class="sidebar-nav-link" href="http://192.168.0.103/bob_offline/admin/payment/">
                <i class="fas fa-money-bill-alt"></i>
                Payment
            </a>
        </div>
        <div class="sidebar-nav-item">
            <a class="sidebar-nav-link" href="http://192.168.0.103/bob_offline/admin/payment/history">
                <i class="fas fa-history"></i>
                History
            </a>
        </div>
    </div>
    <div class="logout-form">
        <form action="http://192.168.0.103/bob_offline/admin/logout" method="post">
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </div>
</div>
<div class="menu-toggle">
    <i class="fas fa-bars"></i>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        content.classList.toggle('sidebar-show');
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('show');
            content.classList.remove('sidebar-show');
        }
    });
</script>