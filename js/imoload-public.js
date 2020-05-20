/* Front-end script */
jQuery(function($) {
    // CSS styles
    var CSS = document.createElement('style');
    CSS.innerHTML = 'body {opacity: 0;} .imoload-overlay {position: fixed; z-index: 99999; top: 0; left: 0; bottom: 0; right: 0; -webkit-transition: 1s 0.4s; transition: 1s 0.4s; opacity: 1; display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-orient: vertical; -webkit-box-direction: normal; -ms-flex-direction: column; flex-direction: column; -webkit-box-align: center; -ms-flex-align: center; align-items: center; -webkit-box-pack: center; -ms-flex-pack: center; justify-content: center;} .imoload-logo-container {text-align: center;} .imoload-logo-container img {max-width: 100%; height: auto;margin: 0 auto;} .imoload-progstat {position: absolute; top: 85%; left: 0; width: 100%; font-size: 32px; letter-spacing: 3px; text-align: center;} .imoload-progress {position: absolute; top: 95%; left: 0; height: 10px; width: 0;}';
    var head = document.getElementsByTagName('head')[0];
    head.appendChild(CSS);
    // Stage the loading elements
    var overlay = document.createElement('div');
    var imgContainer = document.createElement('div');
    var progstat = document.createElement('div');
    var progress = document.createElement('div');
    var image = document.createElement('img');
    overlay.className = 'imoload-overlay';
    imgContainer.className = 'imoload-logo-container no-cache';
    progstat.className = 'imoload-progstat';
    progress.className = 'imoload-progress';
    image.className = 'imoload-atleast-one-image';
    overlay.appendChild(imgContainer);
    overlay.appendChild(progstat);
    overlay.appendChild(progress);
    imageNumber = document.images;

    var bodyElement = document.getElementsByTagName('body')[0];
    if (typeof(bodyElement) != 'undefined' && bodyElement != null)
    {
        bodyElement.insertBefore(overlay, bodyElement.firstChild);
        if (imageNumber.length < 1) {
            bodyElement.appendChild(image);
        }
    }
    // Array item based on $nameArray
    var $imoloadPhp = imoloadPhp;
    var $BackgroundColor = '#' + $imoloadPhp.imoload_background_color;
    var $TextColor = '#' + $imoloadPhp.imoload_text_color;
    $('.imoload-overlay').css('background-color', $BackgroundColor);
    $('.imoload-progstat').css('color', $TextColor);
    $('.imoload-progress').css('background', $TextColor);
    // Ajax call
    function getImage(the_id){
        var data = {
            action: 'imoload_get_image',
            id: the_id
        };

        jQuery.get(the_ajax_script.ajaxurl, data, function(response) {

            if(response.success === true) {
                imgContainer.innerHTML = response.data.image;
            }
            else {
                console.log('Ajax failed');
            }
        });
    }
    getImage($imoloadPhp.imoload_logo);

});
// Loading progress screen with percentage and bar
jQuery(function($) {
    function imoloadClass(el){ return document.getElementsByClassName(el)[0]; }
    function loadbar() {
        var bodyElement = document.getElementsByTagName('body')[0],
            overlay = imoloadClass('imoload-overlay'),
            progress = imoloadClass('imoload-progress'),
            progstat = imoloadClass('imoload-progstat'),
            img = document.images,
            start = 0,
            total = img.length;

        if(total == 0) return doneLoading();

        function imgLoaded(){
            start += 1;
            var percentage = ((100/total*start) << 0) +"%";
            setTimeout(function() { 
                progress.style.width = percentage;
                progstat.innerHTML = percentage;
                if(start===total) return doneLoading();
            }, 500);
        }
        function doneLoading(){
            bodyElement.style.opacity = 1;
            overlay.style.opacity = 0;
            setTimeout(function(){ 
                overlay.style.display = "none";
            }, 1200);
        }
        for(var i=0; i<total; i++) {
            var tImg     = new Image();
            tImg.onload  = imgLoaded;
            tImg.onerror = imgLoaded;
            tImg.src     = img[i].src;
        }    
    }
    document.addEventListener('DOMContentLoaded', loadbar, false);

}());