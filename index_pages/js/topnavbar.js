function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.style.right = sidebar.style.right === '0%' ? '-20%' : '0%';
}

function closeSidebar() {
    var sidebar = document.getElementsByClassName('close-button');
    sidebar.style.right = '-20%';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSidebar();
    }
});