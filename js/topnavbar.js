function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.style.right = sidebar.style.right === '0%' ? '-30%' : '0%';
}

function closeSidebar() {
    var sidebar = document.getElementById('sidebar');
    sidebar.style.right = '-30%';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSidebar();
    }
});

    function toggleDropdown() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }

    function toggleSidebarRedirect(){
        window.location.href="../../pages/customer/user_login.php";
    }