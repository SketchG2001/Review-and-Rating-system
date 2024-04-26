
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_error()) 
{
    die("". mysqli_connect_error());
}

// else {
//     echo "connection succesfull<br>";
// }













?>

