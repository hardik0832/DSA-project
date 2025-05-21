<?php
session_start();

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$dbname = "pizza_db";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ''; // Error message for login failure

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION["username"] = $user['username'];
                header("Location: index.php?message=Welcome, " . urlencode($user['username']) . "!");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
        $stmt->close();
    } else {
        $error = "Please enter both username and password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pizza Palace Login</title>
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

        .login-box img {
            width: 40px;
        }

        .login-box h2 {
            color: orange;
            margin: 10px 0 5px;
        }

        .login-box p {
            font-size: 20px;
            font-weight: bold;
            color: orange;
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="password"] {
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

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <img src="https://cdn-icons-png.flaticon.com/512/3595/3595455.png" alt="Pizza">
        <h2>Pizza Palace</h2>
        <p>Login</p>

        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>

        <br>
        <a href="register.php">New user? Create an account</a>
    </div>
</body>
</html>
