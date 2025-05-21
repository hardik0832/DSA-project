<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Dummy credentials (you can later link with database)
$validUser = "admin";
$validPass = "1234";

if ($username === $validUser && $password === $validPass) {
    $_SESSION['user'] = $username;
    header("Location: index.php"); // this is your main pizza website
    exit();
} else {
    echo "<script>alert('Invalid username or password!'); window.location.href='login.php';</script>";
}
?>
