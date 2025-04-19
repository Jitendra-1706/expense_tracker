<?php
require_once "./config.php";
session_start();

if(empty($_SESSION['id'])){
  header("Location:login.php");
}

$user_id = $_SESSION['id'];
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'date';

if ($mode === 'category') {
  $sql = "SELECT c.name AS label, SUM(e.expense) AS total 
  FROM expense e
  JOIN categories c ON e.expense_category = c.category_id
  WHERE e.user_id = '$user_id'
  GROUP BY c.name
  ORDER BY total DESC";

} else {
  $sql = "SELECT expense_date AS label, SUM(expense) AS total 
          FROM expense 
          WHERE user_id = '$user_id' 
          GROUP BY expense_date 
          ORDER BY expense_date ASC";
}


$result = mysqli_query($link, $sql);

$labels = [];
$totals = [];

while ($row = mysqli_fetch_assoc($result)) {
  $labels[] = $row['label'];
  $totals[] = $row['total'];
}
?>






<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expense tracker / home</title>
    <?php include("./includes/header.php") ?>
    <link rel="shortcut icon" href="./assets/images/expense.png" type="image/x-icon">
    <link rel="stylesheet" href="/expense_tracker/assets/css/index.css?v=timestamp">

    <!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>
  <body>
    
<?php include("./includes/navbar.php") ?>



<div class="container mt-5">
  <h3 class="mb-4 text-white">Your Expenses</h3>

  <!-- Mode Switcher (Date or Category) -->
  <form method="get" class="mb-3 d-flex align-items-center">
    <label for="mode" class="me-2 text-white">View By:</label>
    <select name="mode" id="mode" class="form-select w-auto me-3" onchange="this.form.submit()">
      <option value="date" <?= $mode === 'date' ? 'selected' : '' ?>>Date</option>
      <option value="category" <?= $mode === 'category' ? 'selected' : '' ?>>Category</option>
    </select>

    <!-- Chart Type Switch Buttons -->
    <div>
      <button type="button" class="btn btn-outline-primary me-2" onclick="switchChart('line')">Line</button>
      <button type="button" class="btn btn-outline-warning" onclick="switchChart('bar')">Bar</button>
    </div>
  </form>

  <!-- Chart Canvas -->
  <canvas id="expenseChart" height="100"></canvas>
</div>


<script>
  const labels = <?php echo json_encode($labels); ?>;
  const data = <?php echo json_encode($totals); ?>;

  let currentType = 'line';
  const ctx = document.getElementById('expenseChart').getContext('2d');

  const chartConfig = (type) => ({
    type: type,
    data: {
      labels: labels,
      datasets: [{
        label: 'Total Expense (₹)',
        data: data,
        backgroundColor: type === 'bar' ? 'rgba(255, 159, 64, 0.4)' : 'rgba(54, 162, 235, 0.3)',
        borderColor: type === 'bar' ? 'rgba(255, 159, 64, 1)' : 'rgba(54, 162, 235, 1)',
        borderWidth: 2,
        fill: type === 'line',
        tension: 0.4,
        pointBackgroundColor: '#ffffff', // dots
        pointBorderColor: type === 'bar' ? 'rgba(255, 159, 64, 1)' : 'rgba(54, 162, 235, 1)'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          labels: {
            color: '#ffffff' // legend text color
          }
        },
        tooltip: {
          backgroundColor: '#222',
          titleColor: '#fff',
          bodyColor: '#ccc'
        }
      },
      scales: {
        x: {
          ticks: {
            color: '#ffffff' // x-axis labels
          },
          grid: {
            color: 'rgba(255, 255, 255, 0.1)' // x-axis grid
          }
        },
        y: {
          beginAtZero: true,
          ticks: {
            color: '#ffffff' // y-axis labels
          },
          grid: {
            color: 'rgba(255, 255, 255, 0.1)' // y-axis grid
          }
        }
      }
    }
  });

  let chart = new Chart(ctx, chartConfig(currentType));

  function switchChart(type) {
    chart.destroy();
    chart = new Chart(ctx, chartConfig(type));
    currentType = type;
  }
</script>


























<?php include("./includes/footer.php") ?>
</body>
</html>                        