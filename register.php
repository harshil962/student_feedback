<?php
session_start();
include 'includes/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $role = $_POST['role'];

  if (empty($name) || empty($email) || empty($password) || empty($role)) {
    $errors[] = "All fields are required.";
  }

  // Check if email already exists
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $errors[] = "Email already registered.";
  }

  // Register user
  if (empty($errors)) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed, $role);
    if ($stmt->execute()) {
      $_SESSION['user'] = [
        'id' => $stmt->insert_id,
        'name' => $name,
        'email' => $email,
        'role' => $role
      ];

      // Redirect based on role
      if ($role == 'admin') {
        header('Location: dashboard/admin.php');
      } elseif ($role == 'faculty') {
        header('Location: dashboard/faculty.php');
      } else {
        header('Location: dashboard/student.php');
      }
      exit;
    } else {
      $errors[] = "Error while registering. Try again.";
    }
  }
}
?>

<?php
$title = "Register";
include 'includes/header.php';
?>

<!-- 🌐 Responsive Registration Section -->
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light py-5">
  <div class="col-11 col-sm-9 col-md-7 col-lg-5">
    <div class="card shadow-lg border-0 rounded-4" data-aos="zoom-in">
      <div class="card-body p-4 p-md-5">
        <div class="text-center mb-4">
          <h3 class="text-primary fw-bold" data-aos="fade-down">Create Your Account</h3>
          <p class="text-muted small">Join us and get started today</p>
        </div>

        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger" data-aos="fade-in">
            <?php foreach ($errors as $err): ?>
              <p class="mb-0"><?= htmlspecialchars($err) ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form method="POST" novalidate>
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Full Name</label>
            <input type="text" name="name" class="form-control form-control-lg rounded-3" id="name" placeholder="Your name" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input type="email" name="email" class="form-control form-control-lg rounded-3" id="email" placeholder="example@mail.com" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control form-control-lg rounded-3" id="password" placeholder="Choose a secure password" required>
          </div>

          <div class="mb-4">
            <label for="role" class="form-label fw-semibold">Select Role</label>
            <select name="role" class="form-select form-select-lg rounded-3" id="role" required>
              <option value="">-- Choose Role --</option>
              <option value="student">Student</option>
              <option value="faculty">Faculty</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary btn-lg rounded-3 shadow-sm">
              <i class="bi bi-person-plus-fill"></i> Register
            </button>
          </div>
        </form>

        <div class="text-center mt-3">
          <p class="mb-2 text-muted">Already have an account?</p>
          <a href="login.php" class="btn btn-outline-success btn-sm rounded-pill px-4">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

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
