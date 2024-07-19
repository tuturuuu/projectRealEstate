<?php
session_start();


include_once("databaseConnect/dbConnect.php");
// Register a new admin
if(isset($_POST["action"])){

    if($_POST["action"] == "authenticate"){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $auth = authenticateAdmin($username, $password);
        if($auth) {
            header('Location: /projectRealEstate/manager/admin-manager.html'); // Adjust the path as necessary
            exit();
        } else {
            print("Authentication failed");
        }
    }

}

// Declare $conn as a global variable in each function

function registerAdmin($username, $password) {
    global $conn; // Use the global $conn variable
    
    // Check if username already exists
    $stmt = $conn->prepare("SELECT admin_id FROM Admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        return false; // Username already exists
    }
    $stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new admin
    $stmt = $conn->prepare("INSERT INTO Admin (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        return false;
    }
    $stmt->close();
}

// Authenticate an admin using mysqli_fetch_assoc
function authenticateAdmin($username, $password) {
    global $conn; // Use the global $conn variable
    
    // Retrieve the hashed password from the database
    $stmt = $conn->prepare("SELECT admin_id, password FROM Admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();

    if ($admin) {
        if (password_verify($password, $admin['password'])) {
            // Store admin ID in session
            $_SESSION['admin_id'] = $admin['admin_id'];
            return true; // Authentication successful
        } else {
            return false; // Password is incorrect
        }
    } else {
        return false; // Username not found
    }
}

// Change an admin's password
function changeAdminPassword($admin_id, $new_password) {
    global $conn; // Use the global $conn variable
    
    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE Admin SET password = ? WHERE admin_id = ?");
    $stmt->bind_param("si", $hashed_password, $admin_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}
?>
