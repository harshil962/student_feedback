<?php
// 🔐 Ensure the user is logged in
include '../includes/auth.php';

// ✅ Database connection
include '../includes/db.php';

// ✅ Header (with navbar, session, and <html> structure)
include '../includes/header.php';

// ✅ Access the current user
$user = $_SESSION['user'];
$conn = $conn ?? null;

// 🛑 Role check
if (!$user || $user['role'] !== 'student') {
  echo "<div class='container mt-5'><p class='alert alert-danger'>Access Denied!</p></div>";
  include '../includes/footer.php';
  exit;
}

// ✅ Fetch Feedback History using JOIN
$user_id = $user['id'];
$history_query = "SELECT c.name AS course_name, f.rating, f.comments, f.submitted_at 
                  FROM feedback f
                  JOIN courses c ON f.course_id = c.id
                  WHERE f.user_id = $user_id 
                  ORDER BY f.submitted_at DESC";
$history_result = $conn->query($history_query);
?>

<!-- 🌟 Student Dashboard -->
<div class="container mt-5" data-aos="fade-down">
  <h2>Welcome, <?= htmlspecialchars($user['name']) ?> 👋</h2>
  <p class="text-muted">You are logged in as <strong><?= ucfirst($user['role']) ?></strong>.</p>

  <a href="../feedback/submit.php" class="btn btn-primary mt-3 me-2" data-aos="fade-right">
    <i class="bi bi-pencil-square"></i> Submit Feedback
  </a>

  <a href="../feedback/view.php" class="btn btn-info mt-3" data-aos="fade-left">
    <i class="bi bi-bar-chart-line"></i> View Analytics
  </a>
</div>

<!-- 🗂️ Feedback History -->
<div class="container mt-5 mb-5" data-aos="fade-up">
  <h4 class="mb-3">📚 Your Feedback History</h4>

  <?php if ($history_result && $history_result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th>📘 Course</th>
            <th>⭐ Rating</th>
            <th>💬 Comments</th>
            <th>⏰ Submitted</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($fb = $history_result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($fb['course_name']) ?></td>
              <td><?= $fb['rating'] ?>/5</td>
              <td><?= htmlspecialchars($fb['comments']) ?></td>
              <td><?= date('d M Y, h:i A', strtotime($fb['submitted_at'])) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php elseif ($history_result): ?>
    <p class="text-muted">You haven’t submitted any feedback yet.</p>
  <?php else: ?>
    <p class="text-danger">⚠️ Failed to load feedback history. <?= $conn->error ?></p>
  <?php endif; ?>
</div>

<!-- ✅ Sticky Footer -->
<?php include '../includes/footer.php'; ?>
