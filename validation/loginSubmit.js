function onSubmit(event) {
    //event.preventDefault(); // Prevent the form from submitting automatically
    
    // Check if all required fields are filled
    if (validateForm()) {
        document.getElementById("login-form").submit();
    } else {
        // Display the warning message
        document.getElementById("warning-message").style.display = "block";
    }
}
var onloadCallback = function() {
    grecaptcha.render('submit', {
      'sitekey' : '6LeeNCEpAAAAACjAcEUxAEKzRPGkN4Odwveq8Fh_',
      'callback' : onSubmit
    });
  };

function validateForm() {
    var requiredFields = document.querySelectorAll('[required]');
    
    for (var i = 0; i < requiredFields.length; i++) {
        if (!requiredFields[i].value) {
            if (requiredFields[i].id == "username") {
                document.getElementById("warning-message").innerText = "Please fill in username";
            }
            else if (requiredFields[i].id == "password"){
                document.getElementById("warning-message").innerText = "Please fill in password";
            }
            return false; 
        }
    }
    document.getElementById("warning-message").innerText = "";
    document.getElementById("warning-message").style.display = "none";
    return true; // All required fields are filled
}