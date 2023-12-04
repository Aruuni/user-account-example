function onSubmit(event) {
    document.getElementById("login-form").submit();
}
var onloadCallback = function() {
    grecaptcha.render('submit', {
      'sitekey' : '6LeeNCEpAAAAACjAcEUxAEKzRPGkN4Odwveq8Fh_',
      'callback' : onSubmit
    });
  };

