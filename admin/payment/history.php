<?php
require '../../connection.php';
require '../session.php';

// Handle search
$searchQuery = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
    $searchQuery = "WHERE u.full_name LIKE '%$searchTerm%' OR u.student_id LIKE '%$searchTerm%' OR c.name LIKE '%$searchTerm%' OR ph.amount LIKE '%$searchTerm%' OR ph.trxid LIKE '%$searchTerm%'";
}

// Pagination 
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total records for pagination
$totalSql = "SELECT COUNT(*) AS total FROM payment_history ph
             INNER JOIN users u ON ph.student_id = u.student_id
             INNER JOIN course c ON ph.course_id = c.course_id
             $searchQuery";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Determine if we should apply pagination or not
$paginationEnabled = $totalRecords > $limit;

// Fetch payment history with search and pagination
$sql = "SELECT 
            ph.ph_id, 
            ph.invid, 
            ph.student_id, 
            u.full_name AS student_name, 
            ph.course_id, 
            c.name AS course_name, 
            ph.amount, 
            ph.discount, 
            ph.trxid, 
            ph.method, 
            ph.timestamp
        FROM payment_history ph
        INNER JOIN users u ON ph.student_id = u.student_id
        INNER JOIN course c ON ph.course_id = c.course_id
        $searchQuery
        ORDER BY ph.timestamp DESC
        " . ($paginationEnabled ? "LIMIT $limit OFFSET $offset" : "");

$result = $conn->query($sql);

if (!$result) {
    die("Error fetching payment history: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
                body {
            font-family: 'Arial', sans-serif;
            background-color: #F7F8FB;
            color: #00008b;
            margin: 0;
            padding: 0;
        }

        .btn-primary {
            background-color: #00008b;
            border: none;
        }

        .he {
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
        }

        .form-control {
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #00008b;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 139, 0.25);
        }


        .pagination {
            justify-content: center;
        }

        @media (max-width: 767px) {
            table {
                font-size: 13px;
            }

            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <?php include '../nav.php'; ?>
    <div class="content">
        <div class="container">

        <div class="he">
            <h1 class="text-center mb-4"><i class="fas fa-history"></i> Payment History</h1>

            <!-- Search -->
            <div class="search-bar mb-4 d-block">
                <form method="get" action="" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="history" class="btn btn-warning">
                            Show All
                        </a>
                    </div>
                </form>
            </div>
        </div>

            <div class="table-container table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Roll</th>
                            <th>Name</th>
                            <th>Batch</th>
                            <th>Amount</th>
                            <th>Discount</th>
                            <th>Method</th>
                            <th>Timestamp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php $count = $offset + 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= htmlspecialchars($row['student_id']) ?></td>
                                    <td>
                                        <span class="d-inline-block text-truncate" style="max-width: 160px;vertical-align: middle;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars($row['student_name']) ?>">
                                            <?= htmlspecialchars($row['student_name']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="d-inline-block text-truncate" style="max-width: 160px;vertical-align: middle;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= htmlspecialchars($row['course_name']) ?>">
                                            <?= htmlspecialchars($row['course_name']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($row['amount']) ?> BDT</td>
                                    <td><?= htmlspecialchars($row['discount']) ?> BDT</td>
                                    <td><?= htmlspecialchars($row['method']) ?></td>
                                    <td><?= htmlspecialchars($row['timestamp']) ?></td>
                                    <td>
                                        <a target="_blank" href="receipt.php?trxid=<?= htmlspecialchars($row['trxid']) ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-solid fa-receipt"></i> Print
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No payment found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <?php if ($paginationEnabled): ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
</body>

</html>