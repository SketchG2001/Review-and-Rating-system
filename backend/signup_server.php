<?php

include("../db_cofnfiguration/config.php");


function validateFormData($name, $email, $mobile, $dob, $gender, $password, $cpassword) {
    $nameValidation = validateName($name);
    if ($nameValidation !== true) {
        return $nameValidation;
    }

    $emailValidation = validateEmail($email);
    if ($emailValidation !== true) {
        return $emailValidation;
    }

    $mobileValidation = validateMobile($mobile);
    if ($mobileValidation !== true) {
        return $mobileValidation;
    }

    $dobValidation = validateDate($dob);
    if ($dobValidation !== true) {
        return $dobValidation;
    }

    $genderValidation = validateGender($gender);
    if ($genderValidation !== true) {
        return $genderValidation;
    }

    $passwordValidation = validatePassword($password);
    if ($passwordValidation !== true) {
        return $passwordValidation;
    }

    $confirmPasswordValidation = validateConfirmPassword($password, $cpassword);
    if ($confirmPasswordValidation !== true) {
        return $confirmPasswordValidation;
    }

    // All validation passed
    return true;
}

function validateName($name) {
    if (empty($name)) {
        return "Full name cannot be empty.";
    }

    if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        return 'Invalid full name. Please use only alphabetic characters and spaces.';
    }
    
    return true;
}

function validateEmail($email) {
    if (empty($email)) {
        return "Email address cannot be empty.";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid Email address.";
    }

    return true;
}

function validateMobile($mobile) {
    if (empty($mobile)) {
        return "Mobile number cannot be empty.";
    }
    if (!filter_var($mobile, FILTER_VALIDATE_INT) && strlen($mobile) === 10){
        return 'invalid mobile number.';
    }

    return true;
}

function validateDate($date, $format = 'd-m-Y') {
    if (empty($date)) {
        return "Date of birth cannot be empty.";
    }
    $dateTime = DateTime::createFromFormat($format, $date);
    if (!$dateTime || $dateTime->format($format) !== $date) {
        return "Invalid date format. Please enter a valid date in the format $format.";
    }
    
    return true;
}

function validateGender($gender) {
    if (empty($gender)) {
        return "Gender cannot be empty.";
    }
    
    if ($gender !== "male" && $gender !== "female"){
        return "Invalid gender. Please select either 'male' or 'female'.";
    }
    
    return true;
}

function validatePassword($password) {
    if (empty($password)) {
        return "Password cannot be empty.";
    }
    // Additional validation logic for password can be added here if needed

    return true;
}

function validateConfirmPassword($password, $cpassword) {
    if (empty($cpassword)) {
        return "Confirm password cannot be empty.";
    }
    if ($password !== $cpassword) {
        return "Password and confirm password do not match.";
    }
    // Additional validation logic for password matching can be added here if needed

    return true;
}

// Usage example:
$name = $_POST["name"];
$email = $_POST["email"];
$mobile = $_POST["fmobile"];
$dob = $_POST["date"];
$gender = $_POST["gender"];
$password = $_POST["pass"];
$cpassword = $_POST["cpass"];

$validationResult = validateFormData($name, $email, $mobile, $dob, $gender, $password, $cpassword);
if ($validationResult === true) {
    // All form data is valid, proceed with further processing
    echo "Form data is valid.";
} else {
    // Validation failed, display error message
    echo "Validation failed: " . $validationResult;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maxFileSize = 5 * 1024 * 1024;
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["fmobile"];
    $dob = $_POST["date"];
    $gender = $_POST["gender"];
    $password = $_POST["pass"];
    $cpassword = $_POST["cpass"];

    echo $name ."<br>";
    echo $email ."<br>";
    echo $mobile ."<br>";
    echo $dob ."<br>";
    
    echo $gender ."<br>";
    echo $password ."<br>";
    echo $cpassword ."<br>";

    $validationResult = validateFormData($name, $email, $mobile, $dob, $gender, $password, $cpassword);
    echo $validationResult;
    // exit();

    if ($validationResult === true) {
        header("Location: ../frontend/SignUp.php?error=" . urlencode($validationResult));
            exit();
    }
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {     
        $file = $_FILES["file"];
        $fileTMPName = $_FILES['file']['tmp_name'];
        $filename = $_FILES['file']['name'];
        $filesize = $_FILES['file']['size'];
        $fileerror = $_FILES['file']['error'];
        $filetype = $_FILES['file']['type'];
            echo "File Name: " . $filename . "<br>";
            echo "File Type: " . $filetype . "<br>";
            echo "File Size: " . ($filesize / 1024) . " KB<br>";
            echo "Temporary File Location: " . $fileTMPName . "<br>";
            echo $fileerror."<br>";
            $allowed = array('jpg', 'jpeg', 'png', 'pdf');
            
            $fileExt = explode('.',$filename);
            $fileactualExt = strtolower(end($fileExt));
            if (in_array($fileactualExt, $allowed)){
            if ($fileerror === 0){
                if ($filesize < $maxFileSize){
                    $fileNameNew = uniqid('',true). ".".$fileactualExt;
                    $fileDestination = '../uploads/'. basename($fileNameNew);
                    echo $fileDestination .'<br>';
                            
                        if (move_uploaded_file($fileTMPName, $fileDestination)){
                                // echo "file Uploaded";
                            $securedPassword = password_hash($password, PASSWORD_DEFAULT);
                            echo $securedPassword ."<br>";
                            exit();
                        }else{
                                echo "error while uploading";
                        }
                    }
                }
                    
            }
        }


}





















?>
