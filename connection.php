<?php
$server="localhost";
$username="root";
$password="";
$database="website"; 

$conn = mysqli_connect($server, $username , $password , $database);
// if(!$conn){
//     die('error'.mysqli_connect_error());
// }

if(mysqli_connect_error()){
    echo"<script>alert('cannot connect to database');</script>";
}
?>