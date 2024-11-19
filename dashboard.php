<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h2>Welcome to the Dashboard!</h2>
    <p>You are logged in as user ID: <?php echo $_SESSION['user_id']; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
