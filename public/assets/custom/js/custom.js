$(document).ready(function() {

$('.release-nav-link #v-pills-tab .nav-link').on('click', function() {
    const newUrl = $(this).data('href');
    window.history.pushState({path: newUrl}, '', newUrl);
});

$('.apply_click').click(function(){
    
    jQuery(this).html("Apply All <b> ✓ </b>");

    let copyValue =  $(this).next().val();
    let input_attr = $(this).next().attr('data-name');
    $('.input-'+input_attr).val(copyValue);

});



$('.apply_radio_click').click(function() {
    var container = $(this).closest('.wrap-field'); 
    var closestRadio = container.find('.input-explicit:checked'); 
    if (closestRadio.length > 0) {
        jQuery(this).html("Apply Now <b> ✓ </b>");
        var value = closestRadio.val();
        $('.input-explicit').prop("checked", false);
        $('input[type="radio"][value="' + value + '"]').prop("checked", true); 
    }
});


jQuery(document).on("change", '.input-explicit', function(){
    console.log("***")
    jQuery(this).closest('.wrap-field').find('.apply_radio_click').html("Apply Now");

});

var changeHandler = function(){
    console.log("***");
    jQuery(this).closest('.wrap-field').find('.apply_select_click').html("Apply Now");
};

$(document).on("change", '.input-ownership_for_sound_rec', changeHandler);

$('.apply_select_click').click(function() {
    var container = $(this).closest('.wrap-field');
    $(this).html("Apply Now <b> ✓ </b>");
    var selects = container.find('.input-ownership_for_sound_rec');
    var all_selects = $('.input-ownership_for_sound_rec');

    if (selects.length > 0) {
        var value = selects.val();
        if (value !== "") {
            $(document).off("change", '.input-ownership_for_sound_rec', changeHandler); // Unbind change handler
            all_selects.each(function() {
                $(this).val(value).change();
            });
            $(document).on("change", '.input-ownership_for_sound_rec', changeHandler); // Rebind change handler
        }
    }
});

    $(document).on("change", '.input-country_of_rec', changeHandler);

    $('.apply_select_click').click(function() {
        var container = $(this).closest('.wrap-field');
        $(this).html("Apply Now <b> ✓ </b>");
        var selects = container.find('.input-country_of_rec');
        var all_selects = $('.input-country_of_rec');

        if (selects.length > 0) {
            var value = selects.val();
            if (value !== "") {
                $(document).off("change", '.input-country_of_rec', changeHandler); // Unbind change handler
                all_selects.each(function() {
                    $(this).val(value).change();
                });
                $(document).on("change", '.input-country_of_rec', changeHandler); // Rebind change handler
            }
        }
    });

    $(document).on("change", '.input-nationality', changeHandler);

    $('.apply_select_click').click(function() {
        var container = $(this).closest('.wrap-field');
        $(this).html("Apply Now <b> ✓ </b>");
        var selects = container.find('.input-nationality');
        var all_selects = $('.input-nationality');

        if (selects.length > 0) {
            var value = selects.val();
            if (value !== "") {
                $(document).off("change", '.input-nationality', changeHandler); // Unbind change handler
                all_selects.each(function() {
                    $(this).val(value).change();
                });
                $(document).on("change", '.input-nationality', changeHandler); // Rebind change handler
            }
        }
    });

    $(document).on("change", '.input-lyrics_language', changeHandler);

    $('.apply_select_click').click(function() {
        var container = $(this).closest('.wrap-field');
        $(this).html("Apply Now <b> ✓ </b>");
        var selects = container.find('.input-lyrics_language');
        var all_selects = $('.input-lyrics_language');

        if (selects.length > 0) {
            var value = selects.val();
            if (value !== "") {
                $(document).off("change", '.input-lyrics_language', changeHandler); // Unbind change handler
                all_selects.each(function() {
                    $(this).val(value).change();
                });
                $(document).on("change", '.input-lyrics_language', changeHandler); // Rebind change handler
            }
        }
    });

    $('.apply_checkbox_click').click(function() {
        var container = $(this).closest('.wrap-field'); 
        var checkbox  = container.find('.input-primary_performers:checked');
        jQuery(this).html("Apply Now <b> ✓ </b>");
        if(checkbox.length > 0) {
    
            jQuery(this).closest('.wrap-field').find('.apply_radio_click').html("Apply Now");
            $('.input-primary_performers').prop("checked", true); 
        }else{
            $('.input-primary_performers').prop("checked", false); 
        }
    });
});


jQuery(document).on("change", '.input-primary_performers', function(){
    console.log("***")
    jQuery(this).closest('.wrap-field').find('.apply_checkbox_click').html("Apply Now");

});

document.addEventListener('DOMContentLoaded', function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('original_release_date').setAttribute('max', today);
    document.getElementById('sales_date').setAttribute('min', today);
});

$(document).ready(function() {
    $('#toggle-select').click(function() {
        let allChecked = true;
        $('._platforms .form-check-input').each(function() {
            if (!$(this).is(':checked')) {
                allChecked = false;
            }
        });

        if (allChecked) {
            $('._platforms .form-check-input').prop('checked', false);
            $('#toggle-select').text('Select All');
        } else {
            $('._platforms .form-check-input').prop('checked', true);
            $('#toggle-select').text('Deselect All');
        }
    });
});




$(document).ready(function() {
    $('.nav-link').on('click', function(event) {
        event.preventDefault(); // Prevent default action of the anchor tag
        $('.nav-link').removeClass('active'); // Remove 'active' class from all nav links
        $(this).addClass('active'); // Add 'active' class to the clicked nav link
    });
});


$(document).ready(function() {
    $('#list').click(function(event) {
        event.preventDefault();
        $('#products .item').removeClass('grid-group-item').addClass('list-group-item');
    });

    $('#grid').click(function(event) {
        event.preventDefault();
        $('#products .item').removeClass('list-group-item').addClass('grid-group-item');
    });
});

$(document).ready(function() {
    $('.list-pills-tab a').on('click', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });
});


$(document).ready(function() {
    $('.dropdown-button').on('click', function() {
        $('.dropdown-menu').toggle(); // Toggle the visibility of the dropdown menu
    });

    // Optional: Close the dropdown if clicking outside of it
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.dropdown-button, .dropdown-menu').length) {
            $('.dropdown-menu').hide(); // Hide the dropdown if the click is outside
        }
    });
});


$(document).ready(function() {
    $('#rejectButton').on('click', function() {
        $('#rejectModal').modal('show');
    });

    $('#rejectForm').on('submit', function(event) {
        event.preventDefault();
        
        // Set the status to "2" for rejection
        $('#statusField').val('2');
        
        // Get the reason and set it in the hidden input field
        $('#reasonField').val($('#reason').val());

        // Submit the main form
        $('#mainForm').submit();
    });
});
$(document).ready(function() {
    $('#approveButton').on('click', function() {
        // Set the status to "3" for approval
        $('<input>').attr({
            type: 'hidden',
            name: 'status',
            value: '3'
        }).appendTo('form');

        // Trigger form submission
        $('form').submit();
    });
});
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});

$(document).ready(function() {
    // Trigger file input click when "Upload Profile" is clicked
    $('#triggerUpload').on('click', function() {
        $('#upload').click();
    });

    // Display the file name when a file is selected
    $('#upload').on('change', function() {
        var fileName = $(this)[0].files[0].name;
        $('#filename').text(fileName);
    });
});