<?php

require_once 'core/models.php';

if (isset($_GET['id'])) {
    $car_id = $_GET['id'];
    $car = getCarById($car_id);  // Fetch car details by ID
} else {
    // If no ID is passed, redirect to the main page
    header("Location: index.php");
    exit;
}

if (isset($_POST['updateCarBtn'])) {
    $car_id = $_POST['car_id'];
    $model = $_POST['model'];
    $plate_number = $_POST['plate_number'];
    $color = $_POST['color'];
    $status = $_POST['status'];
    $price_per_day = $_POST['price_per_day'];
    $user_id = $_SESSION['user_id'];  // Get the user ID from session

    // Use the updateCar function to update the car
    updateCar($car_id, $model, $plate_number, $color, $status, $price_per_day);

    header("Location: index.php");  // Redirect to the index page after update
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Car</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Car</h1>
    <form action="editCar.php?id=<?php echo $car['car_id']; ?>" method="POST">
        <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">  <!-- Add hidden car_id field -->
        <input type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required>
        <input type="text" name="plate_number" value="<?php echo htmlspecialchars($car['plate_number']); ?>" required>
        <input type="text" name="color" value="<?php echo htmlspecialchars($car['color']); ?>" required>
        <select name="status" required>
            <option value="available" <?php echo $car['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
            <option value="rented" <?php echo $car['status'] == 'rented' ? 'selected' : ''; ?>>Rented</option>
            <option value="maintenance" <?php echo $car['status'] == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
        </select>
        <input type="number" name="price_per_day" value="<?php echo htmlspecialchars($car['price_per_day']); ?>" required>
        <button type="submit" name="updateCarBtn">Update Car</button>
    </form>
</body>
</html>
