<?php
session_start();
include 'connection.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    if (isset($_POST['register'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

        try {
            // Check if the username already exists
            $checkUsernameStmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $checkUsernameStmt->execute([$username]);
            $existingUsername = $checkUsernameStmt->fetch(PDO::FETCH_ASSOC);

            // Check if the email already exists
            $checkEmailStmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $checkEmailStmt->execute([$email]);
            $existingEmail = $checkEmailStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUsername) {
                $errors['username'] = 'Username is already taken';
            }
            if ($existingEmail) {
                $errors['email'] = 'Email is already taken';
            }

            if (empty($errors)) {
                // Prepare and execute the SQL query to insert data into the users table
                $insertStmt = $pdo->prepare("INSERT INTO users (username, password, email, fname, lname) VALUES (?, ?, ?, ?, ?)");
                $insertStmt->execute([$username, $password, $email, $fname, $lname]);

                // Retrieve the user ID after insertion
                $userId = $pdo->lastInsertId();

                // Save the user ID in the session
                $_SESSION['user_id'] = $userId;

                // Redirect to a success page or perform other actions after successful registration
                echo "Registration successful";
                exit();
            }
        } catch (PDOException $e) {
            echo("Error: " . $e->getMessage());
        }
    }
}

//Login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            // Check if the username exists
            $checkUsernameStmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $checkUsernameStmt->execute([$username]);
            $user = $checkUsernameStmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Password is correct, log in the user
                $_SESSION['user_id'] = $user['user_id'];
                echo "Login successful";
                exit();
            } else {
                $errors['login'] = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            echo("Error: " . $e->getMessage());
        }
    }
}


// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /index.html"); // Redirect to your home page or any other page after logout
    exit();
}

try {
    $stmt = $pdo->query("SELECT * FROM cars");
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo("Error: " . $e->getMessage());
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
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="index.php" <?php session_destroy();?>><i class="fa-solid fa-sign-out"></i>Logout</a>
                            </li>
                        <?php else: ?>
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
                <div class="form-group">
                    <label for="priceRange">Price Range</label>
                    <input type="range" class="form-control-range" id="priceRange" min="0" max="1000" step="10" value="0">
                    <div class="d-flex justify-content-between">
                        <span id="minPrice">$0</span>
                        <span id="maxPrice">$1000</span>
                    </div>
                </div>
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
        <div class="row car-grid lower">
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
                    <form id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="loginUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="loginUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <span class="text-danger"><?php echo $errors['login']; ?></span>
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
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
                    <form id="registerForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="registerFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="registerFirstName" name="fname" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="registerLastName" name="lname" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="registerUsername" name="username" required>
                            <span class="text-danger"><?php echo $errors['username']; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="registerEmail" name="email" required>
                            <span class="text-danger"><?php echo $errors['email']; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="registerPassword" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
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