document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSidebar();
    }
});

function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.style.right = sidebar.style.right === '0%' ? '-30%' : '0%';
}

function closeSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.style.right = '-30%';
}
