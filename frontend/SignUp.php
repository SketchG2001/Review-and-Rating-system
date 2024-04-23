<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <script src="js/nav_footer.js"></script>
    <script src="js/registerValidation.js" ></script>
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
    <div id="nav-content"></div>
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
    
  <div id="foot-content" class="mt-lg-3 "></div>
</body>
</html>