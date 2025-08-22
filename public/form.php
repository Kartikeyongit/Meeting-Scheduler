<?php
session_start();require_once __DIR__ . '/../config/db.php';
if(!isset($_SESSION['user_id'])){header("Location: login.php");exit;}
$slot_id=intval($_GET['slot']??0);$member_id=intval($_GET['member']??0);
if($_SERVER["REQUEST_METHOD"]==="POST"){
$reason=trim($_POST['reason']??"");$slot_id=intval($_POST['slot']);$member_id=intval($_POST['member']);
if($reason&&$slot_id&&$member_id){
$check=$conn->prepare("SELECT id FROM bookings WHERE slot_id=?");
$check->bind_param("i",$slot_id);$check->execute();$cr=$check->get_result()->fetch_assoc();
if($cr){$msg="Slot already booked";}else{
$stmt=$conn->prepare("INSERT INTO bookings(user_id,member_id,slot_id,reason) VALUES(?,?,?,?)");
$stmt->bind_param("iiis",$_SESSION['user_id'],$member_id,$slot_id,$reason);
if($stmt->execute()){header("Location: middle.php");exit;}else{$msg="Error";}
}
}else{$msg="All fields required";}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Slot</title>
<link rel="stylesheet" href="assets/css/form.css">
</head>
<body>
<h2>Meeting Slot Booking</h2>
<form method="POST">
<label for="reason">Reason</label>
<textarea id="reason" name="reason" required></textarea>
<input type="hidden" name="slot" value="<?php echo htmlspecialchars($slot_id);?>">
<input type="hidden" name="member" value="<?php echo htmlspecialchars($member_id);?>">
<button type="submit">Submit</button>
</form>
<?php if(!empty($msg)){echo "<p style='color:white;text-align:center;'>$msg</p>";}?>
</body>
</html>