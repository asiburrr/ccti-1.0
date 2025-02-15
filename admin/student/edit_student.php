<?php
require '../../connection.php';
require '../session.php';

// Retrieve student data based on the provided student ID
$studentID = $_GET['student_id'];
$query = "SELECT * FROM users WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $studentID);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Check if student data exists
if (!$student) {
    $errorMessages[] = 'Student not found.';
    $_SESSION['errorMessages'] = $errorMessages;
    header("Location: manage_students.php");
    exit();
}

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
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
            border: 1px solid #00008B;
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
            padding: 12px;
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
    <title>Edit Student</title>
</head>

<body>
    <?php include '../nav.php'; ?>
    <div class="content">
        <div class="container">
            <h2>Edit Student</h2>
            <div class="line"></div>
            <form id="form" action="edit_student_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="student_id" value="<?php echo $student['student_id']; ?>" name="student_id" required>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="full_name">Full Name <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="full_name" value="<?php echo $student['full_name']; ?>" name="full_name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone_number">Phone Number <i class="fas fa-asterisk"></i></label>
                        <input type="tel" class="form-control" id="phone_number" value="<?php echo $student['phone_number']; ?>" placeholder="Enter phone number" maxlength="11" name="phone_number" pattern="[0-9]{11}" title="Please enter 11 digits phone number" required>
                        <div id="phoneError" class="text-danger mt-1"></div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="gender">Gender</label>
                        <select class="custom-select" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male" <?php if ($student['gender'] == 'male') echo 'selected'; ?>>Male</option>
                            <option value="female" <?php if ($student['gender'] == 'female') echo 'selected'; ?>>Female</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="edu_level">Education Level</label>
                        <select class="custom-select" id="edu_level" name="edu_level" required>
                            <option value="">Select Education Level</option>
                            <option value="ssc" <?php if ($student['edu_level'] == 'ssc') echo 'selected'; ?>>SSC</option>
                            <option value="hsc" <?php if ($student['edu_level'] == 'hsc') echo 'selected'; ?>>HSC</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="institute">Institute</label>
                    <input type="text" class="form-control" id="institute" value="<?php echo $student['institute']; ?>" placeholder="Enter institute name" name="institute" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Update</button>
            </form>
        </div>
    </div>
    <?php require '../../toast.php'; ?>
    <script>
        const form = document.getElementById('form');
        const phoneField = document.getElementById('phone_number');
        const idField = document.getElementById('student_id');
        const phoneError = document.getElementById('phoneError');
        const submitBtn = document.getElementById('submit');
        let isDuplicate = false;

        // Validate phone number in real-time
        phoneField.addEventListener('input', () => {
            const phoneNumber = phoneField.value.trim();
            const id = idField.value.trim();

            // Check if the phone number matches the format
            if (/^01\d{9}$/.test(phoneNumber)) {
                // Check if the phone number already exists in the database
                fetch(`check_p.php?phone=${phoneNumber}&student_id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            phoneError.textContent = 'This phone number is already registered.';
                            phoneError.classList.remove('text-success');
                            phoneError.classList.add('text-danger');
                            isDuplicate = true;
                        } else {
                            phoneError.textContent = 'Number is Valid';
                            phoneError.classList.remove('text-danger');
                            phoneError.classList.add('text-success');
                            isDuplicate = false;
                        }
                    })
                    .catch(error => {
                        phoneError.textContent = 'An error occurred while verifying the phone number.';
                        phoneError.classList.remove('text-success');
                        phoneError.classList.add('text-danger');
                        isDuplicate = true;
                        console.error(error);
                    });
            } else {
                phoneError.textContent = 'Invalid phone number format.';
                phoneError.classList.remove('text-success');
                phoneError.classList.add('text-danger');
                isDuplicate = true;
            }
        });

        // Prevent form submission if there are errors
        form.addEventListener('submit', (e) => {
            if (isDuplicate) {
                e.preventDefault();
                alert('Please fix the errors before submitting.');
                return;
            }

            // Disable submit button and update text to indicate submission is in progress
            submitBtn.disabled = true;
            submitBtn.innerText = 'Submitting...';
        });
    </script>
</body>

</html>