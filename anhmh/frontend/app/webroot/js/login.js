/**
 * Functions for login page
 */

$(document).ready(function(){
    // Set custom select picker
    $('.lgiCustomSelectbox').each(function(){
        $(this).selectpicker({
            showIcon: false,
            showContent: false
        });
    });
    
    // Select physical type
    $('#lgiRegisterSelectPhysicalType').on('click', function(){
        // Init
        var wrapPanelRegisterInfo = $('#wrapPanelRegisterInfo');
        var physicalTypePopup = $('#dlgPopupSelectPhysicalType');
        var valueId = $('#lgiRegisterSelectPhysicalTypeValue');
        var text = $('#lgiRegisterSelectPhysicalTypeText');
        
        // Set active item
        $('.dlgPopupSelectPhysicalTypeItem').each(function(){
            var dataId = $(this).attr('data-id');
            
            $(this).removeClass('on');
            if (dataId == valueId.val()) {
                $(this).addClass('on');
                console.log('dataId: ' + dataId);
                console.log('valueId.val(): ' + valueId.val());
            }
        });
        
        // Show popup
        wrapPanelRegisterInfo.fadeIn('fast');
        physicalTypePopup.fadeIn('fast');
        
        // Bind event click on wrap to hide menu
        $('#dlgPopupSelectPhysicalTypeClose, #wrapPanelRegisterInfo').on('click', function(){
            wrapPanelRegisterInfo.fadeOut('fast');
            physicalTypePopup.fadeOut('fast');
        });
        
        // Select physical type
        $('.dlgPopupSelectPhysicalTypeItem').on('click', function(){
            var dataId = $(this).attr('data-id');
            var dataText = $(this).find('.dlgPopupSelectPhysicalTypeItemName').text().trim();
            
            valueId.val(dataId);
            text.text(dataText);
            $('#lgiRegisterSelectPhysicalTypeImage').attr('data-id', dataId).removeClass('nonPhysicalTypeId');
            
            wrapPanelRegisterInfo.fadeOut('fast');
            physicalTypePopup.fadeOut('fast');
        });
    });
});
