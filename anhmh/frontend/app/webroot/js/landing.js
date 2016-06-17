
// KienNH, 2015/12/03
$(document).ready(function(){
    $('#topMenu a[href*=#], #section1_contact, #moveTop').click(function(event){
        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top
        }, 500,'easeInQuart');
        event.preventDefault();
    });
    
    var contactForm = $("#contact-form");
    var loader = $('#model_loader_wrap');
    
    // Binds form submission and fields to the validation engine
    contactForm.validationEngine();
    
    $('.btnLpSendMail').on('click', function(){
        if (contactForm.validationEngine('validate')) {
            var url = contactForm.attr('action');
            
            loader.show();
            $.post(url, contactForm.serialize(), function (data) {
                loader.hide();
                
                if (data.hasOwnProperty('success') && data.success == 1) {
                    // OK
                    contactForm.find("input[type=text], textarea").val("");
                    window.location.href = BASE_URL + '/thanks';
                } else {
                    // NG
                    if (data.hasOwnProperty('message') && data.message != '') {
                        alert(data.message);
                        try {
                            console.log(data.debug);
                        } catch(e) {}
                    }
                }
            }, 'json');
        }
    });
});
