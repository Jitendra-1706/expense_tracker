<?php
require_once "./config.php";

session_start();

if (empty($_SESSION['id'])) {
  header("Location:login.php");
  exit;
}

$user_id = $_SESSION['id'];

if (isset($_GET['expense_id'])) {
  $delete_id = mysqli_real_escape_string($link, $_GET['expense_id']);
  $delete_query = "DELETE FROM expense WHERE expense_id = '$delete_id' AND user_id = '$user_id'";
  
  if (mysqli_query($link, $delete_query)) {
    header("Location: delete_expense.php?msg=deleted");
    exit;
  } else {
    echo "Error deleting expense.";
  }
}

// Fetch all expenses for the user
$query = "SELECT * FROM expense WHERE user_id = '$user_id' ORDER BY expense_date DESC";
$result = mysqli_query($link, $query);


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



    <!-- Table code -->
    <div class="container mt-2">
      <h2 class="mb-4">My Expenses</h2>
      <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-success">Expense deleted successfully.</div>
      <?php endif; ?>

      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Sl.no</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Category</th>
            <th>Action</th>
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
              echo "<td>" . htmlspecialchars($row['expense_category']) . "</td>";
              echo "<td>
                    <a href='delete_expense.php?expense_id=" . $row['expense_id'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this expense?');\">Delete</a>
                  </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='5' class='text-center'>No expenses added yet.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div> 






























<?php include("./includes/footer.php") ?>
</body>
</html>