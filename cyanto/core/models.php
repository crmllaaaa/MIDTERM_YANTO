<?php

require_once 'dbConfig.php';

// Fetch All Customers
function getAllCustomers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM customers");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch Customer by ID
function getCustomerById($customer_id) {
    global $pdo;

    // Updated query to join users table and get added_by and last_updated_by user names
    $sql = "SELECT c.*, u1.first_name AS added_by_first_name, u1.last_name AS added_by_last_name,
                   u2.first_name AS last_updated_by_first_name, u2.last_name AS last_updated_by_last_name
            FROM customers c
            LEFT JOIN users u1 ON c.added_by = u1.user_id
            LEFT JOIN users u2 ON c.last_updated_by = u2.user_id
            WHERE c.customer_id = :customer_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);  // Returns customer details including the user names
}

// Fetch All Cars
function getAllCars() {
    global $pdo;
    $sql = "SELECT c.*, u1.first_name AS added_by_first_name, u1.last_name AS added_by_last_name,
                   u2.first_name AS last_updated_by_first_name, u2.last_name AS last_updated_by_last_name
            FROM cars c
            LEFT JOIN users u1 ON c.added_by = u1.user_id
            LEFT JOIN users u2 ON c.last_updated_by = u2.user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return all cars as an associative array
}
// Fetch Car by ID
function getCarById($car_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM cars WHERE car_id = :car_id");
    $stmt->bindParam(':car_id', $car_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);  
}

// Fetch All Rentals
function getAllRentals() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM rentals");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch Rental by ID
function getRentalById($rental_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM rentals WHERE rental_id = :rental_id");
    $stmt->bindParam(':rental_id', $rental_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);  
}

// Function to get rentals by customer ID
function getRentalsByCustomer($pdo, $customer_id) {
    // Prepare a SQL query to fetch rentals based on customer ID
    $stmt = $pdo->prepare("SELECT * FROM rentals WHERE customer_id = :customer_id");
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Return the results as an associative array
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch All Payments
function getAllPayments() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM payments");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch Payment by ID
function getPaymentById($payment_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE payment_id = :payment_id");
    $stmt->bindParam(':payment_id', $payment_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);  
}

//  Insert New Customer
function insertCustomer($first_name, $last_name, $email, $phone, $license_number) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, email, phone, license_number) 
                           VALUES (:first_name, :last_name, :email, :phone, :license_number)");
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':license_number', $license_number);
    $stmt->execute();
    return $pdo->lastInsertId();  
}

//  Insert New Car
function insertCar($model, $plate_number, $color, $status, $price_per_day) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO cars (model, plate_number, color, status, price_per_day) 
                           VALUES (:model, :plate_number, :color, :status, :price_per_day)");
    $stmt->bindParam(':model', $model);
    $stmt->bindParam(':plate_number', $plate_number);
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':price_per_day', $price_per_day);
    $stmt->execute();
    return $pdo->lastInsertId();  
}

//  Insert New Rental
function insertRental($customer_id, $car_id, $status, $start_date, $end_date) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO rentals (customer_id, car_id, status, start_date, end_date) 
                           VALUES (:customer_id, :car_id, :status, :start_date, :end_date)");
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':car_id', $car_id);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->execute();
    return $pdo->lastInsertId();  
}

//  Insert New Payment
function insertPayment($rental_id, $payment_date, $amount, $payment_method) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO payments (rental_id, payment_date, amount, payment_method) 
                           VALUES (:rental_id, :payment_date, :amount, :payment_method)");
    $stmt->bindParam(':rental_id', $rental_id);
    $stmt->bindParam(':payment_date', $payment_date);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':payment_method', $payment_method);
    $stmt->execute();
    return $pdo->lastInsertId();  
}

//  Update Customer
function updateCustomer($customer_id, $first_name, $last_name, $email, $phone, $license_number) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE customers SET first_name = :first_name, last_name = :last_name, 
                           email = :email, phone = :phone, license_number = :license_number 
                           WHERE customer_id = :customer_id");
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':license_number', $license_number);
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->execute();
}

//  Update Car
function updateCar($car_id, $model, $plate_number, $color, $status, $price_per_day) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE cars SET model = :model, plate_number = :plate_number, color = :color, 
                           status = :status, price_per_day = :price_per_day WHERE car_id = :car_id");
    $stmt->bindParam(':model', $model);
    $stmt->bindParam(':plate_number', $plate_number);
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':price_per_day', $price_per_day);
    $stmt->bindParam(':car_id', $car_id);
    $stmt->execute();
}

//  Update Rental
function updateRental($rental_id, $customer_id, $car_id, $status, $start_date, $end_date) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE rentals SET customer_id = :customer_id, car_id = :car_id, 
                           status = :status, start_date = :start_date, end_date = :end_date 
                           WHERE rental_id = :rental_id");
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':car_id', $car_id);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':rental_id', $rental_id);
    
    if ($stmt->execute()) {
        echo "Update successful";
    } else {
        echo "Update failed: ";
        print_r($stmt->errorInfo());
    }
}


//  Update Payment
function updatePayment($payment_id, $rental_id, $payment_date, $amount, $payment_method) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE payments SET rental_id = :rental_id, payment_date = :payment_date, 
                           amount = :amount, payment_method = :payment_method, last_updated_by = :user_id,
                           last_updated = CURRENT_TIMESTAMP WHERE payment_id = :payment_id");
    $stmt->bindParam(':rental_id', $rental_id);
    $stmt->bindParam(':payment_date', $payment_date);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':payment_method', $payment_method);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->bindParam(':payment_id', $payment_id);
    $stmt->execute();
}

//  Delete Customer
function deleteCustomer($customer_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM customers WHERE customer_id = :customer_id");
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->execute();
}

//  Delete Car
function deleteCar($car_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM cars WHERE car_id = :car_id");
    $stmt->bindParam(':car_id', $car_id);
    $stmt->execute();
}

//  Delete Rental
function deleteRental($rental_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM rentals WHERE rental_id = :rental_id");
    $stmt->bindParam(':rental_id', $rental_id);
    $stmt->execute();
}

//  Delete Payment
function deletePayment($payment_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM payments WHERE payment_id = :payment_id");
    $stmt->bindParam(':payment_id', $payment_id);
    $stmt->execute();
}

// Fetch all information by Web Developer ID
function getAllInfoByWebDevID($web_dev_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM web_devs WHERE web_dev_id = :web_dev_id");
    $stmt->bindParam(':web_dev_id', $web_dev_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC); 
}

// Fetch all projects by Web Developer ID
function getProjectsByWebDev($pdo, $web_dev_id) {
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE web_dev_id = :web_dev_id");
    $stmt->bindParam(':web_dev_id', $web_dev_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

?>