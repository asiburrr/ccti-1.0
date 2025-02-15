<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modern Course Card</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
      font-family: 'Arial', sans-serif;
    }

    .course-card {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.4s ease, box-shadow 0.3s ease;
      background-color: #fff;
    }

    .course-card:hover {
      transform: translateY(-7px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .card-header {
      position: relative;
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      height: 200px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
      font-weight: bold;
    }

    .badge-custom {
      position: absolute;
      top: 15px;
      left: 15px;
      background-color: #ff7f50;
      color: white;
      border-radius: 20px;
      padding: 6px 14px;
      font-size: 0.8rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .progress-container {
      position: relative;
      background-color: #f8f9fa;
      border-radius: 50px;
      height: 8px;
      margin: 15px 0;
    }

    .progress-bar {
      width: 70%;
      background-color: #007bff;
      border-radius: 50px;
      height: 100%;
      transition: width 0.3s ease;
    }

    .price {
      font-size: 1.5rem;
      font-weight: bold;
      color: #e74c3c;
    }

    .old-price {
      text-decoration: line-through;
      color: #95a5a6;
      font-size: 1rem;
    }

    .enroll-btn {
      background-color: #6a11cb;
      border: none;
      border-radius: 25px;
      padding: 10px 25px;
      color: white;
      font-size: 0.9rem;
      font-weight: bold;
      transition: all 0.3s ease;
    }

    .enroll-btn:hover {
      background-color: #2575fc;
      transform: scale(1.05);
      box-shadow: 0 4px 10px rgba(37, 117, 252, 0.3);
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="course-card">
          <div class="card-header">
            Complete Web Development Bootcamp
            <div class="badge-custom">Development</div>
          </div>
          <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="most-popular bg-warning text-dark px-2 py-1 rounded">Most Popular</span>
              <span class="text-muted"><i class="bi bi-layers"></i> 12 lessons</span>
            </div>
            <p class="mb-2 text-muted">Sarah Johnson, Mike Smith</p>
            <div class="progress-container">
              <div class="progress-bar"></div>
            </div>
            <div class="d-flex align-items-center mb-3">
              <span class="text-warning me-3"><i class="bi bi-star-fill"></i> 4.8</span>
              <span class="text-muted me-3"><i class="bi bi-people"></i> 15,420 students</span>
              <span class="text-muted"><i class="bi bi-clock"></i> 32h</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="price">$99.99</span>
                <span class="old-price ms-2">$119.99</span>
              </div>
              <button class="enroll-btn">Enroll Now</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
