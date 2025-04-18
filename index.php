<?php
require_once "./config.php";

session_start();

if(empty($_SESSION['id'])){
  header("Location:login.php");
}

// Make sure the user is logged in
if (!isset($_SESSION['id'])) {
  echo "You must be logged in to view expenses.";
  exit;
}

// $user_id = $_SESSION['id'];

// Fetch expenses for the user
// $query = "SELECT * FROM expense WHERE user_id = '$user_id' ORDER BY expense_date DESC";
// $result = mysqli_query($link, $query);

$user_id = $_SESSION['id'];

$category = $_GET['category'] ?? '';
$date = $_GET['date'] ?? '';
$sort = $_GET['sort'] ?? '';

// Base query
$sql = "SELECT e.*, c.name AS category_name 
        FROM expense e 
        JOIN categories c ON e.expense_category = c.category_id 
        WHERE e.user_id = '$user_id'";

// Add filters
if (!empty($category)) {
  $category = mysqli_real_escape_string($link, $category);
  $sql .= " AND c.name LIKE '%$category%'";
}

if (!empty($date)) {
  $date = mysqli_real_escape_string($link, $date);
  $sql .= " AND Expense_date = '$date'";
}

// Add sorting
switch ($sort) {
  case 'expense_asc':
    $sql .= " ORDER BY expense ASC";
    break;
  case 'expense_desc':
    $sql .= " ORDER BY expense DESC";
    break;
  case 'expense_date_asc':
    $sql .= " ORDER BY expense_date ASC";
    break;
  case 'expense_date_desc':
    $sql .= " ORDER BY expense_date DESC";
    break;
  default:
    $sql .= " ORDER BY expense_date DESC";
}

$result = mysqli_query($link, $sql);

?>




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expense Teacker</title>
    <?php include("./includes/header.php") ?>
    <link rel="shortcut icon" href="./assets/images/expense.png" type="image/x-icon">
    </head>
  <body>
    
<?php include("./includes/navbar.php") ?>



<?php
// Get all categories for dropdown
$categoryOptions = mysqli_query($link, "SELECT * FROM categories");
?>

<!-- 📦 Expense Filters and Table -->
<div class="container mt-5">
  <div class="row">
    <form method="GET" class="mb-4">
      <div class="row g-3 align-items-end">
        <!-- Category Dropdown -->
        <div class="col-md-4">
          <label for="category" class="form-label">Filter by Category</label>
          <select name="category" id="category" class="form-select">
            <option value="">All Categories</option>
            <?php while ($cat = mysqli_fetch_assoc($categoryOptions)): ?>
              <option value="<?= htmlspecialchars($cat['name']) ?>" <?= (($_GET['category'] ?? '') === $cat['name']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>

        <!-- Date Filter -->
        <div class="col-md-3">
          <label for="date" class="form-label">Filter by Date</label>
          <input type="date" name="date" id="date" class="form-control" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
        </div>

        <!-- Sorting -->
        <div class="col-md-3">
          <label for="sort" class="form-label">Sort By</label>
          <select name="sort" id="sort" class="form-select">
            <option value="">Default</option>
            <option value="expense_asc" <?= (($_GET['sort'] ?? '') === 'expense_asc') ? 'selected' : '' ?>>Amount (Low to High)</option>
            <option value="expense_desc" <?= (($_GET['sort'] ?? '') === 'expense_desc') ? 'selected' : '' ?>>Amount (High to Low)</option>
            <option value="expense_date_asc" <?= (($_GET['sort'] ?? '') === 'expense_date_asc') ? 'selected' : '' ?>>Date (Oldest First)</option>
            <option value="expense_date_desc" <?= (($_GET['sort'] ?? '') === 'expense_date_desc') ? 'selected' : '' ?>>Date (Newest First)</option>
          </select>
        </div>

        <!-- Submit Button -->
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">Apply</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- 💸 Expense Table -->
<div class="container mt-2">
  <h2 class="mb-4">My Expenses</h2>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Sl. No</th>
        <th>Amount</th>
        <th>Date</th>
        <th>Category</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $count = 1;
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>" . $count++ . "</td>";
          echo "<td>₹" . htmlspecialchars($row['expense']) . "</td>";
          echo "<td>" . htmlspecialchars($row['expense_date']) . "</td>";
          echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='4' class='text-center'>No expenses added yet.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>































<?php include("./includes/footer.php") ?>
</body>
</html>                        