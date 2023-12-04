document.addEventListener('DOMContentLoaded', function() {
    var urlParams = new URLSearchParams(window.location.search);
    var email = urlParams.get('email');
    var activationCode = urlParams.get('activation_code');

    var form = document.getElementById('pass-reset-form');
    form.action = 'password_reset.php?email=' + encodeURIComponent(email) + '&activation_code=' + encodeURIComponent(activationCode);
});