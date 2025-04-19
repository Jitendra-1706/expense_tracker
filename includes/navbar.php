<nav class="navbar navbar-expand-lg bg-transparent custom-navbar">
  <div class="container-fluid">
    <a class="navbar-brand text-white " href="#">Expense</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Expense Options
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item text-white" href="./add_expense.php">Add Expense</a></li>
            <li><a class="dropdown-item text-white" href="delete_expense.php">Delete Expense</a></li>
            <li><a class="dropdown-item text-white" href="view_expense.php">View Expense</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex" role="search" action="logout.php" method="POST">
        <button class="btn btn-outline-light" type="submit">Logout</button>
      </form>
    </div>
  </div>
</nav>
