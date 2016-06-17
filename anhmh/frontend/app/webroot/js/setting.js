/* 
 * Methods for Setting page
 */

/**
 * When DOM ready
 */
$(document).ready(function(){
    // Change setting
    initChangeSettingItem();
});

/**
 * Init action for change setting item
 */
function initChangeSettingItem() {
    $('.stgItemButton a').on('click', function(event){
        event.preventDefault();
        
        var stgItem = $(this).closest('.stgItem');
        if (stgItem.length > 0) {
            // Get current value
            var name = stgItem.attr('data-name');
            var value = stgItem.attr('data-value');
            var text = stgItem.find('.stgItemText').text();
            
            // Init popup
            var dlgSetting = $('#dlgPopupSetting');
            var input = dlgSetting.find('#dlgPopupSettingItem');
            
            dlgSetting.find('.myToggleItemLabel p').text(text);
            input.attr('name', name);
            input.prop('checked', value == 1);
            
            // Show popup
            if(!dlgSetting.is(':visible')) {
                var innerWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                var ie = detectIE();
                var pcZooming = innerWidth < 1000 && innerWidth >= 640;
                var spZooming = innerWidth < 640;
                
                // Set new position when zooming
                if (ie === false) {
                    if (pcZooming) {
                        // PC
                        var left = (1000 - dlgSetting.width()) / 2;
                        dlgSetting.css('marginLeft', '0px');
                        dlgSetting.css('left', left + 'px');
                    } else if (spZooming) {
                        // SP
                        var left = (1000 - dlgSetting.width()) / 2;
                        dlgSetting.css('marginLeft', '0px');
                        dlgSetting.css('left', left + 'px');
                    } else {
                        dlgSetting.css('marginLeft', -(dlgSetting.width() / 2) + 'px');
                        dlgSetting.css('left', '50%');
                    }
                }
                
                // Fix zoom
                if (ie !== false && ie == 9) {
                    var zoomNumber = 1;
                    
                    if (pcZooming) {
                        zoomNumber = $(window).width() / 1000;
                    } else if (spZooming) {
                        zoomNumber = $(window).width() / 1000;
                    }
                    
                    var scale = 'scale(' + zoomNumber + ')';
                    $('.dlgPopoup')
                        .css('-ms-transform', scale)
                        .css('-moz-transform', scale)
                        .css('-o-transform', scale)
                        .css('-webkit-transform', scale)
                        .css('transform', scale);
                }
                
                dlgSetting.fadeIn('fast');
                $("#wrapPanelSetting").fadeIn('slow');
            }
        }
    });
    
    // Close Setting dialog
    $("#wrapPanelSetting, #dlgPopupSettingButtonCancel").on('click', closeDlgSettingItem);
    
    // Save setting
    $('#dlgPopupSettingButtonSave').on('click', saveSettingItem);
}

/**
 * Close Dialog setting item
 */
function closeDlgSettingItem() {
    var dlgSetting = $('#dlgPopupSetting');
    if (dlgSetting.is(':visible')) {
        dlgSetting.fadeOut('fast');
        $("#wrapPanelSetting").fadeOut('slow');
    }
}

/**
 * Save setting item
 */
function saveSettingItem() {
    // Get value
    var dlgSetting = $('#dlgPopupSetting');
    var input = dlgSetting.find('#dlgPopupSettingItem');
    var newValue = input.prop('checked') ? 1 : 0;
    var name = input.attr('name');
    var htmlItem = $(".stgItem[data-name='" + name + "']");
    
    if (htmlItem.length > 0) {
        // Call API
        // TODO show ovelay to block the UI
        $.ajax({
            url: BASE_URL + "/settings/update.json",
            method: "POST",
            cache: false,
            data: {Setting: { name: name, value: newValue }}
        }).done(function(data) {
            if (data.success) {
                // Update value
                htmlItem.attr('data-value', newValue);
            } else {
                // TODO change the way show message
                alert(data.message);
            }
        });
        
    }
    closeDlgSettingItem();

}
