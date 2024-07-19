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
    <title>Delete Property</title>
    <link rel="stylesheet" href="../assets/css/myStyles.css">
</head>
<body>
    <div class="container">
        <h1>Delete Property</h1>
        <form action="/projectRealEstate/dao/propertyDao.php" method="post">
            <input type="hidden" name="action" value="deleteProperty">
            <label for="property_id">Property ID:</label>
            <input type="text" id="property_id" name="property_id" required>
            <input type="submit" value="Delete Property">
        </form>
    </div>
</body>
</html>