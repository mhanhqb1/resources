
var intervalWindowResize;

// Fix height when page load
$(document).ready(function(){
    fitHeight();
});

$(window).on('load', function(){
    fitHeight();
});

// Fix height when resize
$(window).on('resize', function () {
    clearTimeout(intervalWindowResize);
    intervalWindowResize = setTimeout(function(){
        fitHeight();
    }, 250);
});

/**
 * Calculate and set zoom/scale value
 */
function fitHeight() {
    // Exclude some view
    if ($('.body_login_active, .body_users_register').length > 0) {
        return;
    }
    
    setZoom(1);
    
    var viewportHeight = $(window).height();
    var heightScroll = $('#app_page_container').outerHeight();
    var zoomNumber = 1;
    
    if (heightScroll > viewportHeight) {
        zoomNumber = viewportHeight / heightScroll;
    }
    
    setZoom(zoomNumber);
}

/**
 * Set zoom/scale value for body element
 * @param {int} zoomNumber
 */
function setZoom(zoomNumber) {
    // if (Modernizr.testProp('zoom') === true) 
    //     $('html#app_page body').css('zoom', zoomNumber);
    // else
    var scale = 'scale(' + zoomNumber + ')';
    var item = 'html#app_page';
    
    if ($('#dlgPopupLoginRule').length > 0) {
        var ieVersion = detectIE();
        if (ieVersion) {
            item += ', #dlgPopupLoginRule';
        }
    }
    
    $(item)
            .css('-ms-transform', scale)
            .css('-moz-transform', scale)
            .css('-o-transform', scale)
            .css('-webkit-transform', scale)
            .css('transform', scale);
}
