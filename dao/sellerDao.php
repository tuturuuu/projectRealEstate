<?php

include_once("databaseConnect/dbConnect.php");


function sanitizeInputs($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function createSeller($first_name, $last_name, $phone_number, $email, $license_number) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO Seller (first_name, last_name, phone_number, email, license_number) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $phone_number, $email, $license_number);
    
    if ($stmt->execute()) {
        return $stmt->insert_id; // Return the ID of the newly inserted record
    } else {
        return false;
    }
    
    $stmt->close();
}


function getSellerByEmail($seller_email) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM Seller WHERE email = ?");
    $stmt->bind_param("s", $seller_email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $seller = $result->fetch_assoc();
    
    $stmt->close();
    return $seller;
}

function updateSeller($seller_id, $first_name, $last_name, $phone_number, $email, $license_number) {
    global $conn;

    $stmt = $conn->prepare("UPDATE Seller SET first_name = ?, last_name = ?, phone_number = ?, email = ?, license_number = ? WHERE seller_id = ?");
    $stmt->bind_param("sssssi", $first_name, $last_name, $phone_number, $email, $license_number, $seller_id);
    
    if ($stmt->execute()) {
        return true; // Update successful
    } else {
        return false;
    }
    
    $stmt->close();
}

function deleteSeller($seller_id) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM Seller WHERE seller_id = ?");
    $stmt->bind_param("i", $seller_id);
    
    if ($stmt->execute()) {
        return true; // Delete successful
    } else {
        return false;
    }
    
    $stmt->close();
}


if(isset($_POST['action'])){
    if ($_POST['action'] == "createSeller") {
        // Sanitize inputs
        $first_name = sanitizeInputs($_POST['first_name']);
        $last_name = sanitizeInputs($_POST['last_name']);
        $phone_number = sanitizeInputs($_POST['phone_number']);
        $email = sanitizeInputs($_POST['email']);
        $license_number = sanitizeInputs($_POST['license_number']);
        
        // Validate inputs
        if (empty($first_name) || empty($last_name) || empty($email)) {
            echo "First name, last name, and email are required.";
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
            exit;
        }
        
        // Create the seller
        $result = createSeller($first_name, $last_name, $phone_number, $email, $license_number);
        
        if ($result) {
            echo "Seller created successfully.";
            echo "<a href='/projectRealEstate/manager/admin-manager.html'>Comeback to manager</a><br>";
        } else {
            echo "Failed to create seller.";
        }
}
}
?>

