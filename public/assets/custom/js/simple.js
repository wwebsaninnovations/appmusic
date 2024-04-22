
$(document).ready(function() {
    function changeTheme(darkMode) {
        if (darkMode) {
            $('html').addClass('dark-style');
            $('.template-customizer-core-css').attr('href', 'http://127.0.0.1:8000/assets/vendor/css/rtl/core-dark.css');
            $('.template-customizer-theme-css').attr('href', 'http://127.0.0.1:8000/assets/vendor/css/rtl/theme-default-dark.css');
            $('.style-switcher-toggle i').removeClass('bx-moon').addClass('bx-sun');
            document.cookie = "theme=dark;path=/";
        } else {
            $('html').removeClass('dark-style');
            $('.template-customizer-core-css').attr('href', '#'); 
            $('.template-customizer-theme-css').attr('href', '#'); 
            $('.style-switcher-toggle i').removeClass('bx-sun').addClass('bx-moon');
            document.cookie = "theme=light;path=/";
        }
    }
    var theme = document.cookie.replace(/(?:(?:^|.*;\s*)theme\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    if (theme === 'dark') {
        changeTheme(true);
    } else {
        changeTheme(false);
    }
    $('.style-switcher-toggle').click(function() {
        var isDarkMode = $('html').hasClass('dark-style');
        changeTheme(!isDarkMode);
    });
});


