import 'preline';

window.togglePasswordVisibility = function (inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    const openIcon = btn.querySelector('.eye-open');
    const closedIcon = btn.querySelector('.eye-closed');
    if (openIcon && closedIcon) {
        if (isPassword) {
            openIcon.classList.add('hidden');
            closedIcon.classList.remove('hidden');
        } else {
            openIcon.classList.remove('hidden');
            closedIcon.classList.add('hidden');
        }
    }
};
