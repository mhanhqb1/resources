
$(document).ready(function(){
    $('#btnGuestFacebook, #btnGuestTwitter, #btnGuestEmail,\n\
        #lgiTopbtnFacebook, #lgiTopbtnTwitter, #lgiTopbtnEmail').on('click', function(){
        // Hide popup guest
        if ($('#dlgPopupGuestCancel').length > 0) {
            $('#dlgPopupGuestCancel').click();
        }
        
        // Init
        var _action = $(this).attr('data-action');
        var _actionType = $(this).attr('data-action-type');
        
        var wrapPanelLogin = $('#wrapPanelLogin');
        var dlgPopupLoginRule = $('#dlgPopupLoginRule');
        var dlgPopupLoginRuleBtn = $('#dlgPopupLoginRuleBtn');
        
        // Set action
        dlgPopupLoginRuleBtn.attr('data-action', _action);
        dlgPopupLoginRuleBtn.attr('data-action-type', _actionType);
        
        // Show popup
        if (typeof(scalePopup) === 'function') {
            scalePopup(dlgPopupLoginRule);
        }
        
        wrapPanelLogin.fadeIn('fast');
        dlgPopupLoginRule.fadeIn('fast');
        
        // Bind event click on wrap to hide popup
        wrapPanelLogin.unbind('click').bind('click', function () {
            // Hide popup
            wrapPanelLogin.fadeOut('fast');
            dlgPopupLoginRule.fadeOut('fast');
        });
        
        // Bind event click on wrap to go action
        dlgPopupLoginRuleBtn.unbind('click').bind('click', function () {
            var action = $(this).attr('data-action');
            var actionType = $(this).attr('data-action-type');
            
            // Hide popup
            wrapPanelLogin.hide();
            dlgPopupLoginRule.hide();
            
            if (action && actionType) {
                if (actionType == 'url') {
                    window.location.href = action;
                } else if (actionType == 'function') {
                    var myFunc = window[action];
                    myFunc();
                }
            }
        });
    });
});

var actionLoginFacebook = function(){
    // fix for chrome on iOS
    if (navigator.userAgent.match('CriOS')) {
        window.open('https://www.facebook.com/dialog/oauth?client_id=' + fb_app_id + '&redirect_uri=' + document.location.href + '&scope=email,public_profile&response_type=token', '', null);
        return false;
    }
    FB.login(function (response) {
        if (response.authResponse) {
            var fields = 'fields=id,email,birthday,first_name,gender,last_name,link,locale,name,timezone,updated_time,verified';
            FB.api('/me?' + fields, function (response) {
                var params = response;
                var url = BASE_URL + '/login/facebook';
                $.ajax({
                    cache: false,
                    async: true,
                    data: params,
                    url: url,
                    success: function (json) {
                        var result = jQuery.parseJSON(json);
                        if (result.error !== 0) {
                            alert(result.message);
                        } else {
                            location.href = BASE_URL + '/top';
                        }
                    }
                });
            });
        } else {
            // User cancelled
        }
    }, {scope: 'email,user_likes,user_birthday'});
    return false;
};
