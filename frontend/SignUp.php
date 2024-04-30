<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <script src="js/nav_footer.js"></script>
    <script src="js/registerValidation.js" ></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        /* Optional: Custom CSS styles */
        /* body {
            padding-top: 50px;
        } */
        .formError{
            color: red;
        }
        .form-container {
            max-width: 400px;
            margin: auto;
        }
        
        .signup-Btn {
            width: 70%; 
            }

            .inline-link {
            display: inline; /* Display the elements inline */
            /* margin-right: 30%; Add some margin between the links */
            text-decoration: none;
            }
            .product-link{
                float: right;
            }
    </style>
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
    if (isset($_GET['error'])) {
        $error_message =urldecode($_GET['error']);
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card form-container">
                    <div class="card-body">
                        <h2 class="text-center">Sign Up</h2>
                        <form enctype="multipart/form-data" name="signup" action="../backend/signup_server.php"  onsubmit="return validateForm()" method="post">
                            <div class="form-group" id="name">
                                <label for="fullname">Full Name:</label>
                                <input type="text" class="form-control" id="fullname" name="name" placeholder="Enter full name">
                                <b><span class="formError"></span></b>
                            </div>
                            <div class="form-group" id="email">
                                <label for="femail">Email:</label>
                                <input type="email" class="form-control" id="femail" name="email" placeholder="Enter email">
                                <b><span class="formError"></span></b>
                            </div>
                            <div class="form-group" id="mobile">
                                <label for="mobile">Mobile No:</label>
                                <input type="tel" class="form-control" id="fmobile" name="fmobile" placeholder="Mobile No">
                                <b><span class="formError"></span></b>
                            </div>
                            <div class="form-group" id="date">
                                <label for="dob">Date of birth:</label>
                                <input type="date" class="form-control" name="date" id="dob" >
                                <b><span class="formError"></span></b>
                            </div>

                            <div class="form-group" id="image">
                                <label for="imgfile" class="form-label">Latest Photo</label>
                                <input type="file" id="imgfile" class="form-control" name="file"  />
                                <b><span class="formError"></span></b>
                            </div>
                            
                            <div class="form-group mt-1" id="gender">
                                <div class="container ">
                                <label for="datefield" class="form-label">Gender</label>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" id="maleradio" name="gender" value="male" />
                                  <label class="form-check-label" for="maleradio">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" id="femaleradio" name="gender" value="female" />
                                  <label class="form-check-label" for="femaleradio">Female</label>
                                </div>
                            </div>
                                <b><span class="formError"></span></b>
                              </div>


                            <div class="form-group" id="pass">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" name="pass" id="password" autocomplete="new-password" placeholder="Enter password">
                                <b><span class="formError"></span></b>
                            </div>
                            <div class="form-group" id="cpass">
                                <label for="cpassword">Confirm Password:</label>
                                <input type="password" class="form-control" name="cpass" id="cpassword" autocomplete="new-password" placeholder="Confirm password">
                                <b><span class="formError"></span></b>
                            </div>
                            <div class="container ">
                                <a href="login.html" class="inline-link"><span>Login</span></a>
                                <a href="product.html" class="inline-link product-link">View Product</a>
                            </div>
                            
                            <div class="container text-center">
                                <button type="submit" name="submit" class="btn btn-primary btn-block mt-2 signup-Btn"style="border-radius: 40px;">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // gender toggle system
        const maleRadio = document.getElementById("maleradio");
        const femaleRadio = document.getElementById("femaleradio");

        // Event listener for gender radio buttons
        document.querySelectorAll('input[name="gender"]').forEach((radio) => {
        radio.addEventListener('change', function() {
        if (this.value === 'male') {
            femaleRadio.checked = false; // Uncheck female if male is selected
        } else if (this.value === 'female') {
            maleRadio.checked = false; // Uncheck male if female is selected
        }
    });
});
 </script>
    
  <!-- <div id="foot-content" class="mt-lg-3 "></div> -->
</body>
</html>