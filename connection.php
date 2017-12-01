<?php
$user_name = "malcolmc_malcolmchen";
$password = "34d1WnY7dt";
$database = "malcolmc_gift";
$server = "localhost";
$conn = mysqli_connect("$server","$user_name" ,"$password", "$database");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";

