<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/header.php';

$user = $_SESSION['user'];
if ($user['role'] == 'student') {
  echo "<div class='container mt-5'><p class='alert alert-danger'>Access Denied!</p></div>";
  include '../includes/footer.php';
  exit;
}

// ✅ Updated JOIN query to get course names with feedback
$sql = "SELECT c.name AS course_name, AVG(f.rating) as avg_rating, COUNT(*) as total_feedback 
        FROM feedback f 
        JOIN courses c ON f.course_id = c.id 
        GROUP BY c.name";

$result = $conn->query($sql);

if (!$result) {
  die("<div class='container mt-5'><p class='text-danger'>❌ SQL Error: " . $conn->error . "</p></div>");
}

$courses = $ratings = $counts = [];

while ($row = $result->fetch_assoc()) {
  $courses[] = $row['course_name'];
  $ratings[] = round($row['avg_rating'], 2);
  $counts[] = $row['total_feedback'];
}
?>

<div class="container mt-5">
  <div class="card shadow-lg" data-aos="zoom-in">
    <div class="card-body">
      <h3 class="card-title mb-4 text-center" data-aos="fade-down">📊 Feedback Analytics Overview</h3>
      <canvas id="ratingChart" height="120"></canvas>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('ratingChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= json_encode($courses) ?>,
    datasets: [
      {
        label: '⭐ Average Rating',
        data: <?= json_encode($ratings) ?>,
        backgroundColor: 'rgba(0, 123, 255, 0.7)',
        borderColor: 'rgba(0, 123, 255, 1)',
        borderWidth: 1,
      },
      {
        label: '📝 Total Feedback',
        data: <?= json_encode($counts) ?>,
        backgroundColor: 'rgba(40, 167, 69, 0.6)',
        borderColor: 'rgba(40, 167, 69, 1)',
        borderWidth: 1,
        type: 'line',
        yAxisID: 'y1'
      }
    ]
  },
  options: {
    responsive: true,
    interaction: {
      mode: 'index',
      intersect: false,
    },
    scales: {
      y: {
        beginAtZero: true,
        max: 5,
        title: {
          display: true,
          text: 'Average Rating'
        }
      },
      y1: {
        beginAtZero: true,
        position: 'right',
        title: {
          display: true,
          text: 'Total Feedback Count'
        },
        grid: {
          drawOnChartArea: false
        }
      }
    },
    plugins: {
      tooltip: {
        callbacks: {
          label: function(ctx) {
            return ctx.dataset.label + ": " + ctx.raw;
          }
        }
      },
      legend: {
        position: 'bottom',
        labels: {
          boxWidth: 20,
          padding: 15
        }
      }
    }
  }
});
</script>

<?php include '../includes/footer.php'; ?>
