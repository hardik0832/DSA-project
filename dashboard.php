<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Pizza Management System</title>
</head>
<body>
  <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>
  <!-- Your pizza website content goes here -->
</body>
</html>
