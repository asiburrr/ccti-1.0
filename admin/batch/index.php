<?php
require '../../connection.php';
require '../session.php';

$successMessages = [];
$errorMessages = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $start_time = $_POST['start_time'] ?? '';
    $end_time = $_POST['end_time'] ?? '';
    $fee = $_POST['fee'] ?? '';

    // Validate input
    if (empty($name)) {
        $errorMessages[] = 'Name is required.';
    }
    if (empty($start_time)) {
        $errorMessages[] = 'Start time is required.';
    }
    if (empty($end_time)) {
        $errorMessages[] = 'End time is required.';
    }
    if (empty($fee)) {
        $errorMessages[] = 'Fee is required.';
    }

    if (empty($errorMessages)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO course (name, fee, start_time, end_time) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $fee, $start_time, $end_time);

        if ($stmt->execute()) {
            $successMessages[] = 'Batch successfully added.';
        } else {
            $errorMessages[] = 'Error adding batch: ' . $stmt->error;
        }
        $stmt->close();
    }
    // Save messages in the session
    $_SESSION['successMessages'] = $successMessages;
    $_SESSION['errorMessages'] = $errorMessages;
    // Redirect back to the form page
    header("Location: ./");
    exit();
}

// Delete a Batch
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM course WHERE course_id = ?");
    $stmt->bind_param("i", $deleteId);

    if ($stmt->execute()) {
        $successMessages[] = 'Batch successfully deleted.';
    } else {
        $errorMessages[] = 'Error deleting Batch: ' . $stmt->error;
    }
    $stmt->close();
    // Save messages in the session
    $_SESSION['successMessages'] = $successMessages;
    $_SESSION['errorMessages'] = $errorMessages;
    // Redirect back to the form page
    header("Location: ./");
    exit();
}

// Fetch all course
$result = $conn->query("SELECT * FROM course");
$course = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch</title>
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


        .content {
            padding: 30px 15px;
        }

        label {
            color: #00008b;
            font-weight: bold;
        }

        h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            color: #00008b;
        }

        .form-section {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-section button {
            transition: all 0.3s;
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

        .table-container {
            margin-top: 20px;
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .btn-success {
            background-color: #00008b;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include '../nav.php'; ?>
    <div class="content">
        <div class="container">
            <!-- Form -->
            <form method="POST" class="form-section p-4 rounded shadow-sm">
                <h1><i class="fa-solid fa-book"></i> Batch</h1>

                <div class="row g-2">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter batch name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fee" class="form-label">Fee</label>
                        <input type="number" id="fee" name="fee" class="form-control" placeholder="Enter batch fee" required>
                    </div>
                </div>

                <div class="row g-2 mt-1">
                    <div class="col-md-6">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" id="end_time" name="end_time" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 mt-4">Add New</button>
            </form>


            <div class="table-container table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Fee</th>
                            <th>Enrolled</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($course)): ?>
                            <?php foreach ($course as $row): ?>
                                <tr>
                                    <td>
                                        <span
                                            class="d-inline-block text-truncate"
                                            style="max-width: 160px;"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="<?= htmlspecialchars($row['name']) ?>">
                                            <?= htmlspecialchars($row['name']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($row['fee']) ?></td>
                                    <td>
                                        <?php
                                        // Use prepared statements to fetch the count
                                        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM enrollment WHERE course_id = ?");
                                        $stmt->bind_param("i", $row['course_id']);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result && $countRow = $result->fetch_assoc()) {
                                            echo $countRow['count'];
                                        } else {
                                            echo "0";
                                        }
                                        $stmt->close();
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['start_time']) ?></td>
                                    <td><?= htmlspecialchars($row['end_time']) ?></td>
                                    <td>
                                        <button
                                            onclick="if(confirm('Are you sure you want to delete this batch?')){location.href='?delete_id=<?= htmlspecialchars($row['course_id']) ?>'}"
                                            class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No batch found.</td>
                            </tr>
                        <?php endif; ?>
                        <?php $conn->close(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require '../../toast.php'; ?>
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