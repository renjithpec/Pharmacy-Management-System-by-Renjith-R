<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

require_once "includes/db_connect.php";
$username = $password = $role = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $role = trim($_POST["role"]);

    $sql = "SELECT user_id, username, password, role FROM users WHERE username = ? AND password = ? AND role = ?";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $role);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $username_db, $password_db, $user_role);
                if(mysqli_stmt_fetch($stmt)){
                    $_SESSION["loggedin"] = true;
                    $_SESSION["user_id"] = $id;
                    $_SESSION["username"] = $username;
                    $_SESSION["role"] = $user_role;
                    header("location: dashboard.php");
                    exit(); // Crucial to stop script execution here
                }
            } else { $error_message = "Invalid username, password, or role."; }
        } else{ echo "Oops! Something went wrong."; }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pharmacy Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>
<body class="login-body">
    <div id="preloader">
        <lottie-player src="assets/animations/health.json" background="transparent" speed="2550" style="width: 300px; height: 300px;" loop autoplay></lottie-player>
    </div>

    <div class="login-wrapper">
        <div class="login-brand">
            <i class="fa-solid fa-pills"></i>
            <h1>Go-Pharma</h1>
            <p>Your Health, Our Priority.</p>
        </div>
        <div class="login-form-section">
            <div class="login-container">
                <h2>Welcome Back!</h2>
                <p>Please sign in to your account.</p>
                <?php if(!empty($error_message)){ echo '<div class="error-message">' . $error_message . '</div>'; } ?>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label>Login As:</label>
                        <select name="role" class="form-control" required><option value="Admin">Administrator</option><option value="Pharmacist">Staff (Pharmacist)</option></select>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Start a 2-second timer as soon as this script runs
        setTimeout(function() {
            document.getElementById('preloader').style.display = 'none';
        }, 2000); // 2000 milliseconds = 2 seconds
    </script>
</body>
</html>