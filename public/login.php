<?php
session_start();require_once __DIR__ . '/../config/db.php';
$msg="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
$email=trim($_POST['email']??"");$password=$_POST['password']??"";
$stmt=$conn->prepare("SELECT id,password,role,name FROM users WHERE email=?");
$stmt->bind_param("s",$email);$stmt->execute();$res=$stmt->get_result();$u=$res->fetch_assoc();
if ($u && $password === $u['password']) {
    $_SESSION['user_id']=$u['id'];
    $_SESSION['role']=$u['role'];
    $_SESSION['name']=$u['name'];
    header("Location: middle.php");
    exit;
} else {
    echo "Invalid credentials!";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="assets/css/form.css?v=2">
</head>
<body>
<h2>Login</h2>
<form method="POST">
<label for="email">Email</label>
<input type="email" id="email" name="email" required>
<label for="password">Password</label>
<input type="password" id="password" name="password" required>
<button type="submit">Login</button>
</form>
<?php if($msg){echo "<p style='color:white;text-align:center;'>$msg</p>";}?>
</body>
</html>