<?php
session_start(); // Start the session

// Check if the admin is authenticated
if (isset($_SESSION['admin_id'])) {
    // Redirect to the authentication page or show an error message
    header('Location: admin-manager.html'); // Adjust the path as necessary
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/myStyles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="/projectRealEstate/dao/adminDao.php" method="POST">
            <input type="hidden" id="action" name="action" value="authenticate" >

            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
