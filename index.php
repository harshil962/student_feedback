<?php
$title = "Home";
include 'includes/header.php';
include 'includes/db.php';

// Fetch all users
$user_sql = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
$user_result = $conn->query($user_sql);

// Fetch recent feedback
$sql = "SELECT f.comments, f.rating, u.name AS user_name, c.name AS course_name, f.submitted_at
        FROM feedback f
        JOIN users u ON f.user_id = u.id
        JOIN courses c ON f.course_id = c.id
        ORDER BY f.submitted_at DESC
        LIMIT 10";
$result = $conn->query($sql);
?>

<!-- 🌟 Hero / Welcome Section -->
<section class="container-fluid py-5 bg-light text-center" data-aos="fade-up">
  <div class="p-5 bg-white mx-auto shadow-lg rounded-4" style="max-width: 900px;">
    <h1 class="display-5 fw-bold text-primary" data-aos="zoom-in">
      Welcome to <span class="text-warning">FeedbackSys</span> 🎓
    </h1>
    <p class="lead mt-3" data-aos="fade-left">
      “We all need people who will give us feedback. That’s how we improve.”<br>
      <strong>— Bill Gates</strong>
    </p>
    <a href="login.php" class="btn btn-primary btn-lg mt-3 rounded-3 shadow-sm" data-aos="fade-right">
      <i class="bi bi-box-arrow-in-right"></i> Get Started
    </a>
  </div>
</section>

<!-- 🎯 Role Selection Section -->
<section class="container my-5">
  <h2 class="text-center text-primary fw-bold mb-5" data-aos="fade-up">Choose Your Role</h2>
  <div class="row g-4 justify-content-center">

    <div class="col-12 col-sm-6 col-lg-4" data-aos="zoom-in">
      <a href="dashboard/student.php" class="text-decoration-none text-dark">
        <div class="card border-0 shadow-lg rounded-4 h-100 text-center hover-lift">
          <div class="card-body py-5">
            <i class="bi bi-person-lines-fill display-4 text-primary mb-3"></i>
            <h5 class="fw-bold">Students</h5>
            <p class="text-muted small">Submit feedback for your courses easily.</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-sm-6 col-lg-4" data-aos="zoom-in" data-aos-delay="100">
      <a href="dashboard/faculty.php" class="text-decoration-none text-dark">
        <div class="card border-0 shadow-lg rounded-4 h-100 text-center hover-lift">
          <div class="card-body py-5">
            <i class="bi bi-bar-chart-steps display-4 text-success mb-3"></i>
            <h5 class="fw-bold">Faculty</h5>
            <p class="text-muted small">Analyze feedback and track progress.</p>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-sm-6 col-lg-4" data-aos="zoom-in" data-aos-delay="200">
      <a href="dashboard/admin.php" class="text-decoration-none text-dark">
        <div class="card border-0 shadow-lg rounded-4 h-100 text-center hover-lift">
          <div class="card-body py-5">
            <i class="bi bi-shield-lock-fill display-4 text-danger mb-3"></i>
            <h5 class="fw-bold">Admin</h5>
            <p class="text-muted small">Manage users, courses, and feedback.</p>
          </div>
        </div>
      </a>
    </div>

  </div>
</section>

<!-- 📣 Announcements Section -->
<section class="container my-5">
  <h2 class="text-center text-warning fw-bold mb-4" data-aos="fade-up">Latest Announcements</h2>
  <div class="row g-4">
    <?php 
    $announcements = [
      "New course 'Advanced Web Development' is now available! 🚀",
      "Feedback submission deadline for Semester 5: 30th August 2025 📅",
      "System maintenance scheduled on 20th August from 2 AM - 4 AM 🛠️",
      "Faculty workshop on Effective Teaching Strategies, register now! 🎯",
      "Student feedback survey for Library services is live 📋",
      "New feature: View feedback history in your dashboard 🔍",
      "Semester 6 exam schedule released - check Notices section 📄",
      "Reminder: Update your profile for accurate records ✅",
      "Orientation program for freshers on 25th August 🎉",
      "Guest lecture by Mr. Raj Patel on AI Trends 🤖",
      "Sports meet registrations open until 28th August 🏆",
      "Scholarship form submission last date: 15th Sept 2025 💰"
    ];

    foreach ($announcements as $msg) {
      echo '
      <div class="col-12 col-md-6" data-aos="fade-right">
        <div class="alert alert-info shadow-sm rounded-3">
          <i class="bi bi-megaphone-fill text-primary"></i> ' . $msg . '
        </div>
      </div>';
    }
    ?>
  </div>
</section>

<!-- 💬 Recent Feedback Section -->
<section class="container my-5">
  <h2 class="text-center text-primary fw-bold mb-5" data-aos="fade-up">Recent Feedback from Students</h2>
  <div class="list-group shadow-lg rounded-4">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between flex-wrap">
            <h5 class="mb-1 text-break">
              <?= htmlspecialchars($row['user_name']); ?> 
              <small class="text-muted">on <?= htmlspecialchars($row['course_name']); ?></small>
            </h5>
            <small class="text-muted"><?= date('M d, Y', strtotime($row['submitted_at'])); ?></small>
          </div>
          <p class="mb-1 text-break"><?= htmlspecialchars($row['comments']); ?></p>
          <small class="text-warning">⭐ <?= $row['rating']; ?>/5</small>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="list-group-item text-center">No feedback available yet.</div>
    <?php endif; ?>
  </div>
</section>

<!-- 👥 Registered Users Table -->
<section class="container my-5">
  <h2 class="text-center text-primary fw-bold mb-4" data-aos="fade-up">Registered Users</h2>
  <div class="table-responsive shadow-lg rounded-4">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-primary">
        <tr>
          <th>User ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Join Date</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($user_result && $user_result->num_rows > 0): ?>
          <?php while ($user = $user_result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($user['id']); ?></td>
              <td><?= htmlspecialchars($user['name']); ?></td>
              <td class="text-break"><?= htmlspecialchars($user['email']); ?></td>
              <td><?= htmlspecialchars(ucfirst($user['role'])); ?></td>
              <td><?= date('Y-m-d', strtotime($user['created_at'])); ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" class="text-center">No users found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</section>

<!-- ✅ Success Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
  <div id="reloadToast" class="toast align-items-center text-bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">✅ Page Reloaded Successfully</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script>
  window.addEventListener('load', () => {
    const toast = new bootstrap.Toast(document.getElementById('reloadToast'));
    toast.show();
  });
</script>

<!-- 🌈 Custom Responsive Styles -->
<style>
  body {
    background: linear-gradient(135deg, #e8f0ff 0%, #f9f9ff 100%);
  }

  .hover-lift {
    transition: all 0.3s ease;
  }
  .hover-lift:hover {
    transform: translateY(-5px);
  }

  .alert {
    font-size: 0.95rem;
  }

  @media (max-width: 768px) {
    .card-body {
      padding: 1.5rem !important;
    }
    .display-5 {
      font-size: 1.8rem;
    }
  }

  @media (max-width: 576px) {
    .table {
      font-size: 0.85rem;
    }
    .list-group-item {
      font-size: 0.9rem;
      word-wrap: break-word;
    }
  }
</style>

<?php include 'includes/footer.php'; ?>
