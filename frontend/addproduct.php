<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script src="js/nav_footer.js"></script>
</head>
<body>
<div id="nav-content"></div>
<?php
if (isset($_GET['success'])) {
    $errorMessage = urldecode($_GET['success']);
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
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
                    <h2 class="text-center">Add Products</h2>
                    <form enctype="multipart/form-data" action="../backend/addprod_server.php" name="productForm" onsubmit="return validateForm()" method="post">
                        <div class="form-group" id="name">
                            <label for="pname">Product Name:</label>
                            <input type="text" class="form-control " id="pname" name="pname" placeholder="Product Name">
                            <b><span class="formError" style="color: red;"></span></b>
                        </div>
                        <div class="form-group" id="image">
                            <label for="pimage" class="form-label">Product Image</label>
                            <input type="file" id="pimage" class="form-control" name="pimage" />
                            <b><span class="formError" style="color: red;"></span></b>
                        </div>
                        <div class="form-group" id="pprice">
                            <label for="price">Product Price:</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="Product Price">
                            <b><span class="formError" style="color: red;"></span></b>
                        </div>
                        <div class="form-group" id="desc">
                            <label for="description">Product Description</label>
                            <div class="form-floating">
                                <textarea class="form-control" name="desc" placeholder="Leave a comment here" id="description"></textarea>              
                            </div>
                            <b><span class="formError" style="color: red;"></span></b>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block mt-2 text-center">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="foot-content"></div>

<script>
function clearError() {
    const errors = document.getElementsByClassName("formError");
    for (let err of errors) {
        err.textContent = "";
    }
}

function setError(id, error) {
    const element = document.getElementById(id);
    const errorElement = element.querySelector(".formError");
    if (errorElement) {
        errorElement.textContent = error;
    }
}

function validateForm() {
    clearError();

    const pname = document.getElementById("pname").value;
    const price = document.getElementById("price").value;
    const fileinput = document.getElementById("pimage");
    const file = fileinput.files[0];
    const descp = document.getElementById("description").value;
    const allowedCharacters = /^[a-zA-Z0-9\s&\-\/]+$/;

    if (pname.trim() === "") {
        setError("name", "Please enter Product name");
        return false;
    }

    if (pname.length < 5 || pname.length > 100) {
        setError("name", "Product name must be between 5 and 100 characters.");
        return false;
    }

    if (!allowedCharacters.test(pname)) {
        setError("name", "Invalid characters in product name. Only alphanumeric characters, spaces, &, -, and / are allowed.");
        return false;
    }

    if (!file) {
        setError("image", "Please select a file to upload.");
        return false;
    }

    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        setError("image", "Invalid file type. Please select a JPG, PNG, or GIF image.");
        return false;
    }

    const maxSize = 5; // MB
    if (file.size > maxSize * 1024 * 1024) {
        setError("image", `File size exceeds ${maxSize} MB.`);
        return false;
    }
    if (price === "") {
    setError("pprice", "Please enter Product price.");
    return false;
}

    const numericPrice = parseFloat(price);
    if (isNaN(numericPrice) || numericPrice <= 0) {
        setError("pprice", "Invalid price. Please enter a valid positive number.");
        return false;
    }

    if (!descp){
        setError("desc","Product description is required.")
        return false;
    }

    if (descp.length < 10 || descp.length > 250){
        setError("desc","Product description must be between 10 and 250 characters.")
        return false;
    }
    return true;
}
</script>
</body>
</html>
