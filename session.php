<?php
session_start();
require 'db.php';

if(isset($_SESSION['username']))
{
$user=$_SESSION['username'];
$stmt=$con->prepare("SELECT * FROM users WHERE username=?");
$stmt->bind_param("s",$user);
$stmt->execute();
$result=$stmt->get_result();
$row=$result->fetch_array(MYSQLI_ASSOC);

$username=$row['username'];
//    if(isset($_COOKIE['username']))
//$username ='cookie' + $_COOKIE['username'];
$name=$row['name'];
$email=$row['email'];
$created=$row['created'];
}
else
{
$username = 'guest';
}
//if(!isset($user)){
//    header("location:signin.php");
//}
?>