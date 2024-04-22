<?php
include("config.php");

$sql = "CREATE TABLE product (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        p_name VARCHAR(30) NOT NULL,
        p_price DECIMAL(10, 2),
        description VARCHAR(30) NOT NULL,
        image VARCHAR(50) NOT NULL,
        Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";  

if ($conn->query($sql) === TRUE) {
    echo "table created succesfully";
}
else{
    echo "error while creating the table.".$conn->error;
}




?>
