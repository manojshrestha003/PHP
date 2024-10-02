<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel = "stylesheet" href= "style.css">
</head>
<body>
    <div class="container">
    <?php
if (isset($_POST['submit'])) {
    // Corrected the variable name to match the form field names
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPass = $_POST['repeat-pass'];
    $error = array(); // Correct variable name for error storage
    $password_hash = password_hash($password,PASSWORD_DEFAULT);

    
    // Validation
    if (empty($fullName) || empty($email) || empty($password) || empty($repeatPass)) {
        array_push($error, "All fields are required.");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($error, "Email is not valid.");
    }
    
    if (strlen($password) < 8) {
        array_push($error, "Password must be at least eight characters long.");
    }
    
    if ($password !== $repeatPass) {
        array_push($error, "Passwords do not match.");
    }
    require_once "database.php";
    $sql  = "SELECT * FROM user WHERE email = '$email'";
     $result = mysqli_query($conn , $sql);
     $rowCount = mysqli_num_rows($result);
     if($rowCount>0){
        array_push($error, "Email already  exists ");
     }
    
    // Display errors
    if (count($error) > 0) {
        foreach ($error as $err) {
            // Corrected HTML and PHP syntax
            echo "<div class='alert alert-danger'>$err</div>";
        }
    }
    else{
        

        $sql  = "INSERT INTO user(full_name, email, password) VALUES (?,?,?)";
         $stmt = mysqli_stmt_init($conn);
        $prepareStmt =  mysqli_stmt_prepare($stmt, $sql);
        if($prepareStmt){
            mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $password_hash);
            mysqli_stmt_execute($stmt);
            echo "<div class = 'alert alert-success'>User  registered successfully </div>";
        }
        else {
            die("something went wrong ");
        }

    }
}
?>

        <form action="registration.php" method="post">
            <div class="form-group">
                
                <input type="text" class = "form-control" id="fullName" name="fullName" placeholder="Enter full name " >
            </div>
            <div class="form-group">

                <input type="email"class = "form-control" id="email" name="email" placeholder="Email address" >
            </div>
            <div class="form-group">
                <input type="password" class = "form-control" id="password" name="password" placeholder="Password" >
            </div>
            <div class="form-group">
                <input type="password" class = "form-control" id="repeat-pass" name="repeat-pass" placeholder="Repeat password" >
            </div>
            <div class="form-group">
                <input type="submit"  class = "btn btn-primary" name="submit" value="Register">
            </div>
        </form>
        <div>
            <p>Already registered <a href="login.php">Login here  </a></p>
        </div>
    </div>
</body>
</html>
