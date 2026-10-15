

<?php 



require_once "db.php";
session_start();




if ($_SERVER["REQUEST_METHOD"] == "POST") {

   
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT  email, password FROM users WHERE email = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();

        $result = $stmt->get_result();

        $user  = ($result->fetch_assoc());

        if ($user!=$_SESSION[""]) {
    
        
          if ($user["email"] ===$email && $user["password"] ==$password ){


                header("location:Home.php");

        }



        }

      



}


?>











<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>Welcome Back</h2>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                       placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       placeholder="Enter your password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <p class="link">
            Don't have an account?
            <a href="Register.php">Register here</a>
        </p>
    </div>

</body>
</html>
