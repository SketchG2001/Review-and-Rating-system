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

    $dobValidation = validateDate($dob, 'd-m-Y'); // Validate date in "d-m-Y" format
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
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email address.";
    }

    return true;
}

function validateMobile($mobile) {
    if (empty($mobile)) {
        return "Mobile number cannot be empty.";
    }
    if (!preg_match('/^\d{10}$/', $mobile)) {
        return 'Invalid mobile number. Please enter a 10-digit number.';
        echo $mobile;
    }

    return true;
}

function validateDate($date) {
    if (empty($date)) {
        return "Date of birth cannot be empty.";
    }
    
    // Create a DateTime object from the input date
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    
    // Check if the DateTime object was created successfully and matches the input date
    if (!$dateTime || $dateTime->format('Y-m-d') !== $date) {
        return "Invalid date format. Please enter a valid date.";
    }
    
    return true;  // Date is valid
}

function validateGender($gender) {
    if (empty($gender)) {
        return "Gender cannot be empty.";
    }
    
    if (!in_array($gender, ['male', 'female'])) {
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

// Validate form data upon form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobile = $_POST["fmobile"];
    $dob = $_POST["date"];
    $gender = $_POST["gender"];
    $password = $_POST["pass"];
    $cpassword = $_POST["cpass"];

    


    $validationResult = validateDate($dob);
    // print_r($validationResult);
    // exit();

    // Validate form data
    $validationResult = validateFormData($name, $email, $mobile, $dob, $gender, $password, $cpassword);
    if ($validationResult !== true) {
        // Validation failed, display error message
            header("Location: ../frontend/SignUp.php?error=" . urlencode($validationResult));
            exit();
    } else {
        // Validation passed, proceed with further processing (e.g., file upload)
        // Handle file upload
        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            $file = $_FILES["file"];
            $filename = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];
            $fileType = $file['type'];
            
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (in_array($fileExt, $allowedExtensions)) {
                if ($fileError === 0) {
                    if ($fileSize < 5 * 1024 * 1024) { // 5 MB maximum file size
                        $fileNameNew = uniqid('', true) . '.' . $fileExt;
                        $fileDestination = '../uploads/' . $fileNameNew;
                        
                        if (move_uploaded_file($fileTmpName, $fileDestination)) {
                            // File uploaded successfully, proceed with database operations, etc.
                            $securedPassword = password_hash($password, PASSWORD_DEFAULT);
                            $sql = "INSERT INTO USERS (Name,email,mobile,dob,gender,password,picture) 
                            VALUES ('$name','$email','$mobile','$dob','$gender','$securedPassword','$fileNameNew')";
                            // echo $mobile ."<br>";
                            // exit();
                        if ($conn->query($sql)) {
                            $success_message = "You have registered successfully";
                            header("Location: ../frontend/login.php?success=" . urlencode($success_message));
                            exit();
                            }
                        else {
                            $error_message = "Something went wrong. Please try again.<br>" . $conn->error;
                            header("Location: ../frontend/SignUp.php?error=" . urlencode($error_message));
                            exit();
                        }
                        $conn->close();                           
                        } else {
                            $error_msg = "Error while uploading file.";
                            header("Location: ../frontend/SignUp.php?error=" . urlencode($error_msg));
                            exit();
                        }
                    } else {
                        $error_msg = "File size exceeds maximum limit (5 MB).";
                        header("Location: ../frontend/SignUp.php?error=" . urlencode($error_msg));
                        exit();
                    }
                } else {
                    $error_msg = "Error uploading file: " . $fileError;
                    header("Location: ../frontend/SignUp.php?error=" . urlencode($error_msg));
                    exit();
                }
            } else {
                $error_msg = "Invalid file type. Allowed file types: " . implode(', ', $allowedExtensions);
                header("Location: ../frontend/SignUp.php?error=" . urlencode($error_msg));
                exit();
            }
        } else {
            $error_msg = "File upload error: No file uploaded or invalid file.";
            header("Location: ../frontend/SignUp.php?error=" . urlencode($error_msg));
            exit();
        }
    }
}
?>
