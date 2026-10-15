<?php

require_once "db.php";
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $HashedPassword = password_hash($password, PASSWORD_DEFAULT);




    $sql = "INSERT INTO users (name, email, password, created_at)
        VALUES (?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);
    if ($stmt->execute() === TRUE) {
       
            header("location:Home.php");

    } 
    else {
            

    }
}





?>














<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h2>Create Account</h2>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name"
                    placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                    placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                    placeholder="Create a password" required>
            </div>

            <button type="submit">Register</button>
        </form>

        <p class="link">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>
    </div>

</body>

</html>