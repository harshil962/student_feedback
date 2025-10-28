<?php
include 'includes/db.php';
session_start();

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_role'] = $user['role'];

      switch ($user['role']) {
        case 'student':
          header('Location: dashboard/student.php');
          break;
        case 'faculty':
          header('Location: dashboard/faculty.php');
          break;
        case 'admin':
          header('Location: dashboard/admin.php');
          break;
        default:
          header('Location: index.php');
      }
      exit;
    } else {
      $msg = "Incorrect password.";
    }
  } else {
    $msg = "User not found.";
  }
}
?>

<?php
$title = "Login";
include 'includes/header.php';
?>

<!-- 🌐 Responsive Login Section -->
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light py-5">
  <div class="col-11 col-sm-9 col-md-7 col-lg-5">
    <div class="card shadow-lg border-0 rounded-4" data-aos="zoom-in">
      <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
          <h3 class="text-primary fw-bold" data-aos="fade-down">Welcome Back!</h3>
          <p class="text-muted small">Login to your Feedback System account</p>
        </div>

        <?php if (!empty($msg)): ?>
          <div class="alert alert-danger text-center"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg rounded-3" id="email" placeholder="Enter your email" required>
          </div>

          <div class="mb-4">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control form-control-lg rounded-3" id="password" placeholder="Enter your password" required>
          </div>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-success btn-lg rounded-3 shadow-sm">
              <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
          </div>
        </form>

        <div class="text-center mt-3">
          <p class="mb-2 text-muted">Don't have an account?</p>
          <a href="register.php" class="btn btn-outline-primary btn-sm rounded-pill px-4">
            <i class="bi bi-person-plus-fill"></i> Register Now
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 🌈 Custom Styles -->
<style>
  body {
    background: linear-gradient(135deg, #e8f0ff 0%, #f9f9ff 100%);
  }
  .card {
    transition: all 0.3s ease;
  }
  .card:hover {
    transform: translateY(-5px);
  }
  @media (max-width: 576px) {
    .card-body {
      padding: 1.5rem !important;
    }
    .card img {
      width: 60px;
    }
  }
</style>

<?php include 'includes/footer.php'; ?>
