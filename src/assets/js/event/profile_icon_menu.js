const profile_icon_menu = document.querySelector('.profile-icon-menu');
const drop_down = document.querySelector('.profile-icon-menu > .drop-down');

// Toggle visibility of dropdown menu
profile_icon_menu.onclick = (e) => {
    e.stopPropagation();
    if (drop_down.style.display === 'flex') {
        drop_down.style.display = 'none';
    } else {
        drop_down.style.display = 'flex';
    }
};

profile_icon_menu.onmouseover = (e) => {
    e.stopPropagation();
    drop_down.style.display = 'flex';
}

window.onclick = () => {
    if (drop_down.style.display === 'flex') {
        drop_down.style.display = 'none';
    }
};
