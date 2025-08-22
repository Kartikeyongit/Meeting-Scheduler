<?php
session_start();require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['user_id'])||$_SESSION['role']!=='admin'){header("Location: ../public/login.php");exit;}
$msg="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
$name=trim($_POST['name']??"");if($name){$s=$conn->prepare("INSERT INTO members(name) VALUES(?)");$s->bind_param("s",$name);$s->execute();$msg="Added";}else{$msg="Name required";}
}
$members=$conn->query("SELECT id,name FROM members ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Members</title>
<link rel="stylesheet" href="../public/assets/css/middle.css?v=2">
</head>
<body>
<div class="container">
<h1>Members</h1>
<form method="POST"><input type="text" name="name" placeholder="Member name" required><button type="submit" class="book-btn">Add</button></form>
<ul>
<?php while($m=$members->fetch_assoc()){echo "<li>".$m['name']."</li>";}?>
</ul>
<p><a href="dashboard.php">Back</a></p>
<?php if($msg){echo "<p>$msg</p>";}?>
</div>
</body>
</html>