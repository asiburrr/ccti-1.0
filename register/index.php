<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Form - 4 Steps</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f4f7fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
      max-width: 700px;
      margin-top: 60px;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .form-control,
    .form-select {
      border-radius: 8px;
      background-color: #f9f9f9;
      padding: 12px;
      border: 1px solid #ccc;
      transition: border-color 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #007bff;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .form-label {
      font-weight: 500;
      color: #333;
    }

    .btn-custom {
      background-color: #007bff;
      color: #fff;
      border-radius: 8px;
      font-weight: 600;
      padding: 12px 30px;
      transition: background-color 0.3s;
    }

    .btn-custom:hover {
      background-color: #0056b3;
    }

    .form-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-step {
      display: none;
    }

    .form-step.active {
      display: block;
    }

    .progress {
      height: 10px;
      background-color: #f0f0f0;
      border-radius: 20px;
      margin-bottom: 30px;
    }

    .progress-bar {
      height: 100%;
      border-radius: 20px;
    }

    .form-footer {
      text-align: center;
      margin-top: 30px;
    }

    .terms-container {
      font-size: 0.875rem;
      color: #6c757d;
    }

    .terms-container input {
      margin-right: 8px;
    }

    .form-group {
      margin-bottom: 20px;
    }
  </style>
</head>

<body>

  <div class="container">
    <h2 class="form-header">Create Your Account</h2>
    <form id="signupForm">
      <!-- Progress Bar -->
      <div class="progress">
        <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
      </div>

      <!-- Step 1: Personal Details -->
      <div class="form-step active" id="step1">
        <h5>Step 1: Personal Details</h5>
        <div class="form-group">
          <label for="first_name" class="form-label">First Name</label>
          <input type="text" class="form-control" id="first_name" required>
        </div>
        <div class="form-group">
          <label for="last_name" class="form-label">Last Name</label>
          <input type="text" class="form-control" id="last_name" required>
        </div>
        <div class="form-group">
          <label for="dob" class="form-label">Date of Birth</label>
          <input type="date" class="form-control" id="dob" required>
        </div>
        <div class="form-group">
          <label for="full_name" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="full_name" required>
        </div>
        <div class="form-footer">
          <button type="button" class="btn btn-custom" id="next1">Next</button>
        </div>
      </div>

      <!-- Step 2: Educational and Contact Information -->
      <div class="form-step" id="step2">
        <h5>Step 2: Educational and Contact Information</h5>
        <div class="form-group">
          <label for="education_level" class="form-label">Education Level</label>
          <input type="text" class="form-control" id="education_level" required>
        </div>
        <div class="form-group">
          <label for="roll" class="form-label">Roll</label>
          <input type="text" class="form-control" id="roll" required>
        </div>
        <div class="form-group">
          <label for="registration" class="form-label">Registration Number</label>
          <input type="text" class="form-control" id="registration" required>
        </div>
        <div class="form-group">
          <label for="institute" class="form-label">Institute</label>
          <input type="text" class="form-control" id="institute" required>
        </div>
        <div class="form-group">
          <label for="passing_year" class="form-label">Passing Year</label>
          <input type="text" class="form-control" id="passing_year" required>
        </div>
        <div class="form-group">
          <label for="board" class="form-label">Board</label>
          <input type="text" class="form-control" id="board" required>
        </div>
        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" required>
        </div>
        <div class="form-footer">
          <button type="button" class="btn btn-custom" id="next2">Next</button>
        </div>
      </div>

      <!-- Step 3: Family and Address Information -->
      <div class="form-step" id="step3">
        <h5>Step 3: Family and Address Information</h5>
        <div class="form-group">
          <label for="father_name" class="form-label">Father's Name</label>
          <input type="text" class="form-control" id="father_name" required>
        </div>
        <div class="form-group">
          <label for="mother_name" class="form-label">Mother's Name</label>
          <input type="text" class="form-control" id="mother_name" required>
        </div>
        <div class="form-group">
          <label for="guardian_number" class="form-label">Guardian Number</label>
          <input type="text" class="form-control" id="guardian_number" required>
        </div>
        <div class="form-group">
          <label for="address" class="form-label">Address</label>
          <textarea class="form-control" id="address" rows="3" required></textarea>
        </div>
        <div class="form-footer">
          <button type="button" class="btn btn-custom" id="next3">Next</button>
        </div>
      </div>

      <!-- Step 4: Gender, Religion and Terms -->
      <div class="form-step" id="step4">
        <h5>Step 4: Gender, Religion, and Terms</h5>
        <div class="form-group">
          <label for="gender" class="form-label">Gender</label>
          <select class="form-select" id="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="form-group">
          <label for="religion" class="form-label">Religion</label>
          <input type="text" class="form-control" id="religion" required>
        </div>
        <div class="terms-container">
          <input type="checkbox" id="terms" required>
          <label for="terms">I accept the <a href="#">Terms and Conditions</a></label>
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-custom">Submit</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Bootstrap 5 JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

  <!-- Custom JavaScript -->
  <script>
    let currentStep = 1;
    const totalSteps = 4;
    const progressBar = document.getElementById('progressBar');
    const steps = document.querySelectorAll('.form-step');
    const nextButtons = document.querySelectorAll('button[type="button"]');

    // Update the progress bar
    function updateProgressBar() {
      const progress = (currentStep - 1) / (totalSteps - 1) * 100;
      progressBar.style.width = `${progress}%`;
    }

    // Show the current step and hide the others
    function showStep() {
      steps.forEach((step, index) => {
        step.classList.remove('active');
        if (index === currentStep - 1) {
          step.classList.add('active');
        }
      });
      updateProgressBar();
    }

    // Handle "Next" button clicks
    nextButtons.forEach((button, index) => {
      button.addEventListener('click', () => {
        if (currentStep < totalSteps) {
          currentStep++;
          showStep();
        }
      });
    });

    // Initialize the form
    showStep();
  </script>

</body>

</html>
