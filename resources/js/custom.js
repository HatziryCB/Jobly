document.addEventListener('DOMContentLoaded', () => {
    const card = document.getElementById('portalCard');
    if (!card) return;
    const toRegister = document.getElementById('toRegister');
    const toLogin = document.getElementById('toLogin');
    console.log("Custom JS cargado");
    const goRegister = () => {
        card.classList.add('is-register');                 // <- mueve panel a la derecha
        setTimeout(()=> document.querySelector('.pane-register input')?.focus(), 150);
    };
    const goLogin = () => {
        card.classList.remove('is-register');              // <- panel regresa a la izquierda
        setTimeout(()=> document.getElementById('login_email')?.focus(), 150);
    };

    if (location.hash === '#register') goRegister();
    toRegister?.addEventListener('click', goRegister);
    toLogin?.addEventListener('click', goLogin);

    });
