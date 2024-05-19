$(document).ready(function() {

    // function changeTheme(darkMode) {
    //     if (darkMode) {
    //         $('html').addClass('dark-style');
    //         $('.template-customizer-core-css').attr('href', 'http://127.0.0.1:8000/assets/vendor/css/rtl/core-dark.css');
    //         $('.template-customizer-theme-css').attr('href', 'http://127.0.0.1:8000/assets/vendor/css/rtl/theme-default-dark.css');
    //         $('.style-switcher-toggle i').removeClass('bx-moon').addClass('bx-sun');
    //         document.cookie = "theme=dark;path=/";
    //     } else {
    //         $('html').removeClass('dark-style');
    //         $('.template-customizer-core-css').attr('href', 'http://127.0.0.1:8000/assets/vendor/css/rtl/core.css'); 
    //         $('.template-customizer-theme-css').attr('href', 'http://127.0.0.1:8000/assets/vendor/css/rtl/theme-default.css'); 
    //         $('.style-switcher-toggle i').removeClass('bx-sun').addClass('bx-moon');
    //         document.cookie = "theme=light;path=/";
    //     }
    // }
    // var theme = document.cookie.replace(/(?:(?:^|.*;\s*)theme\s*\=\s*([^;]*).*$)|^.*$/, "$1");
    // if (theme === 'dark') {
    //     changeTheme(true);
    // } else {
    //     changeTheme(false);
    // }
    // $('.style-switcher-toggle').click(function() {
    //     var isDarkMode = $('html').hasClass('dark-style');
    //     changeTheme(!isDarkMode);
    // });

   $('.apply_click').click(function(){
        
        let copyValue =  $(this).next().val();
        let input_attr = $(this).next().attr('data-name');
        $('.input-'+input_attr).val(copyValue);

   });


$('.apply_radio_click').click(function() {
     var container = $(this).closest('.wrap-field'); 
     var closestRadio = container.find('.input-explicit:checked'); 
     if (closestRadio.length > 0) {
          var value = closestRadio.val();
          $('.input-explicit').prop("checked", false);
          $('input[type="radio"][value="' + value + '"]').prop("checked", true); 
      }

 });

 $('.apply_select_click').click(function() {
     var container = $(this).closest('.wrap-field'); 
     var selects = container.find('.input-ownership_for_sound_rec'); 
     var all_selects = $('.input-ownership_for_sound_rec'); 
     if (selects.length > 0) {
         var value = selects.val();
         if (value !== "") {
             all_selects.each(function() {
                 $(this).val("").change(); 
                 $(this).val(value).change(); 
             });
         }
     } 
 });

 $('.apply_checkbox_click').click(function() {
    var container = $(this).closest('.wrap-field'); 
    var checkbox = container.find('.input-primary_performers:checked');
    if(checkbox.length > 0) {
        $('.input-primary_performers').prop("checked", true); 
    }else{
        $('.input-primary_performers').prop("checked", false); 
    }
    
 });

 


});



