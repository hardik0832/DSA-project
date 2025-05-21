<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "pizza_db";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $age = $_POST['age'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, dob, age, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssds", $username, $email, $dob, $age, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>
                alert('Registration successful!');
                window.location.href = 'login.php';
            </script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Pizza Palace</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Fredoka', sans-serif;
      background: url("assets/img/popular-1.png") no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0px 10px 20px rgba(0,0,0,0.2);
      text-align: center;
      width: 300px;
    }

    h2 {
      color: orange;
      margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="date"],
    input[type="number"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 2px solid orange;
      border-radius: 5px;
      font-size: 16px;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background-color: orange;
      color: white;
      font-weight: bold;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }

    .login-box button:hover {
      background-color: #ff6600;
    }

    .login-box a {
      font-size: 14px;
      color: blue;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Create Account</h2>
    <form method="POST" action="register.php">
      <input type="text" name="username" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email ID" required>
      <input type="date" name="dob" required>
      <input type="number" name="age" placeholder="Age" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <button type="submit" name="register">Register</button>
    </form>
    <br>
    <a href="login.php">Already have an account? Login</a>
  </div>
</body>
</html>
