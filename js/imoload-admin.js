/* Admin side script */
jQuery(function($) {
    var pageId = document.getElementById('imoload-options');
    var instructionsTitle = pageId.getElementsByClassName('imoload-instructions');
    var instructionsList = pageId.getElementsByTagName('ol');
    var collapsibleTrigger = pageId.getElementsByClassName('imoload-collapsible');
    var collapsibleElement = document.getElementById('imoload-loading').getElementsByClassName('form-table');
    var info = pageId.getElementsByClassName('imoload-info');
    var logoButtons = pageId.getElementsByClassName('imoload-logo-button');
    var logoImage = pageId.getElementsByClassName('imoload-preview-image');
    var $optionsMeta = imoloadPhp.imoload_numbers_field;
    var i;

    instructionsList[0].style.display = "none";

    instructionsTitle[0].addEventListener("click", function() {

        this.classList.toggle("active");

        if (instructionsList[0].style.display === "none") {
            $('.imoload-instructions + ol').slideDown();
        } else {
            $('.imoload-instructions + ol').slideUp();
        }
    });
    
    if ($optionsMeta == 3) {
        $('.imoload-collapsible.WholeWebsite').css('display', 'none');
    }

    for (i = 0; i < collapsibleTrigger.length; i++) {

        collapsibleElement[i].style.display = "none";

        if ($(logoImage[i]).hasClass('default')) { // if default image
            info[i].innerHTML = imoloadLogo.empty;
        } else {
            info[i].innerHTML = imoloadLogo.selected;
        }

        collapsibleTrigger[i].addEventListener("click", function() {
            this.classList.toggle("active");
            // The same as collapsibleElement
            var content = this.parentNode.nextElementSibling;
            var jqContent = $(content);
            if (content.style.display === "none") {
                jqContent.slideDown();
            } else {
                jqContent.slideUp();
            }
        });

        // Loading image selection
        logoButtons[i].addEventListener("click", function(e) {
            e.preventDefault();
            var hiddenInput = this.previousElementSibling;
            var logoImage = hiddenInput.previousElementSibling;
            jQinput = $(hiddenInput);
            jQimage = $(logoImage);
            var image_frame;

            // Define image_frame as wp.media object
            image_frame = wp.media({
                title: 'Select Media',
                multiple : false,
                library : {
                    type : 'image',
                }
            });

            image_frame.on('close', function() {
                // On close, get selections and save to the hidden input
                // plus other AJAX stuff to refresh the image preview
                var selection = image_frame.state().get('selection');
                var gallery_ids = new Array();
                var my_index = 0;
                selection.each(function(attachment) {
                    gallery_ids[my_index] = attachment['id'];
                    my_index++;
                });
                var ids = gallery_ids.join(",");
                jQinput.val(ids);
                Refresh_Image(ids);
            });

            image_frame.on('open', function() {
                // On open, get the id from the hidden input
                // and select the appropiate images in the media manager
                var selection = image_frame.state().get('selection');
                var ids = jQinput.val().split(',');
                ids.forEach(function(id) {
                    var attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add( attachment ? [ attachment ] : [] );
                });
            });

            // When an image is selected in the media frame...
            image_frame.on('select', function() {
                // Get media attachment details from the frame state
                var selection = image_frame.state().get('selection').first().toJSON();
                // And preview it
                jQimage.attr('src', selection.url).css({'width': selection.width,
                                                        'max-width': '300px',
                                                        'height': 'auto',
                                                        'background-color': 'transparent'});
            });

            if (image_frame) {
                image_frame.open();
            }
        });
    }

    // Ajax request to refresh the image preview
    function Refresh_Image(the_id){
        var data = {
            action: 'imoload_get_image',
            id: the_id
        };

        jQuery.get(ajaxurl, data, function(response) {

            if(response.success === true) {
                jQimage.replaceWith(response.data.image);
            }
        });
    }

    // Save plugin options by AJAX
    function save_imoload_ajax(button, notice, reload) {
        $(button).submit( function () {
            var input =  $(this).serialize();
            $.post( 'options.php', input )
                .error( 
                function() {
                    $(notice).addClass('notice-error').html('<span>An error occured. Not saved!</span>').css('display', 'block');
                    setTimeout(function() {
                        $(notice).css('display', 'none');
                    }, 2000);
                })
                .success( function() {
                if (reload == true) {
                    window.location.reload(true);
                } else if (reload == false) {
                    //don't reload
                }
                $(notice).addClass('notice-success is-dismissible').html('<span>Saved succesfully!</span>').css('display', 'block');
                setTimeout(function() {
                        $(notice).css('display', 'none');
                    }, 2000);
            });
            return false;    
        });
    }
    save_imoload_ajax('#imoload-meta', '.meta-notice', true);
    save_imoload_ajax('#imoload-loading', '.loading-notice', false);

});
