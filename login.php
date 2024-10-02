<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: index.php");
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Login Form</title>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            require_once 'database.php';

            // Sanitize email input to prevent SQL injection
            $email = mysqli_real_escape_string($conn, $email);

            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // Use a more secure method to handle redirection
                    session_start();
                    $_SESSION["user"]= "yes ";
                    header("Location: index.php");
                    exit();
                } else {
                    echo '<div class="alert alert-danger">Password is incorrect.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Email does not exist.</div>';
            }
        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group mb-3">
                <input type="email" name="email" placeholder="Enter email" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <input type="password" name="password" placeholder="Enter password" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div>
            <p>Not registered  yet <a href="registration.php">Register  here </a></p>
        </div>
    </div>
</body>
</html>
