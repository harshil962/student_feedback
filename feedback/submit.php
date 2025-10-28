<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/header.php';

$user = $_SESSION['user'];
$msg = '';

// 🔐 Only students can access this page
if ($user['role'] !== 'student') {
  echo "<div class='container mt-5'><p class='alert alert-danger'>Access Denied!</p></div>";
  include '../includes/footer.php';
  exit;
}

// 🟡 Fetch all available courses for dropdown
$courses_result = $conn->query("SELECT id, name FROM courses");

// 🟢 Handle feedback form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $course_id = $_POST['course_id'];
  $rating = $_POST['rating'];
  $comment = trim($_POST['comment']);
  $uid = $user['id'];

  if ($course_id && $rating && $comment) {
    $sql = "INSERT INTO feedback (user_id, course_id, rating, comments) 
            VALUES ('$uid', '$course_id', '$rating', '$comment')";

    if ($conn->query($sql)) {
      $msg = "<span class='text-success fw-bold'>✅ Feedback submitted successfully!</span>";
    } else {
      $msg = "<span class='text-danger fw-bold'>❌ Error: " . $conn->error . "</span>";
    }
  } else {
    $msg = "<span class='text-warning'>⚠️ Please fill all fields correctly.</span>";
  }
}
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg border-0" data-aos="zoom-in">
        <div class="card-body p-4">
          <h3 class="text-center text-primary mb-4" data-aos="fade-right">📝 Submit Feedback</h3>

          <?php if ($msg): ?>
            <div class="alert alert-light border"><?= $msg ?></div>
          <?php endif; ?>

          <form method="POST" novalidate>
            <!-- Course Dropdown -->
            <div class="mb-3">
              <label for="course" class="form-label">📚 Select Course</label>
              <select name="course_id" id="course" class="form-select" required>
                <option value="">-- Choose a course --</option>
                <?php while ($course = $courses_result->fetch_assoc()): ?>
                  <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>

            <!-- Rating -->
            <div class="mb-3">
              <label for="rating" class="form-label">⭐ Rating (1 to 5)</label>
              <input type="number" name="rating" id="rating" min="1" max="5" class="form-control" placeholder="Enter rating between 1-5" required>
            </div>

            <!-- Comments -->
            <div class="mb-3">
              <label for="comment" class="form-label">💬 Comments</label>
              <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Write your feedback..." required></textarea>
            </div>

            <div class="d-grid">
              <button class="btn btn-success">
                <i class="bi bi-check-circle-fill me-1"></i> Submit Feedback
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
