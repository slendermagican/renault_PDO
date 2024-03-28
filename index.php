<?php
session_start();
include 'connection.php';


$alertMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (isset($_POST['register'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insertStmt = $mysqli->prepare("INSERT INTO users (fname, lname, email, username, password) VALUES (?, ?, ?, ?, ?)");

        $insertStmt->bind_param("sssss", $fname, $lname, $email, $username, $hashed_password);

        if ($insertStmt->execute()) {
            echo "Registration successful";
        } else {
            echo "Error: " . $mysqli->error;
        }
    }
    // Handle form submission for login
    if (isset($_POST['login'])) {
        // Retrieve form data
        $username = $_POST['username'];
        $password = $_POST['password'];
        // Prepare and execute the SQL query to retrieve user data
        $stmt = $mysqli->prepare("SELECT user_id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        // Check if the user exists
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];
            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Password is correct
                $alertMessage = "Login successful";
                // Execute JavaScript code to display the alert
                echo "<script>alert('$alertMessage');</script>";
            } else {
                // Password is incorrect
                $alertMessage = "Incorrect username or password";
                // Execute JavaScript code to display the alert
                echo "<script>alert('$alertMessage');</script>";
            }
        } else {
            // User does not exist
            $alertMessage = "Incorrect username or password";
            // Execute JavaScript code to display the alert
            echo "<script>alert('$alertMessage');</script>";
        }
    }
}



// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /index.html"); // Redirect to your home page or any other page after logout
    exit();
} ?>

<?php
if (isset($_POST['priceRange'])) {
    try {
        $maxPrice = $_POST['priceRange'];
        $stmt = $pdo->prepare("SELECT * FROM cars WHERE price <= $maxPrice");
        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any database errors
        echo ("Error: " . $e->getMessage());
    }
} else {
    try {
        $stmt = $pdo->prepare("SELECT * FROM cars");
        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo ("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="styles.css">

    <title>Renault</title>
</head>

<body>
    <!--navigation-->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler order-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand order-1">Renault</h1>
                <div class="collapse navbar-collapse order-3" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ms-auto">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php" <?php session_destroy(); ?>><i class="fa-solid fa-sign-out"></i>Logout</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="openLogin()"><i class="fa-solid fa-right-to-bracket"></i>Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="openRegister()"><i class="fa-solid fa-registered"></i>Register</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="/index.html"><i class="fa-solid fa-house"></i>Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/blog.html"><i class="fa-solid fa-blog"></i>Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/gallery.html"><i class="fa-solid fa-image"></i>Gallery</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <!--Upper-->
        <div class="upper">
            <!--filter-->
            <aside>
                <h2>Filter</h2>
                <form method="POST" action="index.php">
                    <div class="form-group">
                        <label for="priceRange">Price Range</label>
                        <input type="range" class="form-control-range" id="priceRange" name="priceRange" min="10000" max="50000" step="500" value="10000">
                        <div class="d-flex justify-content-between">
                            <span id="maxPrice">$10,000</span>
                            <span id="minPrice">$50,000</span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </form>

                <p>Colors:</p>
                <label>
                    <input type="checkbox">
                    Red
                </label>
                <br>
                <label>
                    <input type="checkbox">
                    Green
                </label>
                <br>
                <label>
                    <input type="checkbox">
                    Blue
                </label>
            </aside>
            <!--Slideshow-->
            <section>
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://s1.1zoom.me/b6560/636/Renault_Metallic_Blue_546608_1920x1080.jpg" class="d-block w-100" alt="img1">
                        </div>
                        <div class="carousel-item">
                            <img src="https://s1.1zoom.me/b5762/92/Renault_2018_Megane_R.S._280_Cup_Orange_Metallic_552519_1920x1080.jpg" class="d-block w-100" alt="img2">
                        </div>
                        <div class="carousel-item">
                            <img src="https://wallpapercosmos.com/w/full/1/1/b/3970-1920x1080-desktop-1080p-renault-background-image.jpg" class="d-block w-100" alt="img3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </section>
        </div>
        <!--Lower-->
        <div class="row lower">
            <?php foreach ($cars as $car) : ?>
                <div class="col-md-4 mb-4">
                    <a href="<?php echo 'product.php?product=' . $car['car_id']; ?>">
                        <article class="accordion">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $car['car_id'] ?>" aria-expanded="false" aria-controls="collapse<?= $car['car_id'] ?>">
                                            <img src="<?= $car['image_url'] ?>" class="d-block w-100 images" alt="<?= $car['model'] ?>">
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse<?= $car['car_id'] ?>" class="collapse" aria-labelledby="heading<?= $car['car_id'] ?>" data-parent=".car-grid">
                                    <div class="card-body overflow">
                                        <h2><?= $car['model'] ?></h2>
                                        <p><?= $car['description'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
        <form action="">
            <h2>Write what you like or don't like about the site</h2>
            <textarea rows="3"></textarea>
            <input type="submit" class="submit">
        </form>

    </footer>
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Login Form -->
                    <form id="loginForm" method="post" action="">
                        <div class="form-group">
                            <label for="loginUsername">Username</label>
                            <input type="text" class="form-control" id="loginUsername" name="username" placeholder="Enter your username" required>
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Enter your password" required>
                        </div>
                        <input type="submit" name="login" class="btn btn-primary" value="Log In">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Register Form -->
                    <form id="signupForm" method="post" action="">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="fname" placeholder="Enter your first name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lname" placeholder="Enter your last name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your city" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <input type="submit" name="register" class="btn btn-primary" value="Sign Up">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="modal-body">
                    <!-- Image on the side -->
                    <!-- <img src="path/to/your/image.jpg" alt="Side Image" class="side-image"> -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/5b1a9e5fe0.js" crossorigin="anonymous"></script>
    <script src="index.js"></script>



</body>

</html>