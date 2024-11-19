<?php
// register.php
include 'db_connection.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an SQL statement to insert the new user
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'login.html'; // Redirect to the login page
              </script>";
    } else {
        // Registration failed (e.g., email already exists)
        echo "<script>
                alert('Registration failed. Email may already be in use.');
                window.history.back(); // Go back to the registration page
              </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    header("Location: register.html"); // Redirect to registration page if accessed directly
    exit();
}
?>
+-