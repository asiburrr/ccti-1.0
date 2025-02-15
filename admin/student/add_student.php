<?php
require '../../connection.php';
require '../session.php';

// Retrieve the last student ID from the users table
$sql = "SELECT MAX(student_id) AS lastID FROM users";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$lastID = $row['lastID'];

// Generate the new student ID
$newID = $lastID >= 11111 ? $lastID + 1 : 11111;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #00008B;
            margin: 10px;

        }

        .container {
            max-width: 550px;
            margin: 10px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #00008B;
            font-weight: bold;
        }

        .line {
            display: flex;
            padding: 1px;
            margin-bottom: 10px;
            background-color: #00008B;
        }

        label {
            font-weight: 700;
            color: #00008B;
        }

        .form-control {
            border-radius: 20px;
            margin-bottom: 0px;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #00008B;
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #1a3944;
        }

        select.custom-select {
            border-radius: 20px;
            padding: 8px;
            box-shadow: none;
        }

        .fa-asterisk {
            color: red;
            font-size: 14px;
        }
    </style>
    <title>Add Student</title>
</head>

<body>
    <?php include '../nav.php'; ?>
    <div class="content">
        <div class="container">
            <h2>Add Student</h2>
            <div class="line"></div>
            <form id="form" action="add_student_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="student_id" name="student_id" value="<?php echo $newID; ?>" readonly>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="first_name" placeholder="Enter first name" name="first_name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="last_name" placeholder="Enter last name" name="last_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="full_name">Full Name <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="full_name" name="full_name" readonly required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone_number">Phone Number <i class="fas fa-asterisk"></i></label>
                        <input type="tel" class="form-control" id="phone_number" placeholder="Enter phone number" name="phone_number" pattern="[0-9]{11}" maxlength="11" title="Please enter 11 digits phone number" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="institute" class="form-label">Institute <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" placeholder="Enter college name" id="institute" name="institute" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="session" class="form-label">HSC Session <i class="fas fa-asterisk"></i></label>
                        <select class="form-control" id="session" name="session" required>
                            <option value="">Select Session</option>
                            <?php
                            $currentYear = date("Y");
                            $startYear = $currentYear - 2;
                            $endYear = $currentYear + 2;

                            for ($year = $startYear; $year <= $endYear; $year++) {
                                $nextYear = $year + 1;
                                $session = $year . " - " . $nextYear;
                                echo '<option value="' . $session . '">' . $session . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="father_name">Father's Name <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="father_name" placeholder="Enter father's name" name="father_name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="father_number">Phone Number (Father's) <i class="fas fa-asterisk"></i></label>
                        <input type="tel" class="form-control" id="father_number" placeholder="Enter phone number" name="father_number" pattern="[0-9]{11}" maxlength="11" title="Please enter 11 digits phone number" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="gpa">GPA (SSC) <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="gpa" placeholder="Enter ssc gpa" name="gpa" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="reg">Registration number (SSC) <i class="fas fa-asterisk"></i></label>
                        <input type="tel" class="form-control" id="reg" placeholder="Enter ssc registration number" name="reg" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="course" class="form-label">Course <i class="fas fa-asterisk"></i></label>
                    <select class="form-control" id="course" name="course" required>
                        <option value="">Select Course</option>
                        <?php
                        // Fetch courses along with the fee and enrolled count
                        $query = "
                            SELECT c.course_id, c.name, c.start_time, c.end_time, c.fee, 
                                (SELECT COUNT(*) FROM enrollment e WHERE e.course_id = c.course_id) AS enrolled_count
                            FROM course c
                        ";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['course_id']) . '">';
                                echo htmlspecialchars($row['name']) . ' - ' . htmlspecialchars($row['fee']) . ' Tk ( ' . htmlspecialchars($row['start_time']) . ' - ' . htmlspecialchars($row['end_time']) . ' ) (' . htmlspecialchars($row['enrolled_count']) . ')';
                                echo '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" id="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
    </div>
    <?php require '../../toast.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var firstNameInput = document.getElementById('first_name');
            var lastNameInput = document.getElementById('last_name');
            var fullNameInput = document.getElementById('full_name');

            function updateFullName() {
                var firstName = firstNameInput.value.trim();
                var lastName = lastNameInput.value.trim();
                fullNameInput.value = firstName + ' ' + lastName;
            }

            firstNameInput.addEventListener('input', updateFullName);
            lastNameInput.addEventListener('input', updateFullName);
        });
    </script>
</body>

</html>