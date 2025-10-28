<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/header.php';

$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'faculty') {
  echo "<div class='container mt-5'><p class='alert alert-danger'>Access Denied!</p></div>";
  include '../includes/footer.php';
  exit;
}

// Total feedback count
$total_feedback_result = $conn->query("SELECT COUNT(*) as total FROM feedback");
$total_feedback = $total_feedback_result ? $total_feedback_result->fetch_assoc()['total'] : 0;

// Course-wise feedback summary using JOIN
$course_query = "
  SELECT c.name AS course_name, 
         AVG(f.rating) AS avg_rating, 
         COUNT(f.id) AS feedback_count
  FROM feedback f
  JOIN courses c ON f.course_id = c.id
  GROUP BY f.course_id
";

$course_result = $conn->query($course_query);
?>

<div class="container mt-5">
  <h2 class="text-center mb-4" data-aos="fade-down">📊 Faculty Dashboard</h2>

  <!-- Total Feedback Card -->
  <div class="row g-4">
    <div class="col-md-4" data-aos="zoom-in">
      <div class="card text-white bg-primary shadow-sm border-0">
        <div class="card-body text-center">
          <h5 class="card-title">Total Feedback</h5>
          <h2 class="display-5 fw-bold"><?= $total_feedback ?></h2>
        </div>
      </div>
    </div>

    <!-- Feedback Summary Table -->
    <div class="col-md-8" data-aos="fade-left">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h5 class="mb-3 text-primary">📘 Course Feedback Summary</h5>
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>📚 Course</th>
                  <th>⭐ Avg Rating</th>
                  <th>📝 Feedback Count</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($course_result && $course_result->num_rows > 0): ?>
                  <?php while ($row = $course_result->fetch_assoc()): ?>
                    <tr>
                      <td><?= htmlspecialchars($row['course_name']) ?></td>
                      <td><?= number_format($row['avg_rating'], 1) ?>/5</td>
                      <td><?= $row['feedback_count'] ?></td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr><td colspan="3" class="text-center text-muted">No feedback available yet.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- View Analytics Button -->
  <div class="text-center mt-5" data-aos="fade-up">
    <a href="../feedback/view.php" class="btn btn-outline-dark btn-lg">
      📈 View Analytics Chart
    </a>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
