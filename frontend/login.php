<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="js/nav_footer.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="_home.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link active" href="allprod.php">Products</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="SignUp.php">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">Login</a>
                    </li>
                    <?php
                    if (isset($_SESSION['mobile'])) {
                        echo '
                    <li class="nav-item">
                        <a class="nav-link active" href="../backend/logout.php">LogOut</a>
                    </li>';
                    }
                    ?>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
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
                        <h2 class="text-center">Log In</h2>
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