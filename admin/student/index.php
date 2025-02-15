<?php
require '../../connection.php';
require '../session.php';

// Pagination settings
$limit = 1;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle search query
$searchQuery = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
    $searchQuery = "WHERE full_name LIKE '%$searchTerm%' OR student_id LIKE '%$searchTerm%' OR phone_number LIKE '%$searchTerm%' OR institute LIKE '%$searchTerm%'";
}

// Fetch total records for pagination
$totalSql = "SELECT COUNT(*) AS total FROM users $searchQuery";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch the student records with pagination
$sql = "SELECT * FROM users $searchQuery LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
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
            <h1 class="text-center"> <i class="fas fa-users"></i> Students</h1>
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
                            <th>Roll</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Institute</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['student_id'] . "</td>";
                                echo "<td>" . $row['full_name'] . "</td>";
                                echo "<td>" . $row['phone_number'] . "</td>";
                                echo "<td>" . $row['institute'] . "</td>";
                                echo "<td class=\"action-buttons\">";
                                echo "<button onclick=\"location.href='edit_student?student_id=" . $row['student_id'] . "'\" class=\"btn btn-primary disabled\">Edit</button>";
                                echo "<button onclick=\"if(confirm('Are you sure you want to delete this student?')){location.href='delete_student?student_id=" . $row['student_id'] . "'}\" class=\"btn btn-danger\">Delete</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='color: #00008b;' class='text-center'>No students found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                            <!-- Pagination Controls -->
            <?php if ($totalRecords > $limit): ?>
                <div class="pagination">
                    <ul class="pagination">
                        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=1&search=<?= urlencode($_GET['search'] ?? '') ?>">First</a>
                        </li>
                        <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($_GET['search'] ?? '') ?>">Previous</a>
                        </li>
                        <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($_GET['search'] ?? '') ?>">Next</a>
                        </li>
                        <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $totalPages ?>&search=<?= urlencode($_GET['search'] ?? '') ?>">Last</a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require '../../toast.php'; ?>

</body>

</html>
