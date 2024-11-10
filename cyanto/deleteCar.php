<?php

require_once 'core/models.php';

if (isset($_GET['id'])) {
    $car_id = $_GET['id'];
    deleteCar($car_id);  // Delete the car from the DB
    header("Location: index.php");  // Redirect back to the main page after deletion
    exit;
} else {
    // If no ID is passed, redirect to the main page
    header("Location: index.php");
    exit;
}
?>