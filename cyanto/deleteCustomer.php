<?php

require_once 'core/models.php';


if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    deleteCustomer($customer_id);  // Delete the customer by ID
    header("Location: index.php");  // Redirect back to the main page after deletion
    exit;
} else {
    // If no ID is passed, redirect to the main page
    header("Location: index.php");
    exit;
}
?>