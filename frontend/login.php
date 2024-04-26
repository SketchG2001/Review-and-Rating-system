<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="js/nav_footer.js"></script>
</head>
<body>
<div id="nav-content"></div>
<?php
 if (isset($_GET['success'])) {
 $errorMessage = urldecode($_GET['success']);
echo '<p style="color: red;">' . $errorMessage . '</p>';
}
?>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card form-container">
                <div class="card-body">
                    <h2 class="text-center">Sign Up</h2>
                    <form enctype="multipart/form-data" name="signup" action="../backend/login_server.php" onsubmit="return validateForm()" method="post">
                        <div class="form-group" id="mob">
                            <label for="mobile">Mobile No:</label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number">
                            <span class="formError" style="color: red;"></span>
                        </div>
                        <div class="form-group" id="pass">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                            <span class="formError" style="color: red;"></span>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block mt-2 text-center">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="foot-content"></div>

<script>
function validateForm() {
    const mobileNo = document.getElementById("mobile").value.trim();
    const password = document.getElementById("password").value.trim();
    const mobileRegex = /^\d{10}$/;
    const specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
    const numberRegex = /\d/;

    clearError(); // Clear previous error messages

    if (mobileNo === "") {
        setError("mob", "Mobile number is required.");
        return false;
    }

    if (!mobileRegex.test(mobileNo)) {
        setError("mob", "Invalid mobile number. Must contain 10 digits.");
        return false;
    }

    if (password === "") {
        setError("pass", "Password is required.");
        return false;
    }

    if (!specialCharRegex.test(password)) {
        setError("pass", "Password must contain at least one special character.");
        return false;
    }

    if (!numberRegex.test(password)) {
        setError("pass", "Password must contain at least one number.");
        return false;
    }

    return true; // Form submission allowed if all validations pass
}

function clearError() {
    const errorElements = document.getElementsByClassName("formError");
    for (let i = 0; i < errorElements.length; i++) {
        errorElements[i].textContent = "";
    }
}

function setError(id, error) {
    const errorElement = document.getElementById(id).querySelector(".formError");
    if (errorElement) {
        errorElement.textContent = error;
    }
}
</script>

</body>
</html>
