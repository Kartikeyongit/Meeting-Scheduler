<?php
session_start();require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['user_id'])||$_SESSION['role']!=='admin'){header("Location: ../public/login.php");exit;}
$msg="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
$member_id=intval($_POST['member_id']??0);$from=$_POST['from']??"";$to=$_POST['to']??"";
if($member_id&&$from&&$to){$s=$conn->prepare("INSERT INTO availability(member_id,available_from,available_to) VALUES(?,?,?)");$s->bind_param("iss",$member_id,$from,$to);$s->execute();$msg="Added";}else{$msg="All fields required";}
}
$members=$conn->query("SELECT id,name FROM members ORDER BY name");
$list=$conn->query("SELECT a.id,m.name,a.available_from,a.available_to FROM availability a JOIN members m ON m.id=a.member_id ORDER BY a.available_from");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Availability</title>
<link rel="stylesheet" href="../public/assets/css/middle.css?v=2">
</head>
<body>
<div class="container">
<h1>Availability</h1>
<form method="POST">
<select name="member_id" required>
<option value="">Select member</option>
<?php while($m=$members->fetch_assoc()){echo "<option value='".$m['id']."'>".$m['name']."</option>";}?>
</select>
<input type="time" name="from" required>
<input type="time" name="to" required>
<button type="submit" class="book-btn">Add</button>
</form>
<ul>
<?php while($r=$list->fetch_assoc()){echo "<li>".$r['name']." ".$r['available_from']." - ".$r['available_to']."</li>";}?>
</ul>
<p><a href="dashboard.php">Back</a></p>
<?php if($msg){echo "<p>$msg</p>";}?>
</div>
</body>
</html>