<?php

require_once 'core/models.php';
require_once 'core/dbConfig.php';  


if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];
    $customer = getCustomerById($customer_id);
    $rentals = getRentalsByCustomer($pdo, $customer_id);
} else {
    echo "Customer ID is required!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer Rentals - CY's Car Rental System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Navigation -->
        <nav>
            <a href="index.php" class="btn">Return to Home</a>
            <a href="addCustomer.php" class="btn">Add New Customer</a>
        </nav>

        <!-- Display Customer Info -->
        <h1>Customer Information</h1>
        <?php
        if ($customer) {
            echo "<h2>Customer: {$customer['first_name']} {$customer['last_name']}</h2>";
            echo "<p>Email: {$customer['email']}</p>";
            echo "<p>Phone: {$customer['phone']}</p>";
            echo "<p>License Number: {$customer['license_number']}</p>";
        } else {
            echo "<p>Customer not found.</p>";
        }
        ?>

        <!-- Add a Rental Form -->
        <h2>Add a New Rental</h2>
        <form action="core/handleForms.php" method="POST">
            <p>
                <label for="car_id">Car Model:</label>
                <select name="car_id" required>
                    <?php
                    $cars = getAllCars();
                    foreach ($cars as $car) {
                        echo "<option value=\"{$car['car_id']}\">{$car['model']} - {$car['plate_number']}</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="status">Rental Status:</label>
                <input type="text" name="status" placeholder="Enter Rental Status (e.g., active)" required>
            </p>
            <p>
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" required>
            </p>
            <p>
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" required>
            </p>
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
            <button type="submit" name="insertRentalBtn" class="btn">Add Rental</button>
        </form>

        <!-- Existing Rentals Table -->
        <h2>Existing Rentals</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Rental ID</th>
                    <th>Car Model</th>
                    <th>Rental Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($rentals) {
                    foreach ($rentals as $rental) {
                        // Fetch car details for each rental
                        $car = getCarById($rental['car_id']);
                        echo "<tr>";
                        echo "<td>{$rental['rental_id']}</td>";
                        echo "<td>{$car['model']} - {$car['plate_number']}</td>";
                        echo "<td>{$rental['status']}</td>";
                        echo "<td>{$rental['start_date']}</td>";
                        echo "<td>{$rental['end_date']}</td>";
                        echo "<td>
                                <a href=\"editRental.php?rental_id={$rental['rental_id']}&customer_id={$customer_id}\" class=\"btn-edit\">Edit</a>
                                <a href=\"deleteRental.php?rental_id={$rental['rental_id']}&customer_id={$customer_id}\" class=\"btn-delete\">Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan=\"6\">No rentals found for this customer.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>