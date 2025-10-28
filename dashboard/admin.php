<?php
// 🔐 Secure Admin Access
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/header.php';

$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'admin') {
  echo "<div class='container mt-5'><p class='alert alert-danger'>Access Denied!</p></div>";
  include '../includes/footer.php';
  exit;
}

// 📊 Stats
$total_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$total_students = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='student'")->fetch_assoc()['total'];
$total_faculty = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='faculty'")->fetch_assoc()['total'];
$total_feedback = $conn->query("SELECT COUNT(*) AS total FROM feedback")->fetch_assoc()['total'];
?>

<div class="container mt-5">
  <h2 class="text-center mb-4" data-aos="fade-down">🛠️ Admin Dashboard</h2>

  <div class="row g-4 justify-content-center">
    <!-- Total Users -->
    <div class="col-md-3" data-aos="zoom-in">
      <div class="card bg-primary text-white shadow h-100">
        <div class="card-body text-center">
          <h5><i class="bi bi-people-fill"></i> Total Users</h5>
          <h2><?= $total_users ?></h2>
        </div>
      </div>
    </div>

    <!-- Students -->
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
      <div class="card bg-success text-white shadow h-100">
        <div class="card-body text-center">
          <h5><i class="bi bi-person-circle"></i> Students</h5>
          <h2><?= $total_students ?></h2>
        </div>
      </div>
    </div>

    <!-- Faculty -->
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
      <div class="card bg-info text-white shadow h-100">
        <div class="card-body text-center">
          <h5><i class="bi bi-person-badge"></i> Faculty</h5>
          <h2><?= $total_faculty ?></h2>
        </div>
      </div>
    </div>

    <!-- Feedbacks -->
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
      <div class="card bg-warning text-dark shadow h-100">
        <div class="card-body text-center">
          <h5><i class="bi bi-chat-dots-fill"></i> Feedbacks</h5>
          <h2><?= $total_feedback ?></h2>
        </div>
      </div>
    </div>
  </div>

  <!-- Feedback Analytics Button -->
  <div class="text-center mt-5" data-aos="fade-up">
    <a href="../feedback/view.php" class="btn btn-outline-dark btn-lg">
      📊 View Feedback Analytics
    </a>
  </div>
</div>

<!-- 👥 Manage Users Section -->
<div class="container mt-5" data-aos="fade-up">
  <h3 class="text-center mb-4">👥 Manage Users</h3>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Registered On</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $user_query = $conn->query("SELECT id, name, email, role, created_at FROM users ORDER BY id DESC");

        if ($user_query && $user_query->num_rows > 0):
          while ($row = $user_query->fetch_assoc()):
        ?>
          <tr class="text-center">
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
              <span class="badge bg-<?= $row['role'] === 'admin' ? 'dark' : ($row['role'] === 'faculty' ? 'info' : 'success') ?>">
                <?= ucfirst($row['role']) ?>
              </span>
            </td>
            <td>
              <?php if (isset($row['created_at'])): ?>
                <?= date('d M Y, h:i A', strtotime($row['created_at'])) ?>
              <?php else: ?>
                <span class="text-muted">N/A</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($row['role'] !== 'admin'): ?>
                <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
              <?php else: ?>
                <span class="text-muted">N/A</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="6" class="text-center text-danger">No users found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
