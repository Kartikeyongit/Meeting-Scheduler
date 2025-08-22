<?php
session_start();require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['user_id'])||$_SESSION['role']!=='admin'){header("Location: ../public/login.php");exit;}
$bookings=$conn->query("SELECT b.id,u.name as user_name,m.name as member_name,CONCAT(a.available_from,' - ',a.available_to) as slot_time,b.created_at FROM bookings b JOIN users u ON u.id=b.user_id JOIN members m ON m.id=b.member_id JOIN availability a ON a.id=b.slot_id ORDER BY b.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin</title>
<link rel="stylesheet" href="../public/assets/css/middle.css?v=2">
</head>
<body>
<div class="container">
<h1>Admin Dashboard</h1>
<p><a href="../public/middle.php">Back</a></p>
<h2>Bookings</h2>
<ul>
<?php while($b=$bookings->fetch_assoc()){echo "<li>".$b['user_name']." → ".$b['member_name']." (".$b['slot_time'].")</li>";}?>
</ul>
<h2>Manage</h2>
<p><a href="members.php">Members</a> | <a href="availability.php">Availability</a></p>
</div>
</body>
</html>