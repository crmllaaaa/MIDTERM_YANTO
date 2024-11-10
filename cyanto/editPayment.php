<?php
require_once 'core/models.php';
session_start();

if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];
    $payment = getPaymentById($payment_id);  // Fetch payment details by ID
    if (!$payment) {
        header("Location: index.php");  // Redirect if payment doesn't exist
        exit;
    }
} else {
    header("Location: index.php");  // Redirect if no ID is passed
    exit;
}

if (isset($_POST['updatePaymentBtn'])) {
    $payment_id = $_POST['payment_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $payment_method = $_POST['payment_method'];  // Assuming form input for method
    $user_id = $_SESSION['user_id'];

    // Call the function from models.php to update
    updatePayment($payment_id, $payment['rental_id'], $payment_date, $amount, $payment_method);

    header("Location: index.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Payment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Payment</h1>

    <!-- Edit Payment Form -->
    <form action="editPayment.php?id=<?php echo $payment['payment_id']; ?>" method="POST">
    <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment['payment_id']); ?>">
    <label>Amount:</label>
    <input type="number" name="amount" value="<?php echo htmlspecialchars($payment['amount']); ?>" required>
    <label>Payment Date:</label>
    <input type="date" name="payment_date" value="<?php echo htmlspecialchars($payment['payment_date']); ?>" required>
    <label>Payment Method:</label>
    <input type="text" name="payment_method" value="<?php echo htmlspecialchars($payment['payment_method']); ?>" required>
    <button type="submit" name="updatePaymentBtn">Update Payment</button>
</form>
</body>
</html>