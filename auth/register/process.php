<?php
// ccti/auth/register/process.php
header('Content-Type: application/json');

require_once '../../connection.php'; // Uses $conn (MySQLi)

// Validation function for form data
function validateForm($data, $conn)
{
    $errors = [];

    // First Name
    if (empty($data['first_name']) || strlen($data['first_name']) < 2) {
        $errors['first_name'] = 'First name is required and must be at least 2 characters.';
    }

    // Last Name
    if (empty($data['last_name']) || strlen($data['last_name']) < 2) {
        $errors['last_name'] = 'Last name is required and must be at least 2 characters.';
    }

    // Gender
    if (empty($data['gender']) || !in_array($data['gender'], ['Male', 'Female'])) {
        $errors['gender'] = 'Gender is required and must be Male or Female.';
    }

    // DOB
    if (empty($data['dob'])) {
        $errors['dob'] = 'Date of birth is required.';
    } else {
        $dob = DateTime::createFromFormat('Y-m-d', $data['dob']);
        if (!$dob || $dob > new DateTime('2010-01-01')) {
            $errors['dob'] = 'Invalid date of birth or age requirement not met.';
        }
    }

    // Email
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Valid email is required.';
    } else {
        $count = null;
        $stmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $stmt->bind_param('s', $data['email']);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        if ($count > 0) {
            $errors['email'] = 'Email is already registered.';
        }
    }

    // Phone numbers
    if (empty($data['user_number']) || !preg_match('/^\d{11}$/', $data['user_number'])) {
        $errors['user_number'] = 'Your phone number must be 11 digits.';
    }
    if (empty($data['guardian_number']) || !preg_match('/^\d{11}$/', $data['guardian_number'])) {
        $errors['guardian_number'] = 'Guardian phone number must be 11 digits.';
    }

    // Address
    if (empty($data['address']) || strlen($data['address']) < 2) {
        $errors['address'] = 'Address is required and must be at least 2 characters.';
    }

    // Family names
    if (empty($data['father_name']) || strlen($data['father_name']) < 2) {
        $errors['father_name'] = 'Father\'s name is required and must be at least 2 characters.';
    }
    if (empty($data['mother_name']) || strlen($data['mother_name']) < 2) {
        $errors['mother_name'] = 'Mother\'s name is required and must be at least 2 characters.';
    }
    if (empty($data['guardian_name']) || strlen($data['guardian_name']) < 2) {
        $errors['guardian_name'] = 'Guardian\'s name is required and must be at least 2 characters.';
    }

    // Religion
    $religions = ['Islam', 'Hinduism', 'Buddhism', 'Christianity'];
    if (empty($data['religion']) || !in_array($data['religion'], $religions)) {
        $errors['religion'] = 'Religion is required and must be one of the specified options.';
    }

    // Education board
    $boards = ['Mymensingh', 'Dhaka', 'Chattogram', 'Cumilla', 'Sylhet', 'Barisal', 'Dinajpur', 'Rajshahi', 'Jashore', 'Technical', 'Madrasah'];
    if (empty($data['education_board']) || !in_array($data['education_board'], $boards)) {
        $errors['education_board'] = 'Education board is required and must be one of the specified options.';
    }

    // Education level
    if (empty($data['education_level']) || !in_array($data['education_level'], ['JSC', 'SSC'])) {
        $errors['education_level'] = 'Education level is required and must be JSC or SSC.';
    }

    // Institute
    if (empty($data['institute'])) {
        $errors['institute'] = 'Institute name is required.';
    }

    // Passing year
    if (empty($data['passing_year']) || !preg_match('/^\d{4}$/', $data['passing_year']) || $data['passing_year'] < 1990 || $data['passing_year'] > date('Y')) {
        $errors['passing_year'] = 'Passing year is required and must be between 1990 and current year.';
    }

    // Roll and Registration
    if (empty($data['roll'])) {
        $errors['roll'] = 'Roll number is required.';
    }
    if (empty($data['registration'])) {
        $errors['registration'] = 'Registration number is required.';
    }

    // ID Type
    if (empty($data['id_type']) || !in_array($data['id_type'], ['Birth Certificate', 'National ID Card'])) {
        $errors['id_type'] = 'ID type is required and must be Birth Certificate or National ID Card.';
    }

    // Identification
    if (empty($data['identification'])) {
        $errors['identification'] = 'ID number is required.';
    }

    // Terms
    if (empty($data['terms']) || $data['terms'] !== 'on') {
        $errors['terms'] = 'You must agree to the terms and conditions.';
    }

    // Password validation
    if (empty($data['password'])) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($data['password']) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }

    return $errors;
}

// Function to generate the next user_id
function generateUserId($conn)
{
    $result = $conn->query("SELECT MAX(user_id) FROM users");
    if ($result) {
        $maxId = $result->fetch_array()[0];
        $result->free();
        return $maxId === null ? 100001 : $maxId + 1;
    }
    return 100001;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['field']) && isset($_POST['value'])) {
        // Validation endpoint
        $field = $_POST['field'];
        $value = $_POST['value'];
        $errors = [];

        if ($field === 'email') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email format.';
            } else {
                $stmt = $conn->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
                $stmt->bind_param('s', $value);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();
                if ($count > 0) {
                    $errors['email'] = 'Email is already registered.';
                }
            }
        }

        if (empty($errors)) {
            echo json_encode(['valid' => true]);
        } else {
            echo json_encode(['valid' => false, 'errors' => $errors]);
        }
    } else {
        // Registration endpoint
        $data = array_map('trim', $_POST);
        $errors = validateForm($data, $conn);

        if (empty($errors)) {
            try {
                // Compute full_name as first_name + last_name
                $full_name = $data['first_name'] . ' ' . $data['last_name'];

                // Hash password using PASSWORD_DEFAULT (bcrypt)
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                // Generate and store user token
                $userToken = bin2hex(random_bytes(32));
                // Generate user_id
                $userId = generateUserId($conn);

                setcookie("user_token", $userToken, time() + (200 * 24 * 3600), "/");
                setcookie("user_type", "user", time() + (200 * 24 * 3600), "/");

                $stmt = $conn->prepare('INSERT INTO users (
                    user_id, first_name, last_name, full_name, education_level, roll, registration, institute, 
                    passing_year, board, dob, id_type, id_no, father_name, mother_name, address, 
                    email, user_number, guardian_number, guardian_name, gender, religion, terms,
                    password, token
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                )');

                $terms = 1; // Convert 'on' to 1 for database
                $stmt->bind_param(
                    'issssssssssssssssssssssss', // Fixed: 's' for password (24th param)
                    $userId,
                    $data['first_name'],
                    $data['last_name'],
                    $full_name,
                    $data['education_level'],
                    $data['roll'],
                    $data['registration'],
                    $data['institute'],
                    $data['passing_year'],
                    $data['education_board'],
                    $data['dob'],
                    $data['id_type'],
                    $data['identification'],
                    $data['father_name'],
                    $data['mother_name'],
                    $data['address'],
                    $data['email'],
                    $data['user_number'],
                    $data['guardian_number'],
                    $data['guardian_name'],
                    $data['gender'],
                    $data['religion'],
                    $terms,
                    $hashedPassword,
                    $userToken
                );

                if ($stmt->execute()) {
                    $stmt->close();
                    echo json_encode(['success' => true, 'message' => 'Registration successful', 'user_id' => $userId]);
                } else {
                    throw new Exception('Database error: ' . $conn->error);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'errors' => $errors]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>