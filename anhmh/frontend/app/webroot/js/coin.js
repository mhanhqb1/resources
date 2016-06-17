
$('#articleContainer').scroll(function(){
    if ($(this).scrollTop() >= $('#coin_history_data').height() - $(this).height()) {
        if (typeof window['pageLoading'] !== undefined && window['pageLoading']) {
            return false;
        }
        if (typeof window['stopLoading'] !== undefined && window['stopLoading']) {
            return false;
        }
        
        if ($('#coin_history_data_empty').length > 0) {
            return false;
        }
        
        // Get new url with next page
        var url = window.location.href;
        var page = fnGetRequestParam('page');
        
        if (page === null) {
            if (url.indexOf("?") > 0) {
                url = url + '&page=2';
            } else {
                url = url + '?page=2';
            }
        } else if (page === '') {
            url = url.replace("page=", "page=2");
        } else {
            url = url.replace("page=" + page, "page=" + (parseInt(page, 10) + 1));
        }
        
        // Get next page data
        $.ajax({
            cache: false,
            async: true,
            type: 'get',
            url: url,
            beforeSend: function() {
                window['pageLoading'] = true;
                $('#coin_history_data').append($('.pageLoading').html());
                return true;
            },
            success: function (response) {
                if (response) {
                    $('#coin_history_data').append(response);
                    history.pushState('', document.title, url);
                } else {
                    window['stopLoading'] = true;
                }
                window['firstPage'] = 0;
                window['pageLoading'] = false;
                $('#coin_history_data .pageLoadingInner').remove();
            }
        }); 
    }
});
