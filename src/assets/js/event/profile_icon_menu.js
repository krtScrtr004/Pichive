const profile_icon_menu = document.querySelector('.profile-icon-menu');

profile_icon_menu.onclick = () => {
    const drop_down = document.querySelector('.profile-icon-menu>.drop-down')

    if (drop_down.style.display === 'none') {
        drop_down.style.display = 'flex'
    } else {
        drop_down.style.display = 'none'
    }
}