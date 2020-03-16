/* Custom homepage front-end script */
// Stage the loading elements
jQuery(function($) {
    var overlay = document.createElement('div');
    var imgContainer = document.createElement('div');
    var progstat = document.createElement('div');
    var progress = document.createElement('div');
    var image = document.createElement('img');
    overlay.className = 'imoload-overlay';
    imgContainer.className = 'imoload-logo-container';
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
    var $imoloadPhp = imoloadPhp[1];
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
            ovrl = imoloadClass('imoload-overlay'),
            prog = imoloadClass('imoload-progress'),
            stat = imoloadClass('imoload-progstat'),
            img = document.images,
            c = 0,
            tot = img.length;

        if(tot == 0) return doneLoading();

        function imgLoaded(){
            c += 1;
            var perc = ((100/tot*c) << 0) +"%";
            prog.style.width = perc;
            stat.innerHTML = perc;
            if(c===tot) return doneLoading();
        }
        function doneLoading(){
            bodyElement.style.opacity = 1;
            ovrl.style.opacity = 0;
            setTimeout(function(){ 
                ovrl.style.display = "none";
            }, 1200);
        }
        for(var i=0; i<tot; i++) {
            var tImg     = new Image();
            tImg.onload  = imgLoaded;
            tImg.onerror = imgLoaded;
            tImg.src     = img[i].src;
        }    
    }
    document.addEventListener('DOMContentLoaded', loadbar, false);

}());