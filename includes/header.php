<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
<title><?= isset($title) ? htmlspecialchars($title) . " | FeedbackSys" : "FeedbackSys" ?></title>


  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- AOS CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <style>
    html, body {
      height: 100%;
      scroll-behavior: smooth;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
    }

    footer {
      margin-top: auto;
    }

    .navbar-brand span {
      font-weight: bold;
      color: #ffc107;
    }

    .nav-link:hover {
      color: #fff !important;
      text-decoration: underline;
    }

    .navbar {
      transition: all 0.3s ease-in-out;
    }
.hover-shadow:hover {
  transform: scale(1.02);
  transition: 0.3s ease;
}

    .navbar-shadow {
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>
<main>
  <!-- ✅ Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow navbar-shadow" data-aos="fade-down">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="/student_feedback/index.php">
        <i class="bi bi-chat-square-text me-2"></i> 
        <span>FeedbackSys</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="/student_feedback/index.php"><i class="bi bi-house-door"></i> Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/student_feedback/about.php"><i class="bi bi-info-circle"></i> About</a>
          </li>

          <?php if (isset($_SESSION['user'])): ?>
            <?php
              $role = $_SESSION['user']['role'];
              $dashboardLink = "/student_feedback/dashboard/" . $role . ".php";
            ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= $dashboardLink ?>"><i class="bi bi-person-check"></i> Hi, <?= htmlspecialchars($_SESSION['user']['name']) ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student_feedback/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="/student_feedback/login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/student_feedback/register.php"><i class="bi bi-person-plus"></i> Register</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
