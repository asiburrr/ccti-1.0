<?php
require '../../common.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - CoreDeft</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
            padding: 2rem;
            background-size: cover;
            background-position: center;
            width: 100%;
            border-radius: 12px;

            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .sidebar-header {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: 0.5px;
        }


        .form-container {
            margin: 0px 50px;
            padding: 20px 0px;
        }

        .section-header {
            font-size: 2rem;
            font-weight: 600;
            color: #00008b;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
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








        .login-container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 380px;
            text-align: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .login-title {
            font-size: 40px;
            font-weight: bold;
            color: #00008b;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
        }

        .fc {
            border-radius: 50px;
            padding-left: 50px;
            font-size: 16px;
            height: 45px;
            transition: all 0.3s ease;
        }

        .fc:focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
            transform: scale(1.05);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .bp {
            background-color: #00008b;
            border-color: #00008b;
            font-size: 16px;
            border-radius: 50px;
            padding: 12px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .bp:hover {
            background-color: #0051a2;
            transform: translateY(-2px);
        }

        .login-btn-google {
            text-decoration: none;
            background-color: #000;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 50px;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .login-btn-google:hover {
            background-color: #ccc;
            transform: translateY(-2px);
        }

        .login-btn-google svg {
            width: 20px;
            height: 20px;
        }

        .divider {
            position: relative;
            margin: 10px 0;
            text-align: center;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            border-top: 1px solid #ddd;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .divider span {
            position: relative;
            font-size: 14px;
            color: #777;
            padding: 0 10px;
            background-color: #fff;
        }

        .forgot-password {
            font-size: 14px;
            margin-top: 15px;
            color: #00008b;
        }

        .forgot-password a {
            color: #00008b;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .note {
            margin-top: 15px;
            font-size: 12px;
            color: #888;
            margin-bottom: -10px;
        }

        .note span a {
            font-weight: bold;
            color: #00008b;
        }

        .loading {
            display: none;
            margin-left: 10px;
        }

        .alert {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
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


            .form-container {
                margin: 0px 20px;
                padding: 20px 0px;
            }
        }
    </style>
</head>

<body>
    <?php include('../../nav.php'); ?>
    <div class="container reg">
        <div class="form-wrapper mt-5 mb-5">
            <!-- Sidebar Progress -->
            <div class="sidebar">
                <div class="sidebar-header text-center">Sign In</div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="section-header">Welcome, back</div>
                <form id="loginForm">
                    <input type="hidden" id="csrfToken" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <div class="mb-3 form-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" class="form-control fc" id="userID" placeholder="Enter ID" required>
                    </div>
                    <div class="mb-3 form-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control fc" id="password" placeholder="Enter Password" required>
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-primary bp w-100 mb-2">
                        <span id="submitBtnText"><i class="fas fa-sign-in-alt"></i> Sign In</span>
                        <span class="spinner-border spinner-border-sm loading" id="submitBtnSpinner" role="status" aria-hidden="true"></span>
                        <span id="submitBtnProcessing" class="loading">Processing...</span>
                    </button>
                    <div class="divider">
                        <span>OR</span>
                    </div>
                    <?php
                    echo "<a href='' class='login-btn-google'><i class='fab fa-google'></i> Sign In with Google</a>";
                    ?>
                </form>
            </div>
        </div>
    </div>
    <!-- Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
        <template id="toast-template">
            <div class="toast animate__animated animate__fadeInRight" role="alert" style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);">
                <div class="toast-header" style="border-radius: 10px 10px 0 0;">
                    <i class="fas me-2"></i>
                    <strong class="me-auto"></strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body"></div>
                <div class="progress" style="height: 5px; margin: 0; border-radius: 0 0 10px 10px; background-color: #ffffff;">
                    <div class="progress-bar" role="progressbar" style="width: 100%;"></div>
                </div>
            </div>
        </template>
    </div>
    <?php require('../../footer.php'); ?>
    <?php require('../../toast.php'); ?>
    <script>
        function showToast(message, type = 'error') {
            const template = document.getElementById('toast-template');
            const toastEl = template.content.cloneNode(true).querySelector('.toast');
            const container = document.querySelector('.toast-container');

            const isSuccess = type === 'success';
            toastEl.classList.add(isSuccess ? 'bg-success' : 'bg-danger', 'text-white');
            const header = toastEl.querySelector('.toast-header');
            header.classList.add(isSuccess ? 'bg-success' : 'bg-danger', 'text-white');

            const icon = toastEl.querySelector('.fas');
            icon.classList.add(isSuccess ? 'fa-check-circle' : 'fa-exclamation-circle');
            header.querySelector('strong').textContent = isSuccess ? 'Success' : 'Error';
            toastEl.querySelector('.toast-body').textContent = message;

            container.appendChild(toastEl);
            const toast = new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 5000
            });

            const progressBar = toastEl.querySelector('.progress-bar');
            progressBar.classList.add(isSuccess ? 'bg-success' : 'bg-danger');
            let width = 100;
            const interval = 50;
            const decrement = (interval / 5000) * 100;

            const intervalId = setInterval(() => {
                width -= decrement;
                if (width <= 0) {
                    width = 0;
                    clearInterval(intervalId);
                }
                progressBar.style.width = `${width}%`;
            }, interval);

            toastEl.addEventListener('hidden.bs.toast', () => {
                clearInterval(intervalId);
                toastEl.remove();
            });

            toast.show();
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const userID = document.getElementById('userID').value;
            const password = document.getElementById('password').value;
            const csrfToken = document.getElementById('csrfToken').value;

            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtnText').style.display = 'none';
            document.getElementById('submitBtnSpinner').style.display = 'inline-block';
            document.getElementById('submitBtnProcessing').style.display = 'inline-block';

            setTimeout(() => {
                fetch('process', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            userID,
                            password,
                            csrfToken
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Login successful!', 'success');
                            setTimeout(() => window.location.href = '../../user', 1500);
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        document.getElementById('submitBtn').disabled = false;
                        document.getElementById('submitBtnText').style.display = 'inline-block';
                        document.getElementById('submitBtnSpinner').style.display = 'none';
                        document.getElementById('submitBtnProcessing').style.display = 'none';
                    });
            }, 1000);
        });
    </script>
</body>

</html>