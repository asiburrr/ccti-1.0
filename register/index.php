<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - CoreDeft</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5, #e2e8f0);
            font-family: 'Inter', sans-serif;

        }

        .form-wrapper {
            width: 100%;
            max-width: 700px;
            margin: auto;
            vertical-align: middle;
            background: white;
            border-radius: 16px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .sidebar {
            background: url('data:image/svg+xml;charset=utf-8,<svg width="100%" height="100%" viewBox="0 0 300 800" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg"><defs><radialGradient id="cosmicGradient" cx="50%" cy="50%" r="50%"><stop offset="0%" style="stop-color:%2300008b;stop-opacity:1"/><stop offset="70%" style="stop-color:%23191970;stop-opacity:1"/><stop offset="100%" style="stop-color:%23000033;stop-opacity:1"/></radialGradient><pattern id="starField" width="60" height="60" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="%23ffffff" opacity="0.8"><animate attributeName="opacity" from="0.8" to="0.2" dur="2s" repeatCount="indefinite" direction="alternate"/></circle><circle cx="40" cy="40" r="1.5" fill="%23ffffff" opacity="0.6"><animate attributeName="opacity" from="0.6" to="0.3" dur="1.5s" repeatCount="indefinite" direction="alternate"/></circle><circle cx="25" cy="50" r="0.8" fill="%23ffffff" opacity="0.5"><animate attributeName="opacity" from="0.5" to="0.1" dur="3s" repeatCount="indefinite" direction="alternate"/></circle></pattern><filter id="nebulaGlow"><feGaussianBlur stdDeviation="5" result="blur"/><feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge></filter></defs><rect width="100%" height="100%" fill="url(%23cosmicGradient)"><animate attributeName="opacity" from="0.9" to="1" dur="4s" repeatCount="indefinite" direction="alternate"/></rect><rect width="100%" height="100%" fill="url(%23starField)" opacity="0.8"/><g transform="translate(150, 400)"><circle r="40" fill="none" stroke="%231e90ff" stroke-width="1" opacity="0.5" filter="url(%23nebulaGlow)"><animateTransform attributeName="transform" type="rotate" from="0 0 0" to="360 0 0" dur="20s" repeatCount="indefinite"/></circle><circle r="20" fill="%234169e1" opacity="0.7" filter="url(%23nebulaGlow)"><animateTransform attributeName="transform" type="translate" values="0 0; 40 0; 0 0" dur="6s" repeatCount="indefinite"/><animate attributeName="opacity" from="0.7" to="0.9" dur="6s" repeatCount="indefinite" direction="alternate"/></circle></g><path d="M0 200 C80 150, 220 250, 300 200 C280 180, 150 160, 0 200 Z" fill="rgba(30,144,255,0.2)" filter="url(%23nebulaGlow)"><animate attributeName="d" values="M0 200 C80 150, 220 250, 300 200 C280 180, 150 160, 0 200 Z;M0 220 C100 170, 200 270, 300 220 C260 200, 140 180, 0 220 Z;M0 200 C80 150, 220 250, 300 200 C280 180, 150 160, 0 200 Z" dur="8s" repeatCount="indefinite"/></path><path d="M50 100 L150 200" stroke="%23ffffff" stroke-width="2" opacity="0" stroke-linecap="round" filter="url(%23nebulaGlow)"><animate attributeName="d" values="M50 100 L150 200; M150 200 L250 300; M250 300 L350 400" dur="3s" repeatCount="indefinite"/><animate attributeName="opacity" values="0; 1; 0" dur="3s" repeatCount="indefinite"/></path></svg>');
            color: #ffffff;
            padding: 2rem 1.5rem;
            background-size: cover;
            background-position: center;
            width: 100%;
            border-radius: 12px;
            height: auto;
            position: relative;
            overflow: hidden;
        }


        .sidebar-header {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
        }

        .step-item {
            margin-bottom: 1.2rem;
            padding-left: 1.75rem;
            position: relative;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .step-item.active {
            color: #60a5fa;
        }

        .step-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #94a3b8;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .step-item.active::before {
            background: #60a5fa;
            box-shadow: 0 0 8px rgba(96, 165, 250, 0.6);
        }

        .form-container {
            padding: 2rem;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        .section-header {
            font-size: 1.1rem;
            font-weight: 600;
            color: #00008b;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-container .form-control,
        .form-container .form-select {
            border-radius: 8px;
            font-size: 0.95rem;
            padding: 0.6rem 1rem;
            border: 1px solid #d1d5db;
            transition: all 0.3s ease;
        }

        .form-container .form-control:focus,
        .form-container .form-select:focus {
            border-color: #00008b;
            box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.2);
            outline: none;
        }

        /* Custom DOB Placeholder */
        .date-placeholder {
            position: relative;
        }

        .date-placeholder input[type="date"] {
            color: #6b7280;
        }

        .date-placeholder input[type="date"]:not(:focus):invalid::before {
            content: attr(data-placeholder);
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
            background-color: #fff;
        }

        .date-placeholder input[type="date"]:focus::before,
        .date-placeholder input[type="date"]:valid::before {
            content: '';
        }

        .btn-navigate {
            padding: 0.6rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .btn-navigate:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .progress-percentage {
            font-size: 0.85rem;
            color: #bfdbfe;
            margin-top: 0.75rem;
            font-weight: 500;
        }

        .invalid-feedback {
            font-size: 0.75rem;
            margin-top: 0.3rem;
        }

        /* Scrollable Terms */
        .terms-container {
            max-height: 160px;
            overflow-y: auto;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 1rem;
            background: #f9fafb;
            font-size: 0.85rem;
            color: #4b5563;
            margin-bottom: 1rem;
        }

        .terms-container::-webkit-scrollbar {
            width: 6px;
        }

        .terms-container::-webkit-scrollbar-thumb {
            background: #9ca3af;
            border-radius: 3px;
        }

        .btn-primary {
            background-color: #00008b;
            border: 2px solid #00008b;
        }

        .btn-outline-secondary {
            border: 2px solid #00008b !important;
            color: #00008b !important;
        }

        .btn-outline-secondary:active {
            background-color: rgb(99, 102, 241, 0.2) !important;
            border: 2px solid #00008b !important;
            color: #00008b !important;

        }

        .btn-outline-secondary:hover {
            background-color: rgb(99, 102, 241, 0.2) !important;
            border: 2px solid #00008b !important;
            color: #00008b !important;

        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Responsive Design */
        @media (min-width: 768px) {
            .form-wrapper {
                display: flex;
            }

            .sidebar {
                width: 240px;
                min-width: 240px;
            }

            .form-container {
                flex: 1;
            }
        }

        @media (max-width: 767.98px) {
            .form-wrapper {
                max-width: 400px;
            }

            .sidebar {
                border-radius: 16px 16px 0 0;
                padding: 1.25rem;
                text-align: center;
            }

            .sidebar-header {
                font-size: 1.4rem;
            }

            .step-item {
                display: inline-block;
                margin: 0 0.75rem 0.5rem 0;
                padding-left: 1.5rem;
                font-size: 0.85rem;
            }

            .step-item::before {
                width: 8px;
                height: 8px;
            }

            .form-container {
                padding: 1.25rem;
            }

            .section-header {
                font-size: 1rem;
            }

            .form-container .form-control,
            .form-container .form-select {
                font-size: 0.9rem;
                padding: 0.5rem 0.75rem;
            }

            .btn-navigate {
                width: 100%;
                margin-bottom: 0.5rem;
                padding: 0.5rem 1.5rem;
            }

            .terms-container {
                max-height: 141.4px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
<?php include('../nav.php'); ?>
<div class="container reg">
    <div class="form-wrapper mt-5 mb-5">
        <!-- Sidebar Progress -->
        <div class="sidebar">
            <div class="sidebar-header text-center">Sign Up</div>
            <div class="step-item active" data-step="1">Personal</div>
            <div class="step-item" data-step="2">Contact</div>
            <div class="step-item" data-step="3">Family</div>
            <div class="step-item" data-step="4">Education</div>
            <div class="step-item" data-step="5">Identity</div>
            <div class="step-item" data-step="6">Agreement</div>
            <div class="progress-percentage" id="progressText">17% Complete</div>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <form id="signupForm" novalidate>
                <!-- Step 1: Personal Details -->
                <div class="step active" data-step="1">
                    <div class="section-header">Personal Details</div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="first_name" placeholder="First Name" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="last_name" placeholder="Last Name" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="mb-2">
                        <select name="gender" id="gender" class="form-control">
                            <option value="" selected disabled>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="mb-2 date-placeholder">
                        <input type="date" class="form-control" id="dob" max="2010-01-01" data-placeholder="Date of Birth" required>
                        <div class="invalid-feedback">Select date</div>
                    </div>
                </div>

                <!-- Step 2: Contact Information -->
                <div class="step" data-step="2">
                    <div class="section-header">Contact Information</div>
                    <div class="mb-2">
                        <input type="email" class="form-control" id="email" placeholder="Email Address" required>
                        <div class="invalid-feedback">Valid email</div>
                    </div>
                    <div class="mb-2">
                        <input type="tel" class="form-control" id="user_number" placeholder="Your Phone" pattern="[0-9]{11}" required>
                        <div class="invalid-feedback">11 digits</div>
                    </div>
                    <div class="mb-2">
                        <input type="tel" class="form-control" id="guardian_number" placeholder="Guardian Phone" pattern="[0-9]{11}" required>
                        <div class="invalid-feedback">11 digits</div>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="address" placeholder="Address" required>
                        <div class="invalid-feedback">Min 2 letters</div>
                    </div>
                </div>

                <!-- Step 3: Family Details -->
                <div class="step" data-step="3">
                    <div class="section-header">Family Details</div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="father_name" placeholder="Father's Name" pattern="[A-Za-z\s]{2,}" required>
                        <div class="invalid-feedback">Min 2 letters</div>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="mother_name" placeholder="Mother's Name" pattern="[A-Za-z\s]{2,}" required>
                        <div class="invalid-feedback">Min 2 letters</div>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="g_name" placeholder="Guardian's Name" pattern="[A-Za-z\s]{2,}" required>
                        <div class="invalid-feedback">Min 2 letters</div>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="religion" placeholder="Religion" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                </div>

                <!-- Step 4: Education Details -->
                <div class="step" data-step="4">
                    <div class="section-header">Education Details</div>
                    <div class="mb-2">
                        <select class="form-control" name="education_level" id="education_level" required>
                            <option value="" selected disabled>Select Board</option>
                            <option value="Mymensingh">Mymensingh</option>
                        </select>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="education_level" placeholder="Education Level" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="institute" placeholder="Institute Name" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="mb-2">
                        <input type="number" class="form-control" id="passing_year" placeholder="Passing Year" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                </div>

                <!-- Step 5: Identity Details -->
                <div class="step" data-step="5">
                    <div class="section-header">Identity Details</div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="roll" placeholder="Roll Number" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="registration" placeholder="Registration Number" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="mb-2">
                        <select name="id_type" class="form-control" id="id_type" required>
                            <option value="" selected disabled>Select Id Type</option>
                            <option value="Birth Certificate">Birth Certificate</option>
                            <option value="National ID Card">National ID Card</option>
                        </select>
                        <div class="invalid-feedback">Required</div>
                    </div>
                    <div class="mb-2">
                        <input type="text" class="form-control" id="identification" placeholder="ID Number" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                </div>

                <!-- Step 6: Terms and Conditions -->
                <div class="step" data-step="6">
                    <div class="section-header">Terms and Conditions</div>
                    <div class="terms-container">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the Terms and Conditions
                            </label>
                            <div class="invalid-feedback">Must agree</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="d-flex justify-content-between mt-4 flex-column flex-md-row">
                    <button type="button" class="btn btn-outline-secondary btn-navigate" id="prevBtn" disabled>Previous</button>
                    <button type="button" class="btn btn-primary btn-navigate mt-2 mt-md-0" id="nextBtn">Next</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <?php include('../footer.php'); ?>

    <script>
        const steps = document.querySelectorAll('.step');
        const stepItems = document.querySelectorAll('.step-item');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const form = document.getElementById('signupForm');
        const progressText = document.getElementById('progressText');
        let currentStep = 1;

        // Load saved data
        function loadSavedData() {
            const savedData = JSON.parse(localStorage.getItem('signupFormData') || '{}');
            Object.entries(savedData).forEach(([key, value]) => {
                const field = form.querySelector(`#${key}`);
                if (field) {
                    if (field.type === 'checkbox') field.checked = value === 'on';
                    else field.value = value;
                }
            });
        }

        // Save data
        function saveData() {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            localStorage.setItem('signupFormData', JSON.stringify(data));
        }

        function updateProgress() {
            const totalFields = form.querySelectorAll('input, select, textarea').length;
            const filledFields = Array.from(form.querySelectorAll('input, select, textarea'))
                .filter(field => field.type === 'checkbox' ? field.checked : field.value.trim() !== '').length;
            const percentage = Math.round((filledFields / totalFields) * 100);
            progressText.textContent = `${percentage}% Complete`;

            stepItems.forEach(item => {
                const step = parseInt(item.dataset.step);
                item.classList.toggle('active', step === currentStep);
            });
        }

        function showStep(step) {
            steps.forEach(s => s.classList.remove('active'));
            steps[step - 1].classList.add('active');
            prevBtn.disabled = step === 1;
            nextBtn.textContent = step === steps.length ? 'Submit' : 'Next';
            nextBtn.classList.toggle('btn-success', step === steps.length);
            nextBtn.classList.toggle('btn-primary', step !== steps.length);
            updateProgress();
        }

        function validateStep(step) {
            const inputs = steps[step - 1].querySelectorAll('input, select, textarea');
            let isValid = true;
            inputs.forEach(input => {
                input.classList.add('was-validated');
                if (!input.checkValidity()) isValid = false;
                input.addEventListener('input', () => {
                    input.classList.add('was-validated');
                    saveData();
                    updateProgress();
                });
                if (input.type === 'checkbox') {
                    input.addEventListener('change', () => {
                        saveData();
                        updateProgress();
                    });
                }
            });
            return isValid;
        }

        prevBtn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        nextBtn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                if (currentStep < steps.length) {
                    currentStep++;
                    showStep(currentStep);
                } else {
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData);
                    console.log('Submitted Data:', data);
                    alert('Registration Complete!\nCheck console for data.');
                    localStorage.removeItem('signupFormData');
                    form.reset();
                    currentStep = 1;
                    showStep(currentStep);
                    steps.forEach(step => step.querySelectorAll('.was-validated')
                        .forEach(el => el.classList.remove('was-validated')));
                }
            } else {
                alert('Please fill all required fields.');
            }
        });

        // Initial setup
        loadSavedData();
        showStep(currentStep);

        // Enter key navigation
        form.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                nextBtn.click();
            }
        });
    </script>
</body>

</html>