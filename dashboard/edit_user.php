<?php
include '../includes/auth.php';
include '../includes/db.php';

if (!isset($_GET['id'])) {
  header("Location: admin.php");
  exit;
}

$id = (int)$_GET['id'];
$user_data = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if (!$user_data || $user_data['role'] === 'admin') {
  echo "<div class='container mt-5'><p class='alert alert-danger'>Access Denied!</p></div>";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $role = $conn->real_escape_string($_POST['role']);

  $conn->query("UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id");
  header("Location: admin.php");
  exit;
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
  <h3 class="text-center mb-4">✏️ Edit User</h3>
  <form method="post" class="col-md-6 offset-md-3 border p-4 rounded shadow" data-aos="fade-up">
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" value="<?= htmlspecialchars($user_data['name']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($user_data['email']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Role</label>
      <select name="role" class="form-select" required>
        <option value="student" <?= $user_data['role'] === 'student' ? 'selected' : '' ?>>Student</option>
        <option value="faculty" <?= $user_data['role'] === 'faculty' ? 'selected' : '' ?>>Faculty</option>
      </select>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="admin.php" class="btn btn-secondary mt-2">Cancel</a>
    </div>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
