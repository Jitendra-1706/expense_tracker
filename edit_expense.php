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
$user_id = $_SESSION['id'];

// 1. Get the expense ID from the URL
if (!isset($_GET['id'])) {
    echo "No expense selected.";
    exit;
}

$expense_id = $_GET['id'];

// 2. Fetch the expense
$query = "SELECT * FROM expense WHERE id = '$expense_id' AND user_id = '$user_id'";
$result = mysqli_query($link, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Expense not found.";
    exit;
}

$expense = mysqli_fetch_assoc($result);

// 3. If the form is submitted, update the data
if (isset($_POST['update'])) {
    $amount = mysqli_real_escape_string($link, $_POST['expense']);
    $date = mysqli_real_escape_string($link, $_POST['expense_date']);
    $category = mysqli_real_escape_string($link, $_POST['expense_category']);

    $update = "UPDATE expense SET expense = '$amount', expense_date = '$date', expense_category = '$category' 
               WHERE id = '$expense_id' AND user_id = '$user_id'";

    if (mysqli_query($link, $update)) {
        header("Location: delete_expense.php?msg=updated");
        exit;
    } else {
        echo "Update failed. Try again.";
    }
}


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



<div class="container mt-5">
  <div class="row d-flex justify-content-center">
    <div class="col-md-6">
      <h3>Edit Expense</h3>
      <form method="POST">
        <div class="form-floating mb-3">
          <input type="number" class="form-control" name="expense" value="<?= htmlspecialchars($expense['expense']) ?>" required>
          <label for="expense">Amount</label>
        </div>

        <div class="form-floating mb-3">
          <input type="date" class="form-control" name="expense_date" value="<?= htmlspecialchars($expense['expense_date']) ?>" required>
          <label for="expense_date">Date</label>
        </div>

        <div class="form-floating mb-3">
          <input type="text" class="form-control" name="expense_category" value="<?= htmlspecialchars($expense['expense_category']) ?>" required>
          <label for="expense_category">Category</label>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update Expense</button>
        <a href="delete_expense.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>






























<?php include("./includes/footer.php") ?>
</body>
</html>