<?php

include("../db_cofnfiguration/config.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pname = $_POST["pname"];
    $price = $_POST["price"];
    $desc = $_POST["desc"];
    // echo $pname ."<br>".$price."<br>".$desc."<br>";

    $productImage = $_FILES["pimage"];

    if ($productImage["error"] == UPLOAD_ERR_OK) {
        $file = $_FILES["pimage"];
        $filename = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        // echo $filename ."<br> " . $fileTmpName . "<br> " .$fileSize . "<br> " . $fileType . "<br> " ;
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowedExtensions)) {
            if ($fileSize < 5 * 1024 * 1024) { // 5 MB maximum file size
                $fileNameNew = uniqid('', true) . '.' . $fileExt;
                $fileDestination = '../products/' . $fileNameNew;
                echo $fileNameNew;
                
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $sql =  "INSERT INTO product (p_name,p_price,description,image) 
                        VALUES ('$pname', '$price', '$desc', '$fileNameNew')";
                    if ($conn->query($sql)) {
                        $success_message = "Your product has been successfully added.";
                        header("Location: ../frontend/addproduct.php?success=" . urlencode($success_message));
                        exit();
                    } else {
                        $error_message = "Something went wrong. Please try again.<br>" . $conn->error;
                        header("Location: ../frontend/addproduct.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $conn->close();
                } else {
                    $error_msg = "Error while adding your product.";
                    header("Location: ../frontend/addproduct.php?error=" . urlencode($error_msg));
                    exit();
                }
            } else {
                $error_msg = "File size exceeds maximum limit (5 MB).";
                header("Location: ../frontend/addproduct.php?error=" . urlencode($error_msg));
                exit();
            }
        } else {
            $error_msg = "Invalid file type. Allowed file types: " . implode(', ', $allowedExtensions);
            header("Location: ../frontend/addproduct.php?error=" . urlencode($error_msg));
            exit();
        }
    }
}
