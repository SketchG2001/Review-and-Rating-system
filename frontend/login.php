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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar bg-body-tertiary ">
        <div class="container-fluid">
          <a class="navbar-brand" href="allprod.php"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
  <path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.8 6.8 0 0 0 1.16 8z"/>
  <path d="M6.641 11.671V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352zm0-3.75V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324z"/>
</svg> & <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
  <path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.8 6.8 0 0 0 1.16 8z"/>
  <path d="M6.641 11.671V8.843h1.57l1.498 2.828h1.314L9.377 8.665c.897-.3 1.427-1.106 1.427-2.1 0-1.37-.943-2.246-2.456-2.246H5.5v7.352zm0-3.75V5.277h1.57c.881 0 1.416.499 1.416 1.32 0 .84-.504 1.324-1.386 1.324z"/>
</svg></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="_home.php"><b>Home</b></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link active" href="allprod.php"><b>Products</b></a>
              </li>
              <?php
   
                if (isset($_SESSION['mobile'])) {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link active" href="../backend/logout.php"><b>LogOut</b></a>
                    </li>';
                }else {
                    // User is not logged in, show Login link
                    echo '
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php"><b>Login</b></a>
                    </li>';
                    echo '
                    <li class="nav-item">
                        <a class="nav-link active" href="SignUp.php"><b>Sign Up</b></a>
                    </li>';
                }
                ?>
            </ul>
            <!-- <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
          </div>
        </div>
</nav>
<?php
if (isset($_GET['success'])) {
    $errorMessage = urldecode($_GET['success']);
    echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $errorMessage . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

if (isset($_GET['message'])) {
    $errorMessage = urldecode($_GET['message']);
    echo '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $errorMessage . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
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
                            
                            <button type="submit" name="submit" class="btn btn-primary btn-block mt-2 text-center">Log In</button>
                            <a href="SignUp.php" style="float: right;">Don't have account?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<br>
    <!-- <div id="foot-content"></div> -->

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