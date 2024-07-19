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
    <title>Create New Property</title>
    <link rel="stylesheet" href="../assets/css/myStyles.css"> <!-- Optional: Link to a CSS file for styling -->
</head>
<body>
<div class="container">
<form action="/projectRealEstate/dao/propertyDao.php" method="post">
            <input type="hidden" id="action" name="action" value="createProperty">

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" pattern="^[a-zA-Z0-9\s,.'-]{3,}$" required><br><br>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" pattern="^[a-zA-Z\s]+$" required><br><br>

            <label for="state">State:</label>
            <input type="text" id="state" name="state" pattern="^[a-zA-Z\s]+$" required><br><br>

            <label for="zip_code">Zip Code:</label>
            <input type="text" id="zip_code" name="zip_code" pattern="^\d{5}(-\d{4})?$" required><br><br>

            <label for="property_type">Property Type:</label>
            <select id="property_type" name="property_type" required>
                <option value="house">House</option>
                <option value="apartment">Apartment</option>
                <option value="land">Land</option>
                <option value="commercial">Commercial</option>
            </select><br><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" min="0" placeholder="0.0$" required><br><br>

            <label for="bedrooms">Bedrooms:</label>
            <input type="number" id="bedrooms" name="bedrooms" min="0"><br><br>

            <label for="bathrooms">Bathrooms:</label>
            <input type="number" id="bathrooms" name="bathrooms" min="0"><br><br>

            <label for="square_footage">Square Footage:</label>
            <input type="number" id="square_footage" name="square_footage" min="0" placeholder="m^2"><br><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>

            <label for="seller_email">Seller Email:</label>
            <input type="email" id="seller_email" name="seller_email" required><br><br>

            <label for="list_date">Listing Date:</label>
            <input type="date" id="list_date" name="list_date" required><br><br>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="active">Active</option>
                <option value="pending">Pending</option>
                <option value="sold">Sold</option>
            </select><br><br>

            <input type="submit" value="Create Property and Listing">
        </form>
    </div>
</body>
</html>
