<?php
require '../../connection.php'; // Database connection
require '../session.php'; // Session management

// Handle search query
$searchQuery = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
    $searchQuery = "WHERE u.full_name LIKE '%$searchTerm%' OR u.student_id LIKE '%$searchTerm%' OR c.name LIKE '%$searchTerm%' OR p.amount LIKE '%$searchTerm%'";
}

// Pagination settings
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total records for pagination
$totalSql = "SELECT COUNT(*) AS total FROM payment p
             JOIN users u ON p.student_id = u.student_id
             JOIN course c ON p.course_id = c.course_id
             $searchQuery";
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch the payment records with search and pagination
$sql = "SELECT 
            p.invid, 
            u.student_id, 
            u.full_name, 
            u.phone_number, 
            c.name, 
            c.course_id, 
            p.amount, 
            p.due_amount, 
            p.received_amount,
            p.discount
        FROM payment p
        JOIN users u ON p.student_id = u.student_id
        JOIN course c ON p.course_id = c.course_id
        $searchQuery
        ORDER BY p.timestamp DESC
        LIMIT $limit OFFSET $offset";
$payments = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Records</title>
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

        h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            color: #00008b;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .pagination {
            justify-content: center;
        }

        .form-control {
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #00008b;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 139, 0.25);
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

        .modal-content {
            background-color: #F7F8FB;
        }

        .btn-primary {
            background-color: #00008b;
        }

        .btn-primary:disabled {
            background-color: #ddd;
        }

        .cardd {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card {
            margin: auto;
            padding: 15px;
            border: 2px dashed #00008b;
            border-radius: 10px;
            max-width: 450px;
        }

        h2 {
            color: #00008b;
            text-align: center;
            border-bottom: 1px dashed #003366;
            padding-bottom: 2px;
            margin-top: 4px;
        }

        .btn-primary {
            background-color: #00008b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #003366;
        }

        .card-body {
            margin-top: -20px;
        }

        .card-body p {
            margin: 5px 0;
        }

        .modal p {
            margin: 3px 0px;
        }

        .pn {
            margin-top: -15px;
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
            <div class="cardd">
                <h1 class="text-center"><i class="fas fa-money-bill-alt"></i> Payment Records</h1>
                <!-- Search Form with Input Group -->
                <div class="search-bar">
                    <form method="get" action="" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <a href="./" class="btn btn-secondary">
                                Show All
                            </a>
                        </div>
                    </form>
                </div>

                <?php
                // Retrieve payment details from the query parameters
                $trxid = $_GET['trxid'] ?? '';
                $roll = $_GET['roll'] ?? '';
                $name = $_GET['name'] ?? '';
                $amount = $_GET['amount'] ?? '';
                $discount = $_GET['discount'] ?? '';

                if ($trxid && $roll && $name && $amount !== '' && $discount !== '') {
                ?>
                    <div class="card mb-2">
                        <h2>Recent Payment</h2>
                        <div class="card-body">
                            <p><strong>Roll:</strong> <?php echo $roll; ?></p>
                            <p><strong>Name:</strong> <?php echo $name; ?></p>
                            <p><strong>Amount Paid:</strong> <?php echo $amount; ?></p>
                            <p><strong>Discount:</strong> <?php echo $discount; ?></p>
                            <a target="_blank" href="receipt.php?trxid=<?php echo $trxid; ?>" class="btn btn-primary w-100"><i class="fas fa-solid fa-receipt"></i> Print Receipt</a>
                        </div>
                    </div>
                <?php
                } else {
                    echo '<p class="pn"></p>';
                }
                ?>
            </div>
            <div class="table-container table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Roll</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Batch</th>
                            <th>Amount</th>
                            <th>Due</th>
                            <th>Received</th>
                            <th>Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($payments)): ?>
                            <?php foreach (($payments) as $index => $payment): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($payment['student_id']); ?></td>
                                    <td>
                                        <span
                                            class="d-inline-block text-truncate"
                                            style="max-width: 160px;vertical-align: middle;"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="<?php echo htmlspecialchars($payment['full_name']); ?>">
                                            <?php echo htmlspecialchars($payment['full_name']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($payment['phone_number']); ?></td>
                                    <td>
                                        <span
                                            class="d-inline-block text-truncate"
                                            style="max-width: 160px;vertical-align: middle;"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="<?php echo htmlspecialchars($payment['name']); ?>">
                                            <?php echo htmlspecialchars($payment['name']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo number_format($payment['amount'], 2); ?></td>
                                    <td><?php echo number_format($payment['due_amount'], 2); ?></td>
                                    <td><?php echo number_format($payment['received_amount'], 2); ?></td>
                                    <td><?php echo number_format($payment['discount'], 2); ?></td>
                                    <td>
                                        <?php if ($payment['due_amount'] > 0): ?>
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#payModal<?php echo $payment['invid']; ?>">Pay</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted">No records found.</td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>

                <!-- Pagination -->
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

    <!-- Payment Modal -->
    <?php foreach ($payments as $payment): ?>
        <div class="modal fade" id="payModal<?php echo $payment['invid']; ?>" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="payModalLabel">Pay for <?php echo htmlspecialchars($payment['full_name']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="payment.php">
                        <div class="modal-body">
                            <input type="hidden" name="invid" value="<?php echo $payment['invid']; ?>">
                            <input type="hidden" name="course_id" value="<?php echo $payment['course_id']; ?>">
                            <input type="hidden" name="student_id" value="<?php echo $payment['student_id']; ?>">
                            <p><strong>Roll:</strong> <?php echo $payment['student_id']; ?></p>
                            <p><strong>Full Name:</strong> <?php echo $payment['full_name']; ?></p>
                            <p><strong>Batch:</strong> <?php echo $payment['name']; ?></p>
                            <p><strong>Amount:</strong> <?php echo number_format($payment['amount'], 2); ?></p>
                            <p><strong>Due:</strong> <?php echo number_format($payment['due_amount'], 2); ?> <input type="hidden" value="<?php echo $payment['due_amount']; ?>" id="due_amount<?php echo $payment['invid']; ?>"> </p>
                            <p><strong>Received:</strong> <?php echo number_format($payment['received_amount'], 2); ?></p>
                            <p><strong>Discount:</strong> <?php echo number_format($payment['discount'], 2); ?></p>

                            <div class="mb-3 mt-2">
                                <label for="paying_amount" class="form-label">Paying Amount</label>
                                <input type="number" class="form-control" placeholder="Enter amount" id="paying_amount<?php echo $payment['invid']; ?>" name="paying_amount" required step="0.01" min="0" oninput="calculateDue('<?php echo $payment['invid']; ?>')">
                            </div>

                            <div class="mb-3">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="number" class="form-control" placeholder="Enter discount" id="discount<?php echo $payment['invid']; ?>" name="discount" required step="0.01" min="0" oninput="calculateDue('<?php echo $payment['invid']; ?>')">
                            </div>

                            <div class="mb-3">
                                <label for="method" class="form-label">Payment Method</label>
                                <select class="form-control" name="method" required>
                                    <option value="Cash">Cash</option>
                                    <option value="bKash">bKash</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Rocket">Rocket</option>
                                    <option value="Upay">Upay</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="remaining_due" class="form-label">Remaining Due</label>
                                <input type="number" class="form-control" id="remaining_due<?php echo $payment['invid']; ?>" value="<?php echo number_format($payment['due_amount'], 2); ?>" readonly>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="pay_button<?php echo $payment['invid']; ?>" disabled>Pay Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php require '../../toast.php'; ?>
    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script>
        // Real-time calculation function
        function calculateDue(invid) {
            var payingAmount = parseFloat(document.getElementById('paying_amount' + invid).value) || 0;
            var discount = parseFloat(document.getElementById('discount' + invid).value) || 0;
            var dueAmount = parseFloat(document.getElementById('due_amount' + invid).value) || 0;

            // Calculate remaining due
            var remainingDue = dueAmount - payingAmount - discount;

            // Update remaining due field
            document.getElementById('remaining_due' + invid).value = remainingDue.toFixed(2);

            // Disable the "Pay Now" button if the due amount goes negative
            var payButton = document.getElementById('pay_button' + invid);
            if (remainingDue < 0 || payingAmount < 0 || discount < 0) {
                payButton.disabled = true;
            } else {
                payButton.disabled = false;
            }
        }
    </script>
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