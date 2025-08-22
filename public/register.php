<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$msg="";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $password = $_POST['password'] ?? "";

    if ($name && $email && $password) {
        // Store plain password directly
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $msg = "Error: " . $conn->error;
        }
    } else {
        $msg = "All fields required";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link rel="stylesheet" href="assets/css/form.css?v=2">
</head>
<body>
<h2>Register</h2>
<form method="POST">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Create Account</button>
</form>
<?php if($msg){echo "<p style='color:white;text-align:center;'>$msg</p>";}?>
</body>
</html>
