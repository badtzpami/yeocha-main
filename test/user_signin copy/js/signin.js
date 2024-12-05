// Toggle password visibility
var password = document.getElementById('Password');
var toggler = document.getElementById('toggler');
showHidePassword = () => {
    if (password.type == 'password') {
        password.setAttribute('type', 'text');
        toggler.classList.add('fa-eye-slash');
    } else {
        toggler.classList.remove('fa-eye-slash');
        password.setAttribute('type', 'password');
    }
};

toggler.addEventListener('click', showHidePassword);
