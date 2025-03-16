<!-- dashboard.html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <!-- Include the common header file (simulated) -->
    <!-- In a real environment, replace this with server-side include -->
</head>

<body>
<?php include 't.php'; ?> 
    <!-- The header.html content would be included here -->
    <!-- For this example, assume header, sidebar, and scripts are already present from header.html -->

    <!-- Page-specific content -->
    <div id="main-content">
        <!-- Header is already included from header.html, so we start after it -->
        <div class="container-fluid p-4">
            <div class="card card-dashboard">
                <div class="card-body">
                    <h5 class="card-title">Welcome</h5>
                    <button class="btn btn-primary mt-3">Take Action</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Card-specific styles (moved from original dashboard) -->
    <style>
        .card-dashboard {
            background: var(--card-bg);
            color: var(--card-text);
            border-radius: 15px;
            box-shadow: 0 6px 20px var(--shadow-color);
            transition: transform 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--text-color);
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>

</html>