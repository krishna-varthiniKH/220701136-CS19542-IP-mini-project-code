<?php
include 'config.php';
$message = ''; // Variable to hold messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the email already exists
    $checkEmailSql = "SELECT * FROM users WHERE email = :email";
    $checkEmailStmt = $conn->prepare($checkEmailSql);
    $checkEmailStmt->bindParam(':email', $email);
    $checkEmailStmt->execute();

    if ($checkEmailStmt->rowCount() > 0) {
        $message = "Email already exists!";
    } else {
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            // Set a success message
            $message = "Registration successful! You can now log in.";
            // Optionally redirect to home page after a brief delay
            header("Refresh:2; url=websitestylika.html"); // Redirect after 2 seconds
        } else {
            $message = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="title.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Register - Online Shopping</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            overflow: hidden;
        }

        /* Video background */
        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .register-container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .register-container img {
            width: 100px;
            margin-bottom: 20px;
        }

        .register-container h2 {
            margin: 20px;
            color: #333;
        }

        .register-container input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .register-container button {
            width: 80%;
            padding: 12px;
            background-color: #f17203; /* Change color as needed */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .register-container button:hover {
            background-color: black;
        }

        .register-container a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .register-container a:hover {
            text-decoration: underline;
        }

        /* Center the registration form */
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Navbar styling */
        .nav-link {
            font-size: 1.2rem;
            margin: 0 40px;
            color: white;
        }

        .nav-link:hover {
            background-color: white;
            color: #2243ff;
            border-radius: 4px;
        }

        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-black">
            <div class="container-fluid">
                <a class="navbar-brand" href="websitestylika.html">
                    <img src="logo.png" alt="Logo" style="height:40px;width:160px;"> <!-- Logo in the navbar -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="websitestylika.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="autumnproduct.html">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link cart-badge" href="carting.html">
                                Cart <span class="badge bg-primary" id="cart-count">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="video-container">
        <video autoplay loop muted>
            <source src="video.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
    </div>

    <div class="wrapper">
        <div class="register-container">
            <img src="logo.png" alt="Logo" style="height:80px;width:150px;">
            <h2>Register</h2>
            <?php if ($message): ?>
                <div class="alert alert-warning"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <input type="email" name="email" required placeholder="Email"><br>
                <input type="password" name="password" required placeholder="Password"><br>
                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account? <a href="http://localhost/regis.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
