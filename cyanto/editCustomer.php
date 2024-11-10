<?php
require_once 'core/models.php';
session_start();  // Make sure session is started

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    $customer = getCustomerById($customer_id);  // Fetch customer details by ID
} else {
    // If no ID is passed, redirect to the main page
    header("Location: index.php");
    exit;
}

if (isset($_POST['updateCustomerBtn'])) {
    $customer_id = $_POST['customer_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $license_number = $_POST['license_number'];
    $user_id = $user_id['user_id'];  // Get the user ID from session

    // Call the updateCustomer function to handle the update query
    updateCustomer($customer_id, $first_name, $last_name, $email, $phone, $license_number);

    header("Location: index.php");  // Redirect after update
    exit;  // Always use exit() after header redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Customer</h1>
    <form action="editCustomer.php?id=<?php echo $customer['customer_id']; ?>" method="POST">
        <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>"> <!-- Ensure customer_id is passed in form -->
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($customer['first_name']); ?>" required>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($customer['last_name']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" required>
        <input type="text" name="license_number" value="<?php echo htmlspecialchars($customer['license_number']); ?>" required>
        <button type="submit" name="updateCustomerBtn">Update Customer</button>
    </form>
</body>
</html>
