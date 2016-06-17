$(function () { 
    var scrollTop = getCookie('notice_scrollTop');
    if (scrollTop != '') {
        $('#articleContainer').scrollTop(scrollTop);
    }
});
$('#articleContainer').scroll(function(){       
    setCookie('notice_scrollTop', $(this).scrollTop(), 1);
    if ($(this).scrollTop() >= $('#ntcContainer').height() - $(this).height()) {        
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
                $('#ntcContainer').append($('.pageLoading').html());
                return true;
            },
            success: function (response) { 
                if (response) {
                    $('#ntcContainer').append(response); 
                    history.pushState('', document.title, url);
                } else {
                    window['stopLoading'] = true; 
                }
                window['firstPage'] = 0;
                window['pageLoading'] = false;
                $('#ntcContainer .pageLoadingInner').remove();  
                initJsAjaxSubmit('#ntcContainer');
            }
        }); 
    }
});