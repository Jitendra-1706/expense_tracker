<?php
session_start();
require_once "./config.php";

// Handle form submission
if (isset($_POST['submit'])) {
  $amount = $_POST['expense_amount'];
  $date = $_POST['expense_date'];
  $category_id = $_POST['expense_category']; // will be category ID now

  $user_id = $_SESSION['id'];

  // Insert with category ID (foreign key)
  $insert = "INSERT INTO expense (user_id, expense, expense_date, expense_category) 
             VALUES ('$user_id', '$amount', '$date', '$category_id')";

  if (!mysqli_query($link, $insert)) {
    echo "Error adding expense: " . mysqli_error($link);
  }
}

// Fetch categories for the dropdown
$categoryQuery = "SELECT category_id, name FROM categories";
$categoryResult = mysqli_query($link, $categoryQuery);


?>




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expense Teacker</title>
    <?php include("./includes/header.php") ?>
    <link rel="shortcut icon" href="./assets/images/expense.png" type="image/x-icon">
    <link rel="stylesheet" href="/expense_tracker/assets/css/add.css">

    </head>
  <body>
    
<?php include("./includes/navbar.php") ?>



<section class="section">
<form action="" method="POST">
  <section class="section">
    <div class="wrapper-1">
      <h1>Add Your Today's Expense</h1>

      <!-- Amount Input -->
      <div class="input-box">
        <input type="number" name="expense_amount" placeholder="Enter amount" required>
      </div>

      <!-- Date Input -->
      <div class="input-box">
        <input type="date" id="date" name="expense_date" required>
      </div>

      <!-- Category Dropdown -->
      <div class="input-box">
  <select name="expense_category" required>
    <option value="">-- Select Category --</option>
    <?php while($row = mysqli_fetch_assoc($categoryResult)): ?>
      <option value="<?= $row['category_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
    <?php endwhile; ?>
  </select>
</div>


      <!-- Submit -->
      <button type="submit" name="submit" class="btn-1">Add</button>
    </div>
  </section>
</form>
</section>







































<?php include("./includes/footer.php") ?>
</body>
</html>