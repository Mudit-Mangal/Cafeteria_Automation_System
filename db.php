<?php
$con =  new mysqli("localhost","root","","cafeteria");
//check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>