<?php
session_start();require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['user_id'])){header("Location: login.php");exit;}
$members=$conn->query("SELECT id,name FROM members ORDER BY name ASC");
$availability=$conn->query("SELECT a.id,m.name,a.available_from,a.available_to,m.id as member_id FROM availability a JOIN members m ON m.id=a.member_id ORDER BY a.available_from");
$booked_ids=[];
$b=$conn->query("SELECT slot_id FROM bookings");
while($r=$b->fetch_assoc()){$booked_ids[]=$r['slot_id'];}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="assets/css/middle.css?v=2">
</head>
<body>
<div class="container">
<header class="header"><h1>Meeting Dashboard</h1><div style="text-align:right"><span>Hi, <?php echo htmlspecialchars($_SESSION['name']);?></span> | <a href="logout.php">Logout</a><?php if($_SESSION['role']==='admin'){echo " | <a href='../admin/dashboard.php'>Admin</a>";}?></div></header>
<div class="meeting-info">
<div class="members">
<h2>Members</h2>
<ul>
<?php while($m=$members->fetch_assoc()){echo "<li>".htmlspecialchars($m['name'])."</li>";}?>
</ul>
</div>
<div class="availability">
<h2>Availability</h2>
<ul>
<?php
$availability->data_seek(0);
while($a=$availability->fetch_assoc()){
$slot=htmlspecialchars($a['available_from'])." - ".htmlspecialchars($a['available_to']);
echo "<li>$slot</li>";
}
?>
</ul>
</div>
<div class="booking">
<h2>Slot Booking</h2>
<ul>
<?php
$availability->data_seek(0);
while($a=$availability->fetch_assoc()){
$id=$a['id'];$disabled=in_array($id,$booked_ids)?"disabled":"";$label=in_array($id,$booked_ids)?"Booked":"Book";
echo "<li><a href='form.php?slot=$id&member=".$a['member_id']."'><button class='book-btn' $disabled>$label</button></a></li>";
}
?>
</ul>
</div>
</div>
</div>
</body>
</html>