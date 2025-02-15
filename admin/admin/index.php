<?php
require '../../connection.php';
require '../session.php';

// Check if admin_id is set in session
if (isset($_SESSION['username'])) {
    $admin_id = $_SESSION['username'];

    // Prepare SQL query to get the admin's role
    $sql = "SELECT role FROM admins WHERE admin_id = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $admin_id, $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if admin is found
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        $role = $admin['role'];

        // Check the role
        if ($role === 'administration') {
        } else {
            // Admin does not have the correct role, redirect with error message
            $_SESSION['errorMessages'] = ['You don\'t have access to view this page.'];
            header("Location: ../");
            exit();
        }
    } else {
        // Admin not found, redirect with error message
        $_SESSION['errorMessages'] = ['You don\'t have access to view this page.'];
        header("Location: ../");
        exit();
    }
} else {
    // admin_id not set in session, redirect with error message
    $_SESSION['errorMessages'] = ['You don\'t have access to view this page.'];
    header("Location: ../");
    exit();
}


// Handle user search by admin_id
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM admins WHERE 
            admin_id  LIKE '%$search%' OR  
            username LIKE '%$search%' OR
            email LIKE '%$search%' OR
            phone_number LIKE '%$search%' OR
            first_name LIKE '%$search%' OR 
            last_name LIKE '%$search%' OR 
            full_name = '$search'";
} else {
    // Start with a default query
    $sql = "SELECT * FROM admins WHERE 1";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
                html body {
            font-family: Arial, sans-serif;
        }

        ::-webkit-scrollbar {
            width: 0.5em;
            background-color: #0700DE;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #F2F9FF;
            margin: 4px;
            border-radius: 4px;
        }

        .content {
            padding: 20px;
            background-color: #00008B;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255);
            border: 2px solid #F2F9FF;
        }

        .content h1 {
            color: #00008B;
            margin-bottom: 15px;
        }

        .table th {
            color: #00008b;
            font-weight: bold;
            text-align: center;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table td,
        .table th {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .table-container {
            margin-top: 20px;
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }


        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-start;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            color: #00008b;
            background-color: #fff;
            padding: 16px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #00008b;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 139, 0.25);
        }

        .btn-primary {
            background-color: #00008b;
            border: none;
        }
        .pagination {
            justify-content: center;
        }

        .action-buttons button {
            margin-right: 4px;
            border-radius: 8px;
        }

        .action-buttons .btn-primary {
            background-color: #0700DE;
            border: 1px solid #F2F9FF;
        }

        .action-buttons .btn-danger {
            background-color: #DDFFC9;
            border: 1px solid #F2F9FF;
            color: #0700DE;
        }

        .action-buttons .btn {
            margin-bottom: 2px;
        }

    </style>
</head>

<body>
    <?php include '../nav.php'; ?>
    <div class="content">
        <div class="container">
        <!-- Search -->
        <div class="search-bar mb-4 d-block">
            <h1 class="text-center"><i class="fa-solid fa-user-tie"></i> Admins</h1>
                <form method="get" action="" class="form-inline">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="./" class="btn btn-warning">
                            Show All
                        </a>
                    </div>
                </form>
            </div>

            <div class="table-container table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Admin Id</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Number</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        // Execute the sql
                        $result = $conn->query($sql);


                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['admin_id'] . "</td>";
                                echo "<td>";
                                echo $row['full_name'];
                                echo "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['phone_number'] . "</td>";

                                // Check if 'activities_time' is '0000-00-00 00:00:00'
                                if ($row['activities'] == '0000-00-00 00:00:00') {
                                    echo "<td>Not logged in recently</td>";
                                } else {
                                    // Get the user's last activity time
                                    $lastActivityTime = new DateTime($row['activities'], new DateTimeZone('Asia/Dhaka'));
                                    $currentTime = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

                                    // Calculate the time difference
                                    $interval = $lastActivityTime->diff($currentTime);

                                    // Display active status based on the time difference
                                    if ($interval->y > 0) {
                                        echo "<td>{$interval->y} years ago</td>";
                                    } elseif ($interval->m > 0) {
                                        echo "<td>{$interval->m} months ago</td>";
                                    } elseif ($interval->d > 0) {
                                        echo "<td>{$interval->d} days ago</td>";
                                    } elseif ($interval->h > 0) {
                                        echo "<td>{$interval->h} hours ago</td>";
                                    } elseif ($interval->i > 0) {
                                        echo "<td>{$interval->i} minutes ago</td>";
                                    } else {
                                        echo "<td>Active now</td>";
                                    }
                                }

                                echo "<td class=\"action-buttons right\">";
                                echo "<button onclick=\"location.href='edit_admin?admin_id=" . $row['admin_id'] . "'\" class=\"btn btn-primary\">Edit</button>";
                                echo "<button onclick=\"if(confirm('Are you sure you want to delete this admin?')){location.href='delete_admin?admin_id=" . $row['admin_id'] . "'}\" class=\"btn btn-danger\">Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td style='color: #f2f9ff;' colspan='8'>No admins found.</td></tr>";
                        }

                        // Close the database connection
                        $conn->close();
                        ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require '../../toast.php'; ?>
</body>

</html>