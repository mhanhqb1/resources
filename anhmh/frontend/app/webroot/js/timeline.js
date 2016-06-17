/*$(function () { 
    var scrollTop = getCookie('timeline_scrollTop');
    if (scrollTop != '') {
        //$('#articleContainer').scrollTop(scrollTop);
    }
});*/
$('#articleContainer').scroll(function(){       
    //setCookie('timeline_scrollTop', $(this).scrollTop(), 1);
    if ($(this).scrollTop() >= $('#plcListTimeline').height() - $(this).height()) {        
        if (typeof window['pageLoading'] !== undefined && window['pageLoading']) {
            return false;
        }
        if (typeof window['stopLoading'] !== undefined && window['stopLoading']) {
            return false;
        }
        var url = buildUrlPage();
        $.ajax({
            cache: false,
            async: true,
            type: 'get',
            url: url,             
            beforeSend: function() {  
                window['pageLoading'] = true;   
                $('#plcListTimeline').append($('.pageLoading').html());
                return true;
            },
            success: function (response) { 
                if (response) {
                    $('#plcListTimeline').append(response); 
                    history.pushState('', document.title, url);
                } else {
                    window['stopLoading'] = true; 
                }
                window['firstPage'] = 0;
                window['pageLoading'] = false;
                $('#plcListTimeline .pageLoadingInner').remove();  
                initJsAjaxSubmit('#plcListTimeline');
            }
        }); 
    }
});
