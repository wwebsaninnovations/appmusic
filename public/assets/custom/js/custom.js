$(document).ready(function() {

    $('.release-nav-link #v-pills-tab .nav-link').on('click', function() {
        const newUrl = $(this).data('href');
        window.history.pushState({path: newUrl}, '', newUrl);
    });

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

$(document).ready(function() {
    $('#droparea').on('click', function() {
        $('#artworkimage').click();
    });

    $('#artworkimage').on('change', function(event) {
        var files = event.target.files;
        if (files.length > 0) {
            var file = files[0];
            var fileType = file.type;
            var validTypes = ['image/jpeg', 'image/tiff'];
            var imageTypeValid = validTypes.includes(fileType);
            var img = new Image();

            img.onload = function() {
                var width = this.width;
                var height = this.height;

                if (!imageTypeValid) {
                    $('#error-message').text('Invalid file type. Please upload a TIF or JPG image.');
                    resetFileInput();
                    return;
                }

                if (width !== height) {
                    $('#error-message').text('Image must be square.');
                    resetFileInput();
                    return;
                }

                if (width < 300|| width > 6000 || height < 300 || height > 6000) {
                    $('#error-message').text('Image dimensions must be between 3000 x 3000 pixels and 6000 x 6000 pixels.');
                    resetFileInput();
                    return;
                }

                // Hide error message if everything is valid
                $('#error-message').text('');

                // Show progress bar and start animation
                $('.progress').show();
                var progressBar = $('.progress-bar');
                progressBar.css('width', '0%').attr('aria-valuenow', 0);

                var progress = 0;
                var interval = setInterval(function() {
                    progress += 1;
                    progressBar.css('width', progress + '%').attr('aria-valuenow', progress);
                    if (progress >= 100) {
                        clearInterval(interval);
                        $('.progress').hide();

                        // Display the image preview
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#image-preview').html('<img src="' + e.target.result + '" alt="Artwork Preview">');
                        };
                        reader.readAsDataURL(file);
                    }
                }, 20); // 20ms interval for 2 seconds to 100%
                
                $('#image-info').text('Selected file: ' + file.name);
            };

            img.onerror = function() {
                $('#error-message').text('Invalid image file.');
                resetFileInput();
            };

            img.src = URL.createObjectURL(file);
        } else {
            resetFileInput();
        }
    });

    $('#droparea').on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('hover');
    });

    $('#droparea').on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('hover');
    });

    $('#droparea').on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('hover');

        var files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $('#artworkimage')[0].files = files;
            $('#artworkimage').trigger('change');
        }
    });

    function resetFileInput() {
        $('#artworkimage').val('');
        $('#image-info').text('');
        $('#image-preview').html('');
        $('.progress').hide();
    }
});



