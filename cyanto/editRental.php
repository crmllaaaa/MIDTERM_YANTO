<?php

require_once 'core/models.php';
session_start();

if (isset($_GET['id'])) {
    $rental_id = $_GET['id'];
    $rental = getRentalById($rental_id);
    if (!$rental) {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

if (isset($_POST['updateRentalBtn'])) {
    $status = $_POST['status'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $user_id = $_SESSION['user_id'];  // Ensure session is started and contains `user_id`

    // Update using models.php function
    updateRental($rental_id, $rental['customer_id'], $rental['car_id'], $status, $start_date, $end_date);

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Rental</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Rental</h1>
    <form action="editRental.php?id=<?php echo $rental['rental_id']; ?>" method="POST">
        <select name="status" required>
            <option value="active" <?php echo $rental['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="completed" <?php echo $rental['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
            <option value="cancelled" <?php echo $rental['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
        </select>
        <input type="date" name="start_date" value="<?php echo htmlspecialchars($rental['start_date']); ?>" required>
        <input type="date" name="end_date" value="<?php echo htmlspecialchars($rental['end_date']); ?>" required>
        <button type="submit" name="updateRentalBtn">Update Rental</button>
    </form>
</body>
</html>
