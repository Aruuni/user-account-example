function onSubmit(event) {

    if (validateForm()) {
        if (checkPasswordStrength() || true) {
            document.getElementById("warning-message").style.display = "none";
            document.getElementById("signup-form").submit();
        } else {
            document.getElementById("warning-message").innerText = "Password too weak";
            document.getElementById("warning-message").style.display = "block";
        }
    } else {
        document.getElementById("warning-message").style.display = "block";
    }
}

function validateForm() {
    var requiredFields = document.querySelectorAll('[required]');
    for (var i = 0; i < requiredFields.length; i++) {
        if (!requiredFields[i].value) {
            if (requiredFields[i].id == "username") {
                document.getElementById("warning-message").innerText = "Please fill yout in username";
            }
            else if (requiredFields[i].id == "email"){
                document.getElementById("warning-message").innerText = "Please fill your in email";
            }
            else if (requiredFields[i].id == "phone"){
                document.getElementById("warning-message").innerText = "Please fill in your phone number";
            }
            else if (requiredFields[i].id == "password" || requiredFields[i].id == "confirm_password"){
                document.getElementById("warning-message").innerText = "Please fill in the matching passwords";
            }
            return false; 
        }
    }
    document.getElementById("warning-message").innerText = "";
    document.getElementById("warning-message").style.display = "none";
    return true; 
}

function checkPasswordStrength() {
    var password = document.getElementById("password").value;
    var strengthIndicator = document.getElementById("password");
    
    var hasNumber = /\d/;
    var hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/;
    var lengthValid = 64 >= password.length && password.length >= 8;
    var hasLowerCase = /[a-z]/;
    var hasUpperCase = /[A-Z]/;

    var numberValid = hasNumber.test(password);
    var specialCharValid = hasSpecialChar.test(password);
    var lowerCaseValid = hasLowerCase.test(password);
    var upperCaseValid = hasUpperCase.test(password);

    var strength = 0;
    if (numberValid) strength++;
    if (specialCharValid) strength++;
    if (lowerCaseValid) strength++;
    if (upperCaseValid) strength++;

    // Update strength indicator (you can customize the messages)
    if (strength === 1 ) {
        strengthIndicator.textContent = "SUPER Weak";
        strengthIndicator.style.color = "red";
        return false;
    } else if (strength === 2) {
        strengthIndicator.textContent = "Weak";
        strengthIndicator.style.color = "#fd6104";
        return false;
    } else if (strength === 3) {
        strengthIndicator.textContent = "Moderate";
        strengthIndicator.style.color = "#ffce03";
        return false;
    } else if (strength === 4 && lengthValid) {
        strengthIndicator.textContent = "Strong";
        strengthIndicator.style.color = "green";
        return true;
    } 
    return false;
}

function checkConfirmPasswordStrength() {
    var password = document.getElementById("confirm_password").value;
    var strengthIndicator = document.getElementById("confirm_password");
    
    // Define password strength rules (you can customize these)

    var hasNumber = /\d/;
    var hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/;
    var lengthValid = 64 >= password.length && password.length >= 8;
    var hasLowerCase = /[a-z]/;
    var hasUpperCase = /[A-Z]/;

    var numberValid = hasNumber.test(password);
    var specialCharValid = hasSpecialChar.test(password);
    var lowerCaseValid = hasLowerCase.test(password);
    var upperCaseValid = hasUpperCase.test(password);

    var strength = 0;
    if (numberValid) strength++;
    if (specialCharValid) strength++;
    if (lowerCaseValid) strength++;
    if (upperCaseValid) strength++;

    // Update strength indicator (you can customize the messages)
    if (strength === 1 ) {
        strengthIndicator.textContent = "SUPER Weak";
        strengthIndicator.style.color = "red";
        return false;
    } else if (strength === 2) {
        strengthIndicator.textContent = "Weak";
        strengthIndicator.style.color = "#fd6104";
        return false;
    } else if (strength === 3) {
        strengthIndicator.textContent = "Moderate";
        strengthIndicator.style.color = "#ffce03";
        return false;
    } else if (strength === 4 && lengthValid) {
        strengthIndicator.textContent = "Strong";
        strengthIndicator.style.color = "green";
        return true;
    } 
    return false;
}