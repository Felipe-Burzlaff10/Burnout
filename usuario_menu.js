function usuario_menu_suspenso()
{
    const usuarioBtn = document.getElementById('usuarioBtn');
    const usuarioDropdown = document.getElementById('usuarioDropdown');

    usuarioBtn.addEventListener('click', function (event) {
        event.stopPropagation();

        const aberto =
            usuarioDropdown.classList.toggle('aberto');

        usuarioBtn.setAttribute('aria-expanded', aberto);
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.usuario-menu')) {
            usuarioDropdown.classList.remove('aberto');

            usuarioBtn.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            usuarioDropdown.classList.remove('aberto');

            usuarioBtn.setAttribute('aria-expanded', 'false');
        }
    });
}
