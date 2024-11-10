<?php

require_once 'core/dbConfig.php';

// Handle the insertion of customers
if (isset($_POST['insertCustomer'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $license_number = $_POST['license_number'];

    $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, email, phone, license_number) 
                            VALUES (:first_name, :last_name, :email, :phone, :license_number)");

    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':license_number', $license_number);

    $stmt->execute();

    // Redirect to the index page after insertion
    header("Location: index.php");
    exit();
}

// Handle the insertion of cars
if (isset($_POST['insertCar'])) {
    $model = $_POST['model'];
    $plate_number = $_POST['plate_number'];
    $color = $_POST['color'];
    $status = $_POST['status'];
    $price_per_day = $_POST['price_per_day'];

    // Validation (example: check if price per day is numeric)
    if (!is_numeric($price_per_day)) {
        // You can handle the error here, like displaying an error message
        echo "Price per day must be a valid number.";
        exit;
    }

    // Get the logged-in user ID
    $user_id = $_SESSION['user_id'];  // Assuming you have this in session

    $stmt = $pdo->prepare("INSERT INTO cars (model, plate_number, color, status, price_per_day, added_by) 
                            VALUES (:model, :plate_number, :color, :status, :price_per_day, :added_by)");

    $stmt->bindParam(':model', $model);
    $stmt->bindParam(':plate_number', $plate_number);
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':price_per_day', $price_per_day);
    $stmt->bindParam(':added_by', $user_id);

    $stmt->execute();

    // Redirect to the index page after insertion
    header("Location: index.php");
    exit();
}

// Handle the insertion of rentals
if (isset($_POST['insertRental'])) {
    $customer_id = $_POST['customer_id'];
    $car_id = $_POST['car_id'];
    $status = $_POST['status'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $stmt = $pdo->prepare("INSERT INTO rentals (customer_id, car_id, status, start_date, end_date) 
                            VALUES (:customer_id, :car_id, :status, :start_date, :end_date)");

    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':car_id', $car_id);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);

    $stmt->execute();

    // Redirect to the index page after insertion
    header("Location: index.php");
    exit();
}

// Handle the insertion of payments
if (isset($_POST['insertPayment'])) {
    $rental_id = $_POST['rental_id'];
    $payment_date = $_POST['payment_date'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    $stmt = $pdo->prepare("INSERT INTO payments (rental_id, payment_date, amount, payment_method) 
                            VALUES (:rental_id, :payment_date, :amount, :payment_method)");

    $stmt->bindParam(':rental_id', $rental_id);
    $stmt->bindParam(':payment_date', $payment_date);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':payment_method', $payment_method);

    $stmt->execute();

    // Redirect to the index page after insertion
    header("Location: index.php");
    exit();
}

if (isset($_POST['insertNewProjectBtn'])) {
    $web_dev_id = $_GET['web_dev_id'];
    $project_name = $_POST['projectName'];
    $technologies_used = $_POST['technologiesUsed'];

    $stmt = $pdo->prepare("INSERT INTO projects (web_dev_id, project_name, technologies_used) 
                           VALUES (:web_dev_id, :project_name, :technologies_used)");
    $stmt->bindParam(':web_dev_id', $web_dev_id);
    $stmt->bindParam(':project_name', $project_name);
    $stmt->bindParam(':technologies_used', $technologies_used);
    $stmt->execute();

    // Redirect after successful insertion
    header("Location: viewsproject.php?web_dev_id=$web_dev_id");
    exit;
}

if (isset($_POST['insertCustomerBtn'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $license_number = $_POST['license_number'];
    $user_id = $_SESSION['user_id'];  // Get the user ID from session
    $last_updated_by = $_SESSION['user_id'];  // Same user as last updated
    $last_updated = date('Y-m-d H:i:s');  // Current timestamp

    $sql = "INSERT INTO customers (first_name, last_name, email, phone, license_number, added_by, last_updated_by, last_updated) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$first_name, $last_name, $email, $phone, $license_number, $user_id, $last_updated_by, $last_updated]);

    header("Location: index.php");  // Redirect to index.php after insertion
    exit();
}

if (isset($_POST['insertCarBtn'])) {
    // Get the form data
    $model = $_POST['model'];
    $plate_number = $_POST['plate_number'];
    $status = $_POST['status'];
    $price_per_day = $_POST['price_per_day'];

    // Validate input fields
    if (empty($model) || empty($plate_number) || empty($status) || empty($price_per_day)) {
        // You can show an error message here if any field is empty
        echo "Please fill in all fields.";
        exit;
    }

    if (!is_numeric($price_per_day)) {
        // Validate that price_per_day is a numeric value
        echo "Price per day must be a valid number.";
        exit;
    }

    // Get the user ID from session
    $user_id = $_SESSION['user_id'];  // Assuming you're storing the user ID in the session

    // Prepare the SQL query to insert data into the cars table
    $sql = "INSERT INTO cars (model, plate_number, status, price_per_day, added_by) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Execute the query with the provided values
    $stmt->execute([$model, $plate_number, $status, $price_per_day, $user_id]);

    // Redirect to the index page after successful insertion
    header("Location: index.php");
    exit();
}

if (isset($_POST['insertRental'])) {
    $car_id = $_POST['car_id'];
    $customer_id = $_POST['customer_id'];
    $status = $_POST['status'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $user_id = $_SESSION['user_id'];  // Ensure `user_id` is in session

    $sql = "INSERT INTO rentals (car_id, customer_id, status, start_date, end_date, added_by) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$car_id, $customer_id, $status, $start_date, $end_date, $user_id]);

    header("Location: index.php");
    exit();
}


if (isset($_POST['insertPaymentBtn'])) {
    $rental_id = $_POST['rental_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $user_id = $_SESSION['user_id'];  // Get the user ID from session

    $sql = "INSERT INTO payments (rental_id, amount, payment_date, added_by) 
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$rental_id, $amount, $payment_date, $user_id]);

    header("Location: index.php");  // Redirect to index.php after insertion
    exit();
}


?>