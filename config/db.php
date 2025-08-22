<?php
$host='localhost';$user='root';$pass='12345';$db='meeting_scheduler';
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die('Database connection failed');}
?>