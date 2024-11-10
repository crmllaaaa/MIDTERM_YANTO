<?php
session_start();
require_once 'core/dbConfig.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user's details
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Fetch rentals related to the user
$stmt_rentals = $pdo->prepare("SELECT * FROM rentals WHERE added_by = ?");
$stmt_rentals->execute([$user_id]);
$rentals = $stmt_rentals->fetchAll();

// Fetch cars related to the user (if applicable)
$stmt_cars = $pdo->prepare("SELECT * FROM cars WHERE added_by = ?");
$stmt_cars->execute([$user_id]);
$cars = $stmt_cars->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - CY's Car Rental System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Navigation -->
        <nav>
            <a href="index.php" class="btn">Return to Home</a>
            <a href="logout.php" class="btn">Logout</a>
        </nav>

        <!-- Display User Info -->
        <h1>Welcome, <?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h1>
        <p>Email: <?php echo $user['email']; ?></p>
        <p>Phone: <?php echo $user['phone'] ?? 'N/A'; ?></p>
        <p>Address: <?php echo $user['address'] ?? 'N/A'; ?></p>

        <!-- Option to Update Personal Information -->
        <h2>Update Your Information</h2>
        <form action="updateProfile.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            <p>
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required>
            </p>
            <p>
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            </p>
            <p>
                <label for="phone">Phone:</label>
                <input type="text" name="phone" value="<?php echo $user['phone'] ?? ''; ?>">
            </p>
            <p>
                <label for="address">Address:</label>
                <input type="text" name="address" value="<?php echo $user['address'] ?? ''; ?>">
            </p>
            <button type="submit" name="updateProfileBtn" class="btn">Update Profile</button>
        </form>

        <!-- Display User's Rentals -->
        <h2>Your Rentals</h2>
        <?php if (count($rentals) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Rental ID</th>
                        <th>Car Model</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rentals as $rental): ?>
                        <tr>
                            <td><?php echo $rental['rental_id']; ?></td>
                            <td><?php echo getCarById($rental['car_id'])['model']; ?></td>
                            <td><?php echo $rental['status']; ?></td>
                            <td><?php echo $rental['start_date']; ?></td>
                            <td><?php echo $rental['end_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no rentals at the moment.</p>
        <?php endif; ?>

        <!-- Display User's Cars -->
        <h2>Your Cars</h2>
        <?php if (count($cars) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Car ID</th>
                        <th>Model</th>
                        <th>Plate Number</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                        <tr>
                            <td><?php echo $car['car_id']; ?></td>
                            <td><?php echo $car['model']; ?></td>
                            <td><?php echo $car['plate_number']; ?></td>
                            <td><?php echo $car['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no cars registered.</p>
        <?php endif; ?>
    </div>
</body>
</html>
