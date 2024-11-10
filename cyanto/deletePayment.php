<?php

require_once 'core/models.php';


if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];
    deletePayment($payment_id);  // Delete the payment from the DB
    header("Location: index.php");  // Redirect back to the main page after deletion
    exit;
} else {
    // If no ID is passed, redirect to the main page
    header("Location: index.php");
    exit;
}
?>