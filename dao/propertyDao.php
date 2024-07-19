<?php
// Create a new property

include_once("databaseConnect/dbConnect.php");
include_once("sellerDao.php");
include_once("listingDao.php");

if(isset($_POST['action'])){
    if($_POST['action'] == "createProperty"){
        $address = sanitizeInput($_POST['address']);
        $city = sanitizeInput($_POST['city']);
        $state = sanitizeInput($_POST['state']);
        $zip_code = sanitizeInput($_POST['zip_code']);
        $property_type = sanitizeInput($_POST['property_type']);
        $price = floatval($_POST['price']);
        $bedrooms = intval($_POST['bedrooms']);
        $bathrooms = intval($_POST['bathrooms']);
        $square_footage = intval($_POST['square_footage']);
        $description = sanitizeInput($_POST['description']);
        $seller_email = sanitizeInput($_POST['seller_email']);
        $list_date = sanitizeInput($_POST['list_date']);
        $status = sanitizeInput($_POST['status']);
        
        $seller = getSellerByEmail($seller_email);
        if($seller){
            $seller_id = $seller['seller_id'];
            $result = createProperty($address, $city, $state, $zip_code, $property_type, $price, $bedrooms, $bathrooms, $square_footage, $description, $seller_id);
        }
        else{
            $result = false;
            echo "The seller doesn't exist <br>";
            echo "<a href='/projectRealEstate/manager/createSeller.php'>Go to create seller first</a><br>";
        }

    
        if ($result) {
            $list_result = createListing($result, null, $list_date, $status);

            echo "Property created successfully with ID: " . $result . "<br>";
            echo "List created successfully with ID: " . $result . "<br>"; 
            echo "<a href='/projectRealEstate/manager/admin-manager.html'>Comeback to manager</a><br>";
        } else {
            echo "Failed to create property. Please check the input values.";
        } 
    }

    if($_POST['action'] == "deleteProperty"){
        $property_id = sanitizeInput($_POST['property_id']);
        
        // Validate input
        if (empty($property_id) || !filter_var($property_id, FILTER_VALIDATE_INT)) {
            echo "Invalid property ID.";
            exit;
        }
        
        // Delete the property
        $result = deleteProperty($property_id);
        
        if ($result) {
            echo "Property deleted successfully.";
        } else {
            echo "Failed to delete property.";
        }
    }
}



function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function createProperty($address, $city, $state, $zip_code, $property_type, $price, $bedrooms, $bathrooms, $square_footage, $description, $seller_id) {
    global $conn;

    // Validate positive numerical inputs
    if ($price <= 0 || $bedrooms < 0 || $bathrooms < 0 || $square_footage < 0) {
        return false; // Invalid input
    }

    // Check if property_type is valid
    $valid_property_types = ['house', 'apartment', 'land', 'commercial'];
    if (!in_array($property_type, $valid_property_types)) {
        return false; // Invalid property type
    }

    $stmt = $conn->prepare("INSERT INTO Property (address, city, state, zip_code, property_type, price, bedrooms, bathrooms, square_footage, description, seller_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssdiiisi", $address, $city, $state, $zip_code, $property_type, $price, $bedrooms, $bathrooms, $square_footage, $description, $seller_id);
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        return false;
    }
    $stmt->close();
}

// Read a property by ID
function getPropertyById($property_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Property 
            LEFT JOIN Listing 
            ON Listing.property_id = Property.property_id
            INNER JOIN Seller
            ON Seller.seller_id = Property.seller_id
            WHERE Property.property_id = ? ");
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc(); // Fetch a single row as an associative array
    $stmt->close();
    return $property;
}


// Get the most recent list property 
function getPropertyByRecent($limit) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Property 
            INNER JOIN Listing 
            ON Listing.property_id = Property.property_id
            ORDER BY list_date DESC
            LIMIT ?");
    $stmt->bind_param("i", $limit); // Bind the limit parameter
    $stmt->execute();
    $result = $stmt->get_result();
    $properties = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $properties;
}

// Get the most recent list property 
function getPropertyByRecentOffset($limit, $offset) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Property 
            INNER JOIN Listing 
            ON Listing.property_id = Property.property_id
            ORDER BY list_date DESC
            LIMIT ?,?");
    $stmt->bind_param("ii", $limit, $offset); // Bind the limit parameter
    $stmt->execute();
    $result = $stmt->get_result();
    $properties = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $properties;
}

function getPropertyByRecentOffsetByStatus($limit, $offset, $status) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Property 
            INNER JOIN Listing 
            ON Listing.property_id = Property.property_id
            WHERE status = ?
            ORDER BY list_date DESC
            LIMIT ?,?");
    $stmt->bind_param("sii",$status, $limit, $offset); // Bind the limit parameter
    $stmt->execute();
    $result = $stmt->get_result();
    $properties = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $properties;
}


// Read a property 
function getProperty() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Property");
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc();
    $stmt->close();
    return $property;
}
// Update a property by ID
function updateProperty($property_id, $address, $city, $state, $zip_code, $property_type, $price, $bedrooms, $bathrooms, $square_footage, $description, $seller_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE Property SET address = ?, city = ?, state = ?, zip_code = ?, property_type = ?, price = ?, bedrooms = ?, bathrooms = ?, square_footage = ?, description = ?, seller_id = ? WHERE property_id = ?");
    $stmt->bind_param("sssssdiiisii", $address, $city, $state, $zip_code, $property_type, $price, $bedrooms, $bathrooms, $square_footage, $description, $seller_id, $property_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}

// Delete a property by ID
function deleteProperty($property_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM Property WHERE property_id = ?");
    $stmt->bind_param("i", $property_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}
?>
