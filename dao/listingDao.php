<?php

include_once("databaseConnect/dbConnect.php");

// Create a new listing
function createListing($property_id, $customer_id, $list_date, $status) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Listing (property_id, customer_id, list_date, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $property_id, $customer_id, $list_date, $status);
    if ($stmt->execute()) {
        return $stmt->insert_id;
    } else {
        return false;
    }
    $stmt->close();
}

// Read a listing by ID
function getListingById($listing_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Listing WHERE listing_id = ?");
    $stmt->bind_param("i", $listing_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $listing = $result->fetch_assoc();
    $stmt->close();
    return $listing;
}

// Update a listing
function updateListing($listing_id, $property_id, $customer_id, $list_date, $status) {
    global $conn;
    $stmt = $conn->prepare("UPDATE Listing SET property_id = ?, customer_id = ?, list_date = ?, status = ? WHERE listing_id = ?");
    $stmt->bind_param("iissi", $property_id, $customer_id, $list_date, $status, $listing_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}

// Delete a listing
function deleteListing($listing_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM Listing WHERE listing_id = ?");
    $stmt->bind_param("i", $listing_id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
    $stmt->close();
}

// Retrieve all listings
function getAllListings() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM Listing");
    $stmt->execute();
    $result = $stmt->get_result();
    $listings = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $listings;
}
?>
