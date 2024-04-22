<?php

include("config.php");


$sql = "CREATE DATABASE myDB";

if ($conn->query($sql) === TRUE) {
    echo "db created succefully";
}
else{
    echo "Error creating database: " . $conn->error;
}




?>