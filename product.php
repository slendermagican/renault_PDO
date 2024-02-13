<?php
include 'connection.php';

if (isset($_GET['product'])) {
    $car_id = $_GET['product'];

    // Use prepared statement to avoid SQL injection
    $sql = "SELECT * FROM cars WHERE car_id = :car_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':car_id', $car_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch a single row as an associative array
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        // Handle case where no car is found with the given ID
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <!-- Modern Color Palette -->
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
</head>

<body class="container">

    <div id="product-content" class="mt-5">
        <h1 class="text-xl font-bold mb-2"><?= htmlspecialchars($car['model']) ?></h1>
        <img src="<?= htmlspecialchars($car['image_url']) ?>" alt="img" class="img-fluid rounded mb-2">
        <p class="text-muted"><?= htmlspecialchars($car['description']) ?></p>

        <!-- Display all parameters of the car using Bootstrap list group -->
        <ul class="list-group">
            <li class="list-group-item">Year: <?= htmlspecialchars($car['year']) ?></li>
            <li class="list-group-item">Engine Type: <?= htmlspecialchars($car['engine_type']) ?></li>
            <li class="list-group-item">Horsepower: <?= htmlspecialchars($car['horsepower']) ?> hp</li>
            <li class="list-group-item">Torque: <?= htmlspecialchars($car['torque']) ?> Nm</li>
            <li class="list-group-item">Transmission: <?= htmlspecialchars($car['transmission']) ?></li>
            <li class="list-group-item">Acceleration Time: <?= htmlspecialchars($car['acceleration_time']) ?> seconds</li>
            <li class="list-group-item">Top Speed: <?= htmlspecialchars($car['top_speed']) ?> km/h</li>
            <li class="list-group-item">Fuel Efficiency (City): <?= htmlspecialchars($car['fuel_efficiency_city']) ?> l/100km</li>
            <li class="list-group-item">Fuel Efficiency (Highway): <?= htmlspecialchars($car['fuel_efficiency_highway']) ?> l/100km</li>
            <li class="list-group-item">Weight: <?= htmlspecialchars($car['weight']) ?> kg</li>
        </ul>
    </div>

    <!-- Modern JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>


</html>