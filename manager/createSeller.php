<?php
session_start(); // Start the session

// Check if the admin is authenticated
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the authentication page or show an error message
    header('Location: authenticate.php'); // Adjust the path as necessary
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Seller</title>
    <link rel="stylesheet" href="../assets/css/myStyles.css">
</head>
<body>
    <div class="container">
        <h1>Create New Seller</h1>
        <form action="/projectRealEstate/dao/sellerDao.php" method="POST">
            
            <input type="hidden" id="action" name="action" value="createSeller" >

            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" id="phone_number" name="phone_number">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="license_number">License Number:</label>
                <input type="text" id="license_number" name="license_number">
            </div>
            <button type="submit" class="btn-submit">Create Seller</button>
        </form>
    </div>
</body>
</html>
