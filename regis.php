<?php
include 'config.php';
session_start();

$message = ''; // Variable to hold login message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $message = "Login successful! Welcome, " . htmlspecialchars($user['email']);
        // Redirect to home page after 3 seconds
        header("Refresh: 3; url=websitestylika.html");
    } else {
        $message = "Login failed! Invalid email or password.";
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
    <title>Login - Online Shopping</title>
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
            object-fit: cover; /* Ensures the video covers the entire background without zooming */
            object-position: center; /* Centers the video */
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .login-container img {
            width: 100px;
            margin-bottom: 20px;
        }

        .login-container h2 {
            margin: 20px;
            color: #333;
        }

        .login-container input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container button {
            width: 80%;
            padding: 12px;
            background-color: #f17203;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        .login-container button:hover {
            background-color: black;
        }

        .error-message {
            color: red;
            font-size: 14px;
            display: none;
            margin-bottom: 10px;
        }

        .login-container a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        /* Center the login form */
        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .nav-link {
            font-size: 1.2rem; /* Increased font size */
            margin: 0 40px; /* Added margin for spacing */
            color: white;
        }

        .nav-link:hover, 
        .form-control:hover, 
        .btn-outline-success:hover {
            background-color: white; /* Change background color on hover */
            color: #2243ff; /* Change text color on hover */
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-black">
            <div class="container-fluid">
                <form class="d-flex me-auto" role="search" id="search-form" id="colour" onsubmit="event.preventDefault(); searchProducts();">
                    <img src="logo.png" class="card-img-top" style="width:20%; height: 50px;" alt="Product Image">
                    <li><br></li>
                    <input class="form-control me-2" type="search" id="search-input" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>

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
            <source src="video/video1.mp4" type="video/mp4"> <!-- Replace with your video URL -->
            Your browser does not support HTML5 video.
        </video>
    </div>

    <div class="wrapper">
        <div class="login-container">
            <img src="logo.png" alt="Logo" style="height:80px;width:150px;"> <!-- Replace with your logo image URL -->
            <h2>Login</h2>
            <form method="POST" action="">
                <input type="email" name="email" required placeholder="Email"><br>
                <input type="password" name="password" required placeholder="Password"><br>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
            <?php if ($message): ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Optional: Add a script to close alert after a few seconds
        setTimeout(function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 5000); // Change the duration (in milliseconds) as needed
    </script>
</body>
</html>
