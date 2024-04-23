function clearError(){
    const errors = document.getElementsByClassName("formError");
    for (let err of errors){
        err.textContent = "";
    }
}

function setError(id, error){
    const element = document.getElementById(id);
    const errorElement = element.querySelector(".formError");

    if (errorElement) {
        errorElement.textContent = error;
    }
}

function validateForm() {
    clearError()
    var name = document.getElementById("fullname").value;
    var emailid = document.getElementById("femail").value;
    var mobileNo = document.getElementById("fmobile").value;
    const dob = document.getElementById("dob").value;
    const fileinput = document.getElementById("imgfile")
    const file = fileinput.files[0];
    const maleRadio = document.getElementById("maleradio");
    const femaleRadio = document.getElementById("femaleradio");
    const password = document.getElementById("password").value;
    const cPassword = document.getElementById("cpassword").value;
   

    const nameRegex = /^[a-zA-Z]+(?: [a-zA-Z]+)+$/;
    const emailRegex =  /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    const mobileRegex = /^\d{10}$/;
    const dateRegex = /^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-\d{4}$/;
    const specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
    const numberRegex = /\d/;



    // Perform your validation checks here
    // For example, check if the name is empty
    if (name.trim() === "") {
        setError("name", "Please enter your full name");
        return false;
    }
    // console.log(name)

    // name must contains only chars
    if (!nameRegex.test(name)){
        setError("name", "Invalid Name must contains only alphabets");
        return false;
    }
    if (!file){
        setError("image","please select a file to upload.")
        return false;
    }
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)){
        setError("image","Invalid file type. Please select a JPG, PNG, or GIF image.")
        return false;
    }

    const maxSize = 5 // MB
    if(file.size>maxSize * 1024 * 1024){
        setError("image",`file size exceeds ${maxSize}Mb.`)
        return false;
    }

    // Gender Validation 
    if (!maleRadio.checked && !femaleRadio.checked){
        setError("gender", "Please choose you gender.")
        return false;
    }

    if (password.trim() === ""){
        setError("pass", "Please enter a password.")
        return false;
    }
    if (cPassword.trim() === ""){
        setError("cpass", "Please confirm your password.");
        return false;
    }

    if (password !== cPassword){
        setError("pass", "Passwords do not match.");
        setError("cpass", "Passwords do not match.");
        return false;
    }

    if (password.toLowerCase().includes(name.toLowerCase())) {
        setError("pass", "Password cannot contain your name.");
        return false;
    }

    if (!specialCharRegex.test(password)){
        setError("pass", "Password must contain at least one special character.");
        return false;
    }

    if(!numberRegex.test(password)){
        setError("pass", "Password must contain at least one number.");
        return false;
    }




    if (emailid.trim() === "") {
        // Display error message or perform other actions as needed
        setError("email", "Email Must not empty.");
        // Prevent form submission
        return false;
    }

    if (!emailRegex.test(emailid)){
        setError("email", "invalid email address.");
        return false;
    }

    if (mobileNo.trim() === ""){
        setError("mobile", "Mobile number required.");
        return false;

    }

    if (!mobileRegex.test(mobileNo)){
        setError("mobile", "invalid mobile number must contains only digits.");
        return false;
    }

    // Date validation
    if (dob.trim() === ""){
        setError("date", "please select you birthday.");
        return false;
    }

    const dobMoment = moment(dob, "DD-MM-YYYY");
    if (!dobMoment.isValid()){
        setError("date", "Please enter a valid date in the format dd-mm-yyyy.");
        return false;
    }

    


    
    // If validation passes, return true to allow form submission
    return true;
}

