<?php
require '../connection.php';
require 'session.php';

// Fetch counts from the database
$totalStudents = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$totalCourse = $conn->query("SELECT COUNT(*) as count FROM course")->fetch_assoc()['count'];
$totalSms = $conn->query("SELECT COUNT(*) as count FROM sms_history")->fetch_assoc()['count'];
$totalAmountReceived = $conn->query("SELECT SUM(amount) as total FROM payment_history")->fetch_assoc()['total'] ?? 0;
// Calculate the date 15 days ago in 'Y-m-d' format for the SQL query
$sevenDaysAgo = date('Y-m-d', strtotime('-15 days'));

$paymentDataQuery = "SELECT DATE_FORMAT(timestamp, '%d %b') AS payment_date, SUM(amount) AS total_payment
                    FROM payment_history
                    WHERE DATE(timestamp) >= '$sevenDaysAgo'
                    GROUP BY payment_date
                    ORDER BY timestamp";

$paymentDataResult = $conn->query($paymentDataQuery);
$paymentData = [];

// Fetch payment data with formatted dates
if ($paymentDataResult && $paymentDataResult->num_rows > 0) {
    while ($row = $paymentDataResult->fetch_assoc()) {
        $paymentData[] = $row;
    }
}

// Generate an array of dates for the last 15 days in 'd M' format
$fifteenDays = [];
for ($i = 0; $i < 15; $i++) {
    $date = date('d M', strtotime("-$i days"));
    $fifteenDays[] = $date;
}

// Fill missing dates with 0 payment
foreach ($fifteenDays as $day) {
    $found = false;
    foreach ($paymentData as $data) {
        if ($data['payment_date'] === $day) { 
            $found = true;
            break;
        }
    }
    if (!$found) {
        $paymentData[] = ['payment_date' => $day, 'total_payment' => 0];
    }
}

// Sort the data by date
usort($paymentData, function ($a, $b) {
    return strtotime($a['payment_date']) - strtotime($b['payment_date']);
});


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
        ORDER BY ph.timestamp DESC
        LIMIT 5";
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <style>
        body {
            background-color: #00008B;
            font-family: 'Arial', sans-serif;
        }

        .content header {
            margin-top: -20px;
        }

        .content .h2 {
            color: #00008B;
            margin-bottom: -5px;
            font-size: 30px;
            font-weight: bold;
        }

        body .content .card {
            outline: 2px solid #FFF;
            border-radius: 1.5rem;
            transition: transform 0.3s;
            box-shadow: 0 0 15px rgba(255, 255, 255);
        }

        .card:hover {
            transform: translateY(-10px);
        }


        .card-number {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .card-header {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }


        .out {
            background-color: #F2F9FF;
            border-color: #00008B;
            color: #00008B;
            box-shadow: 0 0 10px rgba(255, 255, 255);
            border-radius: 2rem;
        }

        .btn-outline-primary {
            color: #00008B;
            border-color: #00008B;
        }

        .btn-outline-primary:hover {
            background-color: #00008B;
            color: #FFF;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: auto;
            margin-top: 20px;
        }

        .li {
            margin-bottom: 10px;
        }

        .li .a {
            display: block;
            background-color: white;
            padding: 15px;
            border-radius: 5px;
            color: #00008B;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .li .a:hover {
            background-color: #00008B;
            color: white;
        }

        .al {
            font-size: 24px;
        }

        .text-primary {
            color: #00008B !important;
        }

        .bg-primary {
            background-color: #FFFFFF !important;
            border: none;
        }

        .bg-primary .card-body {
            color: #00008B !important;
        }

        .bg-successs {
            background-color: #FFFFFF !important;
            border: none;
        }

        .bg-successs .card-body {
            color: #4CAF50 !important;
        }

        .bg-dangerr {
            background-color: #FFFFFF !important;
            border: none;
        }

        .bg-dangerr .card-body {
            color: #F44336 !important;
        }

        .bg-warning {
            background-color: #FFFFFF !important;
            border: none;
        }

        .bg-warning .card-body {
            color: #FFC107 !important;
        }


        .bg-secondary {
            background-color: #757575 !important;
        }

        .bg-dark {
            background-color: #424242 !important;
        }

        .grp {
            color: #00008B;
            padding-bottom: 15px !important;
        }

        #exam-count,
        #p-exam-count {
            color: #00008B;
        }

        #paymentChartContainer {
            height: 400px;
            margin: 0px auto;
            background-color: #FFFFFF;
            box-shadow: 0 0 10px rgba(255, 255, 255);
            border: 1px solid #fff;
            border-radius: 10px;
            padding: 15px;
        }

        #paymentChart,
        #smsHistoryChart {
            width: 100%;
            height: 400px;
        }


        .btn-primary {
            background-color: #00008b;
            border: none;
            color: #FFFFFF;
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
            text-align: center;
        }

        .h2 {
            color: #00008B;
            font-weight: bold;
        }

        @media (max-width: 767px) {
            .out {
                display: none;
            }

            #paymentChartContainer {
                height: 300px;
                padding: 5px;
            }

            #paymentChart,
            #smsHistoryChart {
                height: 300px;
            }

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
    <?php include 'nav.php'; ?>
    <div class="content">
        <header class="d-flex justify-content-between align-items-center py-3 mb-4 border-bottom">
            <h1 class="h2">BOB 0FFLINE STUDIO</h1>
            <form action="http://192.168.0.103/bob_offline/admin/logout" method="post">
                <button type="submit" class="btn btn-primary out">Sign out</button>
            </form>
        </header>
        <div id="paymentChartContainer" class="col-lg-12 col-md-12">
            <canvas id="paymentChart"></canvas>
        </div>
        <br>
        <h2 class="h2">Recent Payment</h2>
        <div class="table-container table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Roll</th>
                        <th>Name</th>
                        <th>Batch </th>
                        <th>Amount</th>
                        <th>Discount</th>
                        <th>Method</th>
                        <th>Timestamp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $count = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $count++ ?></td>
                                <td><?= htmlspecialchars($row['student_id']) ?></td>
                                <td>
                                    <span
                                        class="d-inline-block text-truncate"
                                        style="max-width: 160px;vertical-align: middle;"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="<?= htmlspecialchars($row['student_name']) ?>">
                                        <?= htmlspecialchars($row['student_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="d-inline-block text-truncate"
                                        style="max-width: 160px;vertical-align: middle;"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="<?= htmlspecialchars($row['course_name']) ?>">
                                        <?= htmlspecialchars($row['course_name']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($row['amount']) ?> BDT</td>
                                <td><?= htmlspecialchars($row['discount']) ?> BDT</td>
                                <td><?= htmlspecialchars($row['method']) ?></td>
                                <td><?= htmlspecialchars($row['timestamp']) ?></td>
                                <td>
                                    <a target="_blank" href="payment/receipt.php?trxid=<?= htmlspecialchars($row['trxid']) ?>" class="btn btn-primary btn-sm">
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
        </div>
        <br>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Students</h5>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <p class="card-text">Total students enrolled</p>
                        <h3 class="card-number"><?php echo $totalStudents; ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-white bg-successs">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Course</h5>
                            <i class="fa-solid fa-book fa-2x"></i>
                        </div>
                        <p class="card-text">Total Courses</p>
                        <h3 class="card-number"><?php echo $totalCourse; ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">SMS</h5>
                            <i class="fa-solid fa-sms fa-2x"></i>
                        </div>
                        <p class="card-text">Total has been sent</p>
                        <h3 class="card-number"><?php echo $totalSms; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-white bg-dangerr">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Amount</h5>
                            <i class="fas fa-money-bill-alt	 fa-2x"></i>
                        </div>
                        <p class="card-text">Total Received</p>
                        <h3 class="card-number"><?php echo $totalAmountReceived; ?> Tk</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require '../toast.php'; ?>
    <script>
        var paymentData = <?php echo json_encode($paymentData); ?>;
        var paymentDates = paymentData.map(function(item) {
            return item.payment_date;
        });
        var paymentAmounts = paymentData.map(function(item) {
            return item.total_payment;
        });
        var ctx = document.getElementById('paymentChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(0,0,139, 0.7)');
        gradient.addColorStop(1, 'rgba(0,0,139, 0.2)');

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: paymentDates,
                datasets: [{
                    label: 'Amount',
                    data: paymentAmounts,
                    borderColor: 'rgba(0,0,139)',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgba(0,0,139)',
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Payment History Last 15 Days',
                    fontSize: 14,
                    fontColor: 'rgba(0, 0, 0, 0.7)',
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return value.toFixed(0);
                            },
                            fontColor: 'rgba(0, 0, 0, 0.7)',
                        },
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.1)',
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Amount',
                            fontColor: 'rgba(0, 0, 0, 0.7)',
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontColor: 'rgba(0, 0, 0, 0.7)',
                        },
                        gridLines: {
                            color: 'rgba(0, 0, 0, 0.1)',
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'Date',
                            fontColor: 'rgba(0, 0, 0, 0.7)',
                        }
                    }]
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
            }
        });
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