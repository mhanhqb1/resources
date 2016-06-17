/* 
 * Global variable and function
 */

var speedMenu = 250;
var speedMenuClose = 100;
var speedSpot = 200;
var speedSpotExt = 100;
var ajaxSpotSearch = null, ajaxLeftRanking = null, ajaxLeftRecommentSpot = null, ajaxLoadSpotDetail = null, ajaxLeftUserRanking = null;
var intervalWindowResize;
var speedRanking = 200;
//var facilityDefault = 'count_wheelchair_wc,count_elevator,count_wheelchair_parking,count_ostomate_wc';
var facilityDefault = '';
//var physicalTypeDefault = '1,2,3,4';
var physicalTypeDefault = '';
var facilityCurrent = facilityDefault, physicalTypeCurrent = physicalTypeDefault;
var cookieLatitude = 'Latitude';
var cookieLongitude = 'Longitude';
var defaultLatitude = 35.681391;// Tokyo station
var defaultLongitude = 139.766122;
var shareDetail = 0;
var sideLeftHide = '-400px';
var sideLeftShow = '0px';
var LAST_PAGE = 'ALL';
var need_remove_hash = false;

var SIDEVIEW_TYPE = {
    SPOT_RECOMMEND: 1,
    SPOT_RANKING: 2,
    SPOT_SEARCH_KEYWORD: 3,
    SPOT_SEARCH_ADVANCE: 31,
    SPOT_SEARCH_CATEGORY: 32,
    SPOT_DETAIL: 4,
    USER_PROFILE: 5,
    USER_RANKING: 6
};
var SIDEVIEW_STACK = [];
var EDIT_PLACE_STACK = [];

var mCustomScrollbarOption = {
    scrollInertia: 0,
    theme: 'minimal-dark',
    mouseWheel: {
        scrollAmount: 50
    },
    advanced: {
        updateOnContentResize: true,
        updateOnBrowserResize: true
    },
    callbacks: {
        onScroll: function() {
            $(this).data('scroll_position', this.mcs.top);
        },
        onTotalScroll: function(){
            loadMoreListPlace(this);
        }
    }
};

var mCustomScrollbarLeftUserOption = {
    scrollInertia: 0,
    theme: 'minimal-dark',
    mouseWheel: {
        scrollAmount: 50
    },
    advanced: {
        updateOnContentResize: true,
        updateOnBrowserResize: true
    },
    callbacks: {
        onScroll: function() {
            $(this).data('scroll_position', this.mcs.top);
        },
        whileScrolling: function(){
            // Fixed positoin of navagation bar
            var scrollTop = Math.abs(this.mcs.top);
            var height = $('#leftUserTitle').outerHeight();
            height += $('#leftUserCover').outerHeight();
            height += $('#leftMenuProfileComment').outerHeight();
            height += $('#leftMenuFollowContainer').outerHeight();
            
            if (scrollTop <= height) {
                $('#leftUserNav').removeClass('leftUserNavFixed');
            } else {
                $('#leftUserNav').addClass('leftUserNavFixed');
            }
        },
        onUpdate: function(){
            // Check to remove fixed position of navigation bar
            if ($('#leftUserContainer').find('.mCS_no_scrollbar_y').length > 0) {
                $('#leftUserNav').removeClass('leftUserNavFixed');
            }
        }
    }
};

var facilityList = [
    'is_flat',
    'is_spacious',
    'is_silent',
    'is_bright',
    'count_parking',
    'count_wheelchair_parking',
    'count_elevator',
    'count_wheelchair_rent',
    'count_wheelchair_wc',
    'count_ostomate_wc',
    'count_nursing_room',
    'count_babycar_rent',
    'with_assistance_dog',
    'is_universal_manner',
    'with_credit_card',
    'with_emoney',
    'count_plug',
    'count_wifi',
    'count_smoking_room'
];

/**
 * When DOM ready
 */
$(document).ready(function(){
    fixStyleIE();// KienNH, 2016/01/25
    
    // Show left menu
    $('#headerLeftMenu, #leftMenuClose').on('click', function(){
        showHideLeftMenu();
    });
    
    // Show right menu
    $('#headerRightBox').on('click', showHideRightMenu);
    
    // Set custom scrollbar
    setLeftViewContentHeight();
    $('#leftMenuContainer, \n\
    .dlgPopupChampionshipContent, \n\
    #dlgPopupReviewCommentContainer, \n\
    #leftSpotScrollMain, \n\
    #leftSpotDetailContainer, \n\
    #leftSpotScrollRanking,\n\
    #dlgPopupPlaceReviewHistoryContainer,\n\
    #leftUserRankingScroll').mCustomScrollbar(mCustomScrollbarOption);
    
    $('#leftUserContainer').mCustomScrollbar(mCustomScrollbarLeftUserOption);
    
    // Hide Spot panel
    $('#leftSpotClose').on('click', closeSpot);
    
    // Sacle screen
    fitScreenByScale();
    
    // Load Left Spot detail
    $('.leftSpotItem').on('click', function(){
        goLeftSpotDetail($(this));
    });
    
    // Load Left Spot Info
    $('#leftSpotDetailGoInfo').on('click', goLeftSpotPanelInfo);
    
    // Load Left Spot Edit
    $('#leftSpotInfoGoEdit').on('click', goLeftSpotPanelEdit);
    
    // Return Spot list on left panel
    $('#leftSpotDetailHeader').on('click', backSideView);
    
    // Return Spot detail on left panel
    $('#leftSpotInfoHeader').on('click', goBackLeftSpotPanelDetail);
    
    // Return Spot info on left panel
    $('#leftSpotEditHeader').on('click', goBackLeftSpotPanelInfo);
    
    // Show Category popup
    $('#topMapFilterCategories, #leftSpotSearchTypeCategory').on('click', showCategoryPopup);
    
    // Show Advanced search
    $('#topMapFilterFacilities, #leftSpotSearchTypeAdvanced').on('click', ShowAdvancedSearchPopup);
    
    // Custom selectbox
    $('.myCustomSelectbox, .leftSpotEditCustomSelectbox, .leftRankingCustomSelectbox').each(function(){
        $(this).selectpicker({
            showIcon: false,
            showContent: false
        });
    });
    
    // Show Recommend spot
    $('#leftMenuItemAttentionSpot a').on('click', showRecommendSpot);
    
    // Show Left Ranking
    $('#leftMenuItemRanking a').on('click', function(e){
        var href = $(this).attr('href');
        if (href.indexOf('javascript') >= 0) {
            e.preventDefault();
            showRankingSpot();
        }
    });
    
    // Show Left Ranking
    $('#leftMenuItemUserRanking a').on('click', function(e){
        var href = $(this).attr('href');
        if (href.indexOf('javascript') >= 0) {
            e.preventDefault();
            showUserRanking();
        }
    });
    
    // Hide Left Ranking
    $('#leftRankingClose').on('click', closeSpot);
    
    // Show Championship
    $('#leftMenuItemChampionship a').on('click', showChampionshipPopup);

    $("#shareUrlInput").focusin(function (e) {
        this.select();
    });
    
    // Open My page from right menu
    $('#headerRightMenuUser').on('click', function(){
        showLeftUser(0, true);
    });
    
    // Show/Hide left sideview
    $('#leftSideViewHide').on('click', showHideLeftSideView);
    
    // Search header
    $.support.cors = true;
    $.templates('headerSuggestionTemplate', $('#headerKeywordResultTemplate').html());
    var engine = new Bloodhound({
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: BASE_URL + '/top/autocomplete.json',
            replace: function (url, query) {
                var newUrl = url + '?input=' + encodeURIComponent(query);
                if (typeof map !== 'undefined') {
                    newUrl += '&location=' + map.getCenter().toUrlValue();
                }
                return newUrl;
            }
        }
    });
    engine.initialize();

    $('#headerKeyword').typeahead({
        menu: $('#headerSuggestionResult'),
        minLength: 1,
        hint: false,
        classNames: {
            open: 'is-open',
            empty: 'is-empty',
            cursor: 'is-active'
        }
    }, {
        source: function(q, sync, async){
            if (q === '') {
                sync(engine.get());
                async([]);
            } else {
                engine.search(q, sync, async);
            }
        },
        displayKey: 'description',
        templates: {
            suggestion: function(data) {
				return $.render.headerSuggestionTemplate(data);
			}
        },
        limit: 10
    })
    .on('typeahead:asyncrequest', function () {
        $('#headerSuggestionSpinner').show();
    })
    .on('typeahead:asynccancel typeahead:asyncreceive', function () {
        $('#headerSuggestionSpinner').hide();
    })
    .on('typeahead:selected', function (event, data) {
        try {
            if (map) {
                var service = new google.maps.places.PlacesService(map);
                service.getDetails({
                    placeId: data.place_id
                }, function (placeDetail, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        var latitude = placeDetail.geometry.location.lat();
                        var longitude = placeDetail.geometry.location.lng();
                        tmpMarker = createTmpMarker(latitude, longitude);
                        tmpMarker.setAnimation(google.maps.Animation.BOUNCE);
                        map.panTo(tmpMarker.getPosition());

                        goLeftSpotDetail(undefined, placeDetail.place_id, 0, true);
                    }
                });
            } else {
                goLeftSpotDetail(undefined, data.place_id, 0, true);
            }
        } catch(e){
            
        }
    });
    
    // Show popup select team
    $('#dlgPopupChampionshipTitleBtn').on('click', function(){ showChampionInfoPopup(); });
    $('#headerRightMenuChangeTeam').on('click', function(){ showSelectTeamPopup(false); });
    $('#dlgPopupChampionInfoBtnStart').on('click', function(){ showSelectTeamPopup(true); });
    $('#dlgPopupTeamSelectBtnUpdate').on('click', function(){ updateTeam(true); });
    $('#dlgPopupTeamSelectBtnUpdateAndClose').on('click', function(){ updateTeam(false); });
    $('#dlgPopupTeamSelectBtnCreate').on('click', showCreateTeamPopup);
    $('#dlgPopupTeamCreateBtnUpdate').on('click', createTeam);
    $('#dlgPopupTeamCreateCancel').on('click', goBackSelectTeamPopup);
    $('#headerRightLogout').on('click', confirmLogout);
    
    // Search team
    $.templates('dlgPopupTeamResultTemplate', $('#dlgPopupTeamResultTemplate').html());
    var engineTeam = new Bloodhound({
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        
        remote: {
            url: BASE_URL + '/ajax/searchTeam',
            replace: function (url, query) {
                var newUrl = url + '?input=' + encodeURIComponent(query);
                return newUrl;
            }
        }
    });
    engineTeam.initialize();

    $('#dlgPopupTeamSelectTeamInputName').typeahead({
        menu: $('#dlgPopupTeamSelectResult'),
        minLength: 1,
        hint: false,
        classNames: {
            open: 'is-open',
            empty: 'is-empty',
            cursor: 'is-active'
        }
    }, {
        source: function(q, sync, async){            
            if (q === '') {
                sync([]);
                async([]);
            } else {
                engineTeam.search(q, sync, async);
            }
        },
        displayKey: 'name',
        templates: {
            suggestion: function(data) {                
				return $.render.dlgPopupTeamResultTemplate(data);
			}
        },
        limit: 5
    })
    .on('typeahead:asyncrequest', function () {
        $('#dlgPopupTeamSelectInputSearchSpinner').show();
    })
    .on('typeahead:asynccancel typeahead:asyncreceive', function () {
        $('#dlgPopupTeamSelectInputSearchSpinner').hide();
    })
    .on('typeahead:selected', function (event, data) {
        $('#dlgPopupTeamSelectTeamInputName').val(data.name);
        $('#dlgPopupTeamSelectTeamInputId').val(data.id);
    });
    
    // Show setting static iframe
    $('.stgOtherItem').on('click', function () {
        var url = $(this).attr('data-url');
        showStaticHtmlPopup(url);
    });
    
    // Open left panel
    var item_hash = window.location.hash.substr(1);
    
    if (item_hash === 'spot_ranking') {
        need_remove_hash = true;
        showRankingSpot();
    } else if (item_hash === 'user_ranking') {
        need_remove_hash = true;
        showUserRanking();
    }
    
    if (need_remove_hash) {
        history.pushState("", document.title, window.location.pathname + window.location.search);
    }
});

/**
 * Show left Spot
 */
function showRecommendSpot() {
    hideLeftSpotHeaderBtn();
    $('#leftSpotHeader span').html(SEARCH_SPOT_RECOMMEND_TITLE);
    openSideView(SIDEVIEW_TYPE.SPOT_RECOMMEND, loadRecommendSpot, true);
}

loadRecommendSpot = function() {
    var url = BASE_URL + '/places/recommend';
    var currentLocation = getCurrentMapLocation();// KienNH 2016/06/03 change to use common function
    if (currentLocation) {
        url += '?location=' + currentLocation.lat + ',' + currentLocation.lng;
    }
    ajaxLeftRecommentSpot = $.ajax({
        cache: false,
        async: true,
        type: 'get',
        url: url,             
        beforeSend: function() {  
            $('#leftSideViewLoader').show();
            return true;
        },
        success: function (response) {
            $('#spotBody').html(response);
            $('#leftSideViewLoader').hide();
        },
        complete: function() {
            ajaxLeftRecommentSpot = null;
        }
    });
};

function loadMoreRecommendSpot(nextPage) {
    // Init
    var url = BASE_URL + '/places/recommend?';
    var currentLocation = getCurrentMapLocation();// KienNH 2016/06/03 change to use common function
    var loadMoreClass = 'leftSideViewLoaderMoreRecommendSpot';
    var spotBody = $('#spotBody');
    var leftSideViewLoaderMore = $('<div />', {
        "class": loadMoreClass
    });
    
    // Reqeust still loading
    if (ajaxLeftRecommentSpot || spotBody.find('.' + loadMoreClass).length > 0) {
        return false;
    }
    /*
    spotBody.find('.' + loadMoreClass).remove();// bebug
    $('#spotBody').append(leftSideViewLoaderMore);// bebug
    return false;// debug
    */
    // Build Url
    if (currentLocation) {
        url += '&location=' + currentLocation.lat + ',' + currentLocation.lng;
    }
    url += '&page=' + nextPage;
    
    // Begin request
    ajaxLeftRecommentSpot = $.ajax({
        cache: false,
        async: true,
        type: 'get',
        url: url,             
        beforeSend: function() {
            spotBody.find('.' + loadMoreClass).remove();
            $('#spotBody').append(leftSideViewLoaderMore);
            $('#leftSpotScrollMain').mCustomScrollbar('scrollTo', 'bottom');
            return true;
        },
        success: function (response) {
            spotBody.append(response);
            if (response == '') {
                $('#leftSideView').attr('data-page', LAST_PAGE);
            } else {
                $('#leftSideView').attr('data-page', nextPage);
            }
        },
        complete: function() {
            ajaxLeftRecommentSpot = null;
            spotBody.find('.' + loadMoreClass).remove();
        }
    });
}

/**
 * Show left Spot Ranking
 */
function showRankingSpot() {
    openSideView(SIDEVIEW_TYPE.SPOT_RANKING, loadRankingSpot, true);
}

loadRankingSpot = function() {
    var tab = $('#leftRankingTraveler').data('tab');
    if (tab === undefined) {
        tab = 1;
    }    
    var place_category_type_id = $('#leftRankingCategories option:selected').val();    
    if (place_category_type_id === undefined) {
        place_category_type_id = 0;
    }
    var url = BASE_URL + '/places/ranking?place_category_type_id='+place_category_type_id+'&tab='+tab;
    var currentLocation = getCurrentMapLocation();// KienNH 2016/06/03 change to use common function
    if (currentLocation) {
        url += '&location=' + currentLocation.lat + ',' + currentLocation.lng;
    }
    ajaxLeftRanking = $.ajax({
        cache: false,
        async: true,
        type: 'get',
        url: url,
        beforeSend: function() {
            $('#leftSideViewLoader').show();
            return true;
        },
        success: function (response) {
            $('#leftRankingList').html(response);
            $('#leftSideViewLoader').hide();
        }
    });
};

/**
 * Show left User ranking
 */
function showUserRanking() {
    openSideView(SIDEVIEW_TYPE.USER_RANKING, loadUserRanking, true);
}

loadUserRanking = function() {
    var url = BASE_URL + '/users/ranking';
    var currentLocation = getCurrentMapLocation();// KienNH 2016/06/03 change to use common function
    if (currentLocation) {
        url += '?location=' + currentLocation.lat + ',' + currentLocation.lng;
    }
    ajaxLeftUserRanking = $.ajax({
        cache: false,
        async: true,
        type: 'get',
        url: url,             
        beforeSend: function() {  
            $('#leftSideViewLoader').show();
            return true;
        },
        success: function (response) {
            $('#userRankingBody').html(response);
            $('#leftSideViewLoader').hide();
        },
        complete: function() {
            ajaxLeftUserRanking = null;
        }
    });
};

loadDetailSpot = function(id, showTab, spotGooglePlaceId, share, openFromOutSide) {
    // KienNH 2016/06/03 begin
    if (map) {
        setCookie(cookieLatitude, map.getCenter().lat(), 1);
        setCookie(cookieLongitude, map.getCenter().lng(), 1);
    }
    // KienNH end
    
    if (id === undefined || id === null) {
        id = 0;
    }
    if (showTab === undefined) {
        showTab = 1;
    }    
    if (spotGooglePlaceId === undefined) {
        spotGooglePlaceId = '';
    }    
    if (share === undefined) {
        share = 0;
    } 
    if (id == 0 && spotGooglePlaceId == '') {
        showErrorPopup(NOT_FOUND_MESSAGE);
        return false;
    }   
    var url = BASE_URL + '/places/detail/'+id+'?google_place_id='+spotGooglePlaceId+'&share='+share;
    var currentLocation = getCurrentMapLocation();// KienNH 2016/06/03 change to use common function
    if (currentLocation) {
        url += '&location=' + currentLocation.lat + ',' + currentLocation.lng;
    }
    var leftSpotDetail = $('#leftSpotDetail');
    leftSpotDetail.find('#spotDetailBody').html('');
    
    // Add custom request
    if (typeof openFromOutSide !== 'undefined' && openFromOutSide) {
        url += '&openFromOutSide=1';
    }
    
    // Cancel last ajax request
    try { ajaxLoadSpotDetail.abort(); } catch(err) {}
    
    ajaxLoadSpotDetail = $.ajax({
        cache: false,
        //async: true,
        type: 'get',
        url: url,             
        beforeSend: function() {
            $('#leftSideViewLoader').show();
            return true;
        },
        success: function (response) {
            $('#leftSideViewLoader').hide();
            
            if (response == '') {
                leftSpotDetail.hide();
                showErrorPopup(LABEL_SPOT_NOT_REGISTERED);
                return false;
            }
            
            leftSpotDetail.find('#spotDetailBody').html(response);
            if (showTab == 3) { 
                $('#leftSpotContainerInfo').hide();
                $('#leftSpotContainerDetail').hide();
                $('#leftSpotContainerEdit').show();
            } else if (showTab == 2) {
                $('#leftSpotContainerDetail').hide();                
                $('#leftSpotContainerEdit').hide();
                $('#leftSpotContainerInfo').show();
            } else {                              
                $('#leftSpotContainerEdit').hide();
                $('#leftSpotContainerInfo').hide();
                $('#leftSpotContainerDetail').show();  
            }            
            initJsAjaxSubmit();
            guestMode();
            
            // KienNH, 2015/11/13: Add custom selectbox
            $('.leftSpotEditCustomSelectbox').each(function () {
                $(this).selectpicker({
                    showIcon: false,
                    showContent: false
                });
            });
            
            // KienNH, 2015/11/18
            setLeftViewContentHeight();// Update scroll
            $('#leftSpotDetailContainer').mCustomScrollbar(mCustomScrollbarOption);
            
            // KienNH, 2015/11/19
            // Check hide back button
            if (typeof openFromOutSide !== 'undefined' && openFromOutSide) {
                leftSpotDetail.find('#leftSpotDetailHeader').hide();
            } else {
                leftSpotDetail.find('#leftSpotDetailHeader').show();
            }
            
            if (map) {
                // KienNH, 2015/12/07: Fix move map by create new Marker
                try {
                    tmpMarker.setMap(null);
                    tmpMarker = null;
                } catch(e) {}

                __placeDetailJson.google_place_id = __placeDetailJson.google_place_id ? __placeDetailJson.google_place_id : '0';
                __placeDetailJson.place_id = __placeDetailJson.place_id ? __placeDetailJson.place_id : '0';

                var ___key = __placeDetailJson.google_place_id + "-" + __placeDetailJson.place_id;
                if (markers[___key] !== undefined) {
                    markers[___key].setMap(null);
                    delete markers[___key];
                }

                try {
                    openningMarker.setMap(null);
                } catch (e) {}
                openningMarker = null;
                
                createMarkerPlace(__placeDetailJson, true);
                markerEffectWhenClickOnSpot(___key);
            }
        },
        error: function() {
            $('#leftSideViewLoader').hide();
        }
    });
};

/**
 * Resize windows event
 */
$(window).on('resize', function () {
    clearTimeout(intervalWindowResize);
    intervalWindowResize = setTimeout(function(){
        fixStyleIE();// KienNH, 2016/01/25
        fitScreenByScale();
        scalePopup();
        setLeftViewContentHeight();
        updateCustomScrollbar();
    }, 250);
});

/**
 * Update Custom scrollbar
 */
function updateCustomScrollbar() {
    $('.mCustomScrollbar').each(function () {
        $(this).mCustomScrollbar('update');
    });
}

/**
 * Show or Hide Left menu when click on header button
 * 
 * @param {function} callbackShow
 * @param {function} callbackHide
 * @param {boolean} showHideNow
 */
function showHideLeftMenu(callbackShow, callbackHide, showHideNow) {
    var menu = $('#leftMenu');
    var menuClose = $('#leftMenuClose');
    var wrapPanelTop = $('#wrapPanelTop');
    var hasCallbackShow = typeof(callbackShow) === 'function';
    var hasCallbackHide = typeof(callbackHide) === 'function';
    var _speedMenuClose = showHideNow ? 0 : speedMenuClose;
    var _speedMenu = showHideNow ? 0 : speedMenu;
    
    if(menu.is(':visible')) {
        // Hide Wrap
        if (_speedMenu == 0) {
            wrapPanelTop.hide();
        } else {
            wrapPanelTop.fadeOut('fast');
        }
        
        // Hide close box
        menuClose.animate({right: '0px'}, _speedMenuClose, function(){
            menuClose.css('display', 'none');
            
            // Hide menu
            menu.animate({left: '-260px'}, _speedMenu, function(){
                menu.css('display', 'none');
                
                // Callback
                if (hasCallbackHide) {
                    callbackHide();
                }
            });
        });
    } else {
        // Show Wrap
        if (_speedMenu == 0) {
            wrapPanelTop.show();
        } else {
            wrapPanelTop.fadeIn('fast');
        }
        
        // Show menu
        menu.css('display', 'block').css('left', '-260px');
        menuClose.css('display', 'block').css('right', '0px');
        menu.animate({left: '0px'}, _speedMenu, function(){
            // Show close box
            menuClose.animate({right: '-24px'}, _speedMenuClose, function () {
                // Callback
                if (hasCallbackShow) {
                    callbackShow();
                }
            });
        });
    }
    
    // Bind event click on wrap to hide menu
    $('#wrapPanelTop').unbind('click').bind('click', function(){
        wrapPanelTop.fadeOut('fast');
        if(menu.is(':visible')) {
            showHideLeftMenu();
        };
    });
}

/**
 * Show or Hide Right menu when click on User
 */
function showHideRightMenu() {
    // Fix  width of right menu same with top box
    var rightBox = $('#headerRightBox');
    var rightMenu = $('#headerRightMenu');

    rightMenu.width(rightBox.width());
    if ($('body').hasClass('es')) {
        rightMenu.width(265);
    }
    rightBox.toggleClass('active');

    rightMenu.slideToggle(200, function () {

    });
}

/**
 * Check and search from header
 */
function headerSearch() {    
    return true;
}

/**
 * Close left Spot
 */
function closeSpot() {
    closeAllSideView();
}

/**
 * Set page zoom
 * @param {double} zoomNumber
 */
function setZoom(zoomNumber) {
    // Set limit
    if (zoomNumber > 1) {
        zoomNumber = 1;
    }
    
    // Init
    var scale = 'scale(' + zoomNumber + ')';
    
    // Set sacle
    if (Modernizr.testProp('transform') === true) {
        $('html')
            .css('-ms-transform', scale)
            .css('-moz-transform', scale)
            .css('-o-transform', scale)
            .css('-webkit-transform', scale)
            .css('transform', scale);
    } else {
        $('html').css('zoom', zoomNumber);
    }
    
    // Revert body's height
    $('html').css('height', '100%');
    if (zoomNumber < 1) {
        var bodyHeight = $('html').height();
        var bodyHeightScaled = parseInt(bodyHeight / zoomNumber);
        $('html').css('height', bodyHeightScaled + 'px');
    }
}

// Scale screen
function fitScreenByScale() {
    var innerWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    var windowWidth;
    
    if (innerWidth >= 1000) {
        setZoom(1);
    } else if (innerWidth < 1000 && innerWidth >= 640) {
        // PC
        windowWidth = $(window).width();
        setZoom(windowWidth / 1000);
    } else if (innerWidth < 640) {
        // SP
        windowWidth = $(window).width();
        setZoom(windowWidth / 1000);
    }
}

/**
 * Load Spot detail on left panel
 * 
 * @param {object} item
 * @param {int} spotGooglePlaceId
 * @param {int} spotId
 * @param {boolean} openFromOutSide
 * @returns {Boolean}
 */
function goLeftSpotDetail(item, spotGooglePlaceId, spotId, openFromOutSide) {
    // Check require params
    if (typeof item === 'undefined' && typeof spotGooglePlaceId === 'undefined' && typeof spotId === 'undefined') {
        return false;
    }

    // Init. Some spot don't have id, so use google-place-id instead
    if (typeof item !== 'undefined' && item !== null) {
        spotId = item.attr('data-id'); 
        spotGooglePlaceId = item.attr('data-google-place-id');
        spotTypeId = item.attr('data-type-id');
        setPlaceTypeFilter(spotTypeId);
    }
    
    // Check valid params
    if (typeof spotId === 'undefined') {
        spotId = 0;
    }
    if (typeof spotGooglePlaceId === 'undefined') {
        spotGooglePlaceId = '';
    } 
    if (spotId == 0 && spotGooglePlaceId == '') {
        showErrorPopup(NOT_FOUND_MESSAGE);
        return false;
    }
    
    // Add effect for selected spot
    var __key = '';
    if (typeof item !== 'undefined' && item !== null) {
        __key = item.attr("data-key");
    } else {
        __key = spotGooglePlaceId + '-' + spotId;
    }
    markerEffectWhenClickOnSpot(__key);
    
    // Open view
    if (typeof openFromOutSide !== 'undefined' && openFromOutSide) {
        closeAllSideView(function(){
            openSideView(SIDEVIEW_TYPE.SPOT_DETAIL, function(){
                loadDetailSpot(spotId, undefined, spotGooglePlaceId, undefined, openFromOutSide);
            }, true);
        });
    } else {
        openSideView(SIDEVIEW_TYPE.SPOT_DETAIL, function () {
            loadDetailSpot(spotId, undefined, spotGooglePlaceId, undefined, openFromOutSide);
        }, false);
    }
    
    return false;
}

/**
 * Show Left Spot Info on left panel
 */
function goLeftSpotPanelInfo() {
    // Init
    var slider = $('#leftSpotMainContainerSlider');
    var detail = $('#leftSpotContainerDetail');
    
    // Check valid Spot
    if (detail.length <= 0) {
        return false;
    }
    
    var item = detail.attr('data-id');
    if (typeof item === 'undefined' || item === '') {
        return false;
    }
    
    // Show panel

    slider.animate({'left': '-' + (400 * 2) + 'px'}, speedSpot, function () {
      
    });
}

/**
 * Show Left Spot Edit on left panel
 */
function goLeftSpotPanelEdit() {
    // Init
    var slider = $('#leftSpotMainContainerSlider');
    var info = $('#leftSpotContainerInfo');
    
    // Check valid Spot
    if (info.length <= 0) {
        return false;
    }
    
    var item = info.attr('data-id');
    
    if (typeof item === 'undefined' || item === '') {
        return false;
    }
    
    // Show panel
    slider.animate({'left': '-' + (400 * 2) + 'px'}, speedSpot, function () {
        
    });
}

/**
 * Go Spot detail panel on left panel
 */
function goBackLeftSpotPanelDetail() {
    // Init
    var slider = $('#leftSpotMainContainerSlider');
    
    // Show panel
    slider.animate({'left': sideLeftHide}, speedSpot, function () {
        
    });
}

/**
 * Go Spot info panel on left panel
 */
function goBackLeftSpotPanelInfo() {
    // Init
    var slider = $('#leftSpotMainContainerSlider');    
    // Show panel
    slider.animate({'left': '-' + (400 * 2) + 'px'}, speedSpot, function () {
        
    });
}

// Thai Lai

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) == 0)
            return c.substring(name.length, c.length);
    }
    return false;
}

$(function () {
    initJsAjaxSubmit(); 
    guestMode();
    setAdvanceSearchForm();
    
    $('#leftMenuItemFollow').click(function(){
        showLeftUser();
    });
    
    $('#dlgPopupAdvancedSearchTopReviewMinus').click(function(){
        var point = getCurrentPoint();
        if (point == 0) {
            point = 5;
        } else if (point == 1) {
            point = '-';
        } else {
            point--;
        }      
        $('#dlgPopupAdvancedSearchTopReviewNumber').html(point);
        setAdvanceSearchForm();
    });
    
    $('#dlgPopupAdvancedSearchTopReviewPlus').click(function(){
        var point = getCurrentPoint(); 
        if (point < 5) {
            point++;
        } else {
            point = '-';
        }         
        $('#dlgPopupAdvancedSearchTopReviewNumber').html(point);
        setAdvanceSearchForm();
    });
    
    $('#dlgPopupAdvancedSearchTopStepMinus').click(function(){
        var step = getCurrentStep();
        if (step < 0) {
            step = '3+';
        } else {
            step--;
        }
        
        $('#dlgPopupAdvancedSearchTopStepNumber').html(step);
        setAdvanceSearchForm();
    });
    $('#dlgPopupAdvancedSearchTopStepPlus').click(function(){
        var step = getCurrentStep();
        if (step >= 4) {
            step = '-';
        } else if(step == 3) {
            step = '3+';
        } else {
            step++;
        }
        
        $('#dlgPopupAdvancedSearchTopStepNumber').html(step);
        setAdvanceSearchForm();
    });
    $('#dlgPopupAdvancedSearchTitleReset').click(function(){
        $('#dlgPopupAdvancedSearchTopReviewNumber').html('-');
        $('#dlgPopupAdvancedSearchTopStepNumber').html('-');
        facilityCurrent = facilityDefault;
        physicalTypeCurrent = physicalTypeDefault;   
        setCookie('search_point', getCurrentPoint(), 1);
        setCookie('search_step', getCurrentStep(), 1);
        setCookie('search_facility', facilityCurrent, 1);
        setCookie('search_physicaltype', physicalTypeCurrent, 1);
        setAdvanceSearchForm();
    });
    $('#dlgPopupAdvancedSearchEquipment1 .dlgPopupAdvancedSearchEquipmentDetail .dlgPopupAdvancedSearchEquipmentItem').click(function(){
        if ($(this).hasClass('on') === false) {
            $(this).addClass('on');              
        } else {           
            $(this).removeClass('on');
        }
    });
    $('#dlgPopupAdvancedSearchEquipment1 .dlgPopupAdvancedSearchEquipmentButton').click(function(){
        var value = '';       
        $('#dlgPopupAdvancedSearchEquipment1 .dlgPopupAdvancedSearchEquipmentDetail .dlgPopupAdvancedSearchEquipmentItem').each(function() {
            if ($(this).hasClass('on') === true) {
                if (value == '') {
                    value = $(this).data('id');
                } else {
                    value = $(this).data('id') + ',' + value;
                }          
            }
        });
        facilityCurrent = value;
        setAdvanceSearchForm();
        $('.dlgPopupAdvancedSearchEquipmentClose').click();
    });
    
    $('#dlgPopupAdvancedSearchEquipment2 .dlgPopupAdvancedSearchEquipmentDetail .dlgPopupAdvancedSearchEquipmentItem').click(function(){
        if ($(this).hasClass('on') === false) {
            $(this).addClass('on');              
        } else {           
            $(this).removeClass('on');
        }     
    });
    $('#dlgPopupAdvancedSearchEquipment2 .dlgPopupAdvancedSearchEquipmentButton').click(function(){
        var value = '';       
        $('#dlgPopupAdvancedSearchEquipment2 .dlgPopupAdvancedSearchEquipmentDetail .dlgPopupAdvancedSearchEquipmentItem').each(function() {
            if ($(this).hasClass('on') === true) {
                if (value == '') {
                    value = $(this).data('id');
                } else {
                    value = $(this).data('id') + ',' + value;
                }          
            }
        });
        physicalTypeCurrent = value;
        setAdvanceSearchForm();
        $('.dlgPopupAdvancedSearchEquipmentClose').click();
    });
     
    $('#plcListTab a').click(function(){
        $('#plcListTab a').removeClass('active');
        $(this).addClass('active');   
        var tab = $(this).data('tab');
        if (tab == 'plcList1') {
            $('.plcList1').show();
            $('.plcList2').hide();
        } else if (tab == 'plcList2') {
            $('.plcList1').hide();
            $('.plcList2').show();
        }        
    });    
    
    $('#leftUserTitleBack').on('click', backSideView);
    
    $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelMinus').click(function(){  
        var point = $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelNumber').html();
        var point = parseInt(point == '-' ? 0 : point);
        if (point > 0) {  
            point--;
        }   
        setReviewPointIcon(point);
    });
    $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelPlus').click(function(){
        var point = $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelNumber').html();
        var point = parseInt(point == '-' ? 0 : point);
        if (point < 5) {
            point++;
        }        
        setReviewPointIcon(point);
    });
    
    // KienNH, 2016/01/22, begin
    $('#leftSpotEditEntranceStepsMinus').on('click', function(){
        var step = getCurrentSpotEntranceSteps();
        if (step < 0) {
            step = '4';
        } else if (step == 0) {
            step = '';
        } else {
            step--;
        }
        $('#leftSpotEditEntranceStepsValue').val(step);
        $('#leftSpotEditEntranceStepsText').text(step);
        markSpotEntranceStep(step);
    });
    $('#leftSpotEditEntranceStepsPlus').on('click', function(){
        var step = getCurrentSpotEntranceSteps();
        if (step >= 4) {
            step = '';
        } else if (step == 3) {
            step = '4';
        } else {
            step++;
        }
        $('#leftSpotEditEntranceStepsValue').val(step);
        var text = '-';
        if (step !== '') {
            if (step === 4 || step === '4') {
                text = '3+';
            } else {
                text = step;
            }
        }
        $('#leftSpotEditEntranceStepsText').text(text);
        markSpotEntranceStep(step);
    });
    // KienNH end
});

setReviewPointIcon = function(point) {
    $('#dlgPopupReviewSubmitForm #review_point').val(point);                    
    if (point >= 0) {
        for (i = 1; i <= point; i++) {
            if ($('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelFace' + i).hasClass('on') === false) {
                $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelFace' + i).addClass('on');
            }
        }
        for (i = point + 1; i <= 5; i++) {
            if ($('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelFace' + i).hasClass('on') === true) {
                $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelFace' + i).removeClass('on');
            }
        }
    } else {
        for (i = 1; i <= 5; i++) {
            $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelFace' + i).removeClass('on');
        }
    }
    if (point == 0) {
        point = '-';
    }
    $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelNumber').html(point);
};

function getCurrentPoint() {
    return parseInt($('#dlgPopupAdvancedSearchTopReviewNumber').text().trim()) || 0;
}

function getCurrentStep() {
    var value = $('#dlgPopupAdvancedSearchTopStepNumber').text().trim();
    if (value == '3+') {
        value = 4;
    } else if (value == '' || value == '-') {
        value = -1;
    }
    
    return parseInt(value);
}    

function getCurrentFacility() {
    return facilityCurrent + '';
}

function getCurrentPhysicalType() {
    return physicalTypeCurrent + '';
}
    
function setActiveFacility() {
    var value = getCurrentFacility();
    if (value) {
        value = value.split(","); 
    } else {
        value = [];
    }
    var found = 0;
    var total = 0;// KienNH, 2016/01/21: process show/hide MORE icon
    $('#dlgPopupAdvancedSearch #dlgPopupAdvancedSearchTopEquipmentContent .dlgPopupAdvancedSearchTopEquipmentItem').each(function() {
        var id = $(this).data('id');
        if (id !== undefined) {     
            $(this).hide();
            if ($.inArray(id+'', value) !== -1) {
                if (found < 3) {
                    $(this).show();
                }                    
                $('#dlgPopupAdvancedSearchEquipment1 .dlgPopupAdvancedSearchEquipmentDetail .dlgPopupAdvancedSearchEquipmentItem[data-id="'+id+'"]').addClass('on');
                found++;
                total++;
            } else {
                $('#dlgPopupAdvancedSearchEquipment1 .dlgPopupAdvancedSearchEquipmentDetail .dlgPopupAdvancedSearchEquipmentItem[data-id="'+id+'"]').removeClass('on');
            }
        }
    });
    var more = $('#dlgPopupAdvancedSearch #dlgPopupAdvancedSearchTopEquipmentContent .dlgPopupAdvancedSearchTopEquipmentItem.physicalTypeMore');
    if (total > 3) {
        more.show();
    } else {
        more.hide();
    }
}

function setActivePhysicalType() {
    var value = getCurrentPhysicalType();
    if (value != '') {
        value = value.split(","); 
    } else {
        value = [];
    }
    var found = 0;
    var total = 0;// KienNH, 2016/01/21: process show/hide MORE icon
    $('#dlgPopupAdvancedSearchTopPhysical #dlgPopupAdvancedSearchTopPhysicalContent .dlgPopupAdvancedSearchTopPhysicalItem').each(function() {
        var id = $(this).data('id');
        if (id !== undefined) {  
            $(this).hide();
            if ($.inArray(id+'', value) !== -1) {
                if (found < 3) {
                    $(this).show();
                }
                $('#dlgPopupAdvancedSearchEquipment2 .dlgPopupAdvancedSearchEquipmentDetail .dlgPopupAdvancedSearchEquipmentItem[data-id="'+id+'"]').addClass('on');
                found++;
                total++;
            } else {
                $('#dlgPopupAdvancedSearchEquipment2 .dlgPopupAdvancedSearchEquipmentDetail .dlgPopupAdvancedSearchEquipmentItem[data-id="'+id+'"]').removeClass('on');
            }
        }
    });
    var more = $('#dlgPopupAdvancedSearchTopPhysical #dlgPopupAdvancedSearchTopPhysicalContent .dlgPopupAdvancedSearchTopPhysicalItem.physicalTypeMore');
    if (total > 3) {
        more.show();
    } else {
        more.hide();
    }
}

function setAdvanceSearchForm() {        
    var point = getCurrentPoint();
    if (point >= 1) {
        for (var i = 1; i <= point; i++) {
            if ($('#dlgPopupAdvancedSearchTopReviewFace' + i).hasClass('on') === false) {
                $('#dlgPopupAdvancedSearchTopReviewFace' + i).addClass('on');
            }
        }
        for (var i = point + 1; i <= 5; i++) {
            if ($('#dlgPopupAdvancedSearchTopReviewFace' + i).hasClass('on') === true) {
                $('#dlgPopupAdvancedSearchTopReviewFace' + i).removeClass('on');
            }
        }
        $('#dlgPopupAdvancedSearchTopReviewNumber').html(point);
    } else {
        $('#dlgPopupAdvancedSearchTopReviewFace1').removeClass('on');
        $('#dlgPopupAdvancedSearchTopReviewFace2').removeClass('on');
        $('#dlgPopupAdvancedSearchTopReviewFace3').removeClass('on');
        $('#dlgPopupAdvancedSearchTopReviewFace4').removeClass('on');
        $('#dlgPopupAdvancedSearchTopReviewFace5').removeClass('on');
        $('#dlgPopupAdvancedSearchTopReviewNumber').html('-');
    }
    var step = getCurrentStep();
    if (step >= 0) {
        for (var i = 0; i <= step; i++) {            
            if ($('#dlgPopupAdvancedSearchTopStepRange' + (i+1)).hasClass('on') === false) {
                $('#dlgPopupAdvancedSearchTopStepRange' + (i+1)).addClass('on');
            }
        }
        for (var i = step + 1; i <= 4; i++) {
            if ($('#dlgPopupAdvancedSearchTopStepRange' + (i+1)).hasClass('on') === true) {
                $('#dlgPopupAdvancedSearchTopStepRange' + (i+1)).removeClass('on');
            }
        }
        $('#dlgPopupAdvancedSearchTopStepNumber').html(step >= 4 ? '3+' : step);
    } else {
        $('#dlgPopupAdvancedSearchTopStepRange1').removeClass('on');
        $('#dlgPopupAdvancedSearchTopStepRange2').removeClass('on');
        $('#dlgPopupAdvancedSearchTopStepRange3').removeClass('on');
        $('#dlgPopupAdvancedSearchTopStepRange4').removeClass('on');
        $('#dlgPopupAdvancedSearchTopStepRange5').removeClass('on');
        $('#dlgPopupAdvancedSearchTopStepNumber').html('-');
    }
    setActiveFacility();
    setActivePhysicalType();
    
    var facility = getCurrentFacility();
    var physicalType = getCurrentPhysicalType();    
    
    if (point == 0 && step == -1 && facility == '' && physicalType == '') {
        $('#dlgPopupAdvancedSearchTopBtn').addClass('disableBtn');
        if (facility == '') {
            $('#dlgPopupAdvancedSearchTopEquipmentContentNo').show();
            $('#dlgPopupAdvancedSearchTopEquipmentContent').hide();
        }
        if (physicalType == '') {
            $('#dlgPopupAdvancedSearchTopPhysicalContentNo').show();
            $('#dlgPopupAdvancedSearchTopPhysicalContent').hide();
        }
    } else {
        $('#dlgPopupAdvancedSearchTopBtn').removeClass('disableBtn');
        if (facility != '') {
            $('#dlgPopupAdvancedSearchTopEquipmentContentNo').hide();
            $('#dlgPopupAdvancedSearchTopEquipmentContent').show();
        }
        if (physicalType != '') {
            $('#dlgPopupAdvancedSearchTopPhysicalContentNo').hide();
            $('#dlgPopupAdvancedSearchTopPhysicalContent').show();
        }
    }
}
    
loadSubCategories = function(category_id) {
    var url = BASE_URL + '/ajax/subcategories?category_id=' + category_id;
    $.ajax({
        cache: false,
        async: true,
        type: 'get',
        url: url,             
        beforeSend: function() {  
            return true;
        },
        success: function (response) {  
            $('#place_sub_category_type_id').html(response);   
            setTimeout(function(){
                $('#place_sub_category_type_id').selectpicker('refresh');
            }, 50);
        }
    });
};
    
initJsAjaxSubmit = function (containerId) {
    var ajaxSubmitClass = '.ajax-submit';
    if (containerId !== undefined) {
        ajaxSubmitClass = containerId + ' ' + ajaxSubmitClass;
    }
    if ($(ajaxSubmitClass).length > 0) {
        $(ajaxSubmitClass).unbind("click");
        $(ajaxSubmitClass).click(function () {
            var url = window.location.href;
            if ($(this).data('url')) {
                url = $(this).data('url');
            }
            var ok = false;
            var btn = $(this);
            var frm = $(this).closest('form');   
            if (btn.data('confirmmessage')) {
                if (confirm(jQuery.trim(btn.data('confirmmessage'))) == false) {
                    return false;
                }
            }
            if (btn.data('beforesubmit')) {
                eval(btn.data('beforesubmit'));
            }
            $.ajax({
                cache: false,
                async: false,
                type: frm.attr('method'),
                url: url,
                data: frm !== undefined ? frm.serialize() : null,
                beforeSend: function() {
                    if (btn.data('beforesend')) {
                        eval(btn.data('beforesend'));
                    }
                    return true;
                },
                success: function (response) {    
                    var result = JSON.parse(response);                                  
                    if (result.status !== undefined && result.status == 'ok') {
                        // KienNH, 2016/02/26 begin
                        if (result.update_place_detail !== undefined && result.update_place_detail) {
                            addEditPlaceStack(result.update_place_detail);
                        }
                        // KienNH end
                        
                        if (btn.data('callback')) {
                            eval(btn.data('callback'));
                            return false;                            
                        } else {
                            window.location.reload();
                        }
                    }
                }
            });   
            return ok;
        });              
    }
};

/**
 * Show category popup when click on left menu
 */
function showCategoryPopup() {
    // Init
    var categoryPopup = $('#dlgPopupCategory');
    
    scalePopup(categoryPopup);
    
    // Show popup
    if(!categoryPopup.is(':visible')) {
        categoryPopup.fadeIn('fast');
        $("#wrapPanelMain").fadeIn('slow');
    }
    
    // Close Setting dialog
    $("#wrapPanelMain").on('click', function(){
        if (categoryPopup.is(':visible')) {
            categoryPopup.fadeOut('fast');
            $("#wrapPanelMain").fadeOut('slow');
        }
    });
}

/**
 * Show Advanced search popup
 */
function ShowAdvancedSearchPopup() {
    // Init
    var advancedSearchPopup = $('#dlgPopupAdvancedSearch');
    
    scalePopup(advancedSearchPopup);
    
    // Hide Equipment
    $('.dlgPopupAdvancedSearchEquipment').hide();
    
    // Set value
    var search_point = getCookie('search_point');
    if (search_point === false) {
        search_point = '-';
    }
    $('#dlgPopupAdvancedSearchTopReviewNumber').html(search_point);
    
    var search_step = getCookie('search_step');
    if (search_step === false) {
        search_step = '-';
    }
    $('#dlgPopupAdvancedSearchTopStepNumber').html(search_step);
    
    facilityCurrent = getCookie('search_facility');
    if (facilityCurrent === false) {
        facilityCurrent = facilityDefault;
    }
    
    physicalTypeCurrent = getCookie('search_physicaltype');
    if (physicalTypeCurrent === false) {
        physicalTypeCurrent = physicalTypeDefault;
    }
    
    setAdvanceSearchForm();
    
    // Show popup
    if(!advancedSearchPopup.is(':visible')) {
        advancedSearchPopup.fadeIn('fast');
        $("#wrapPanelMain").fadeIn('slow');
    }
    
    // Close Setting dialog
    $("#wrapPanelMain, #dlgPopupAdvancedSearchTitleCancel").on('click', function(){
        if (advancedSearchPopup.is(':visible')) {
            advancedSearchPopup.fadeOut('fast');
           // $("#wrapPanelMain").fadeOut('slow');
            $(".wrapPanel").fadeOut('slow');
            setActiveFacility();
            setActivePhysicalType();
        }
    });
    
    // Show Equipment 1
    $('#dlgPopupAdvancedSearchTopEquipmentContent, #dlgPopupAdvancedSearchTopEquipmentContentNo').on('click', function(){
        // Show view
        $('#dlgPopupAdvancedSearchEquipment1').fadeIn('fast');
    });
    
    // Show Equipment 2
    $('#dlgPopupAdvancedSearchTopPhysicalContent, #dlgPopupAdvancedSearchTopPhysicalContentNo').on('click', function(){
        // Show view
        $('#dlgPopupAdvancedSearchEquipment2').fadeIn('fast');
    });
    
    // Close Equipment
    $('.dlgPopupAdvancedSearchEquipmentClose').on('click', function(){       
        setActiveFacility();
        setActivePhysicalType();
        $('.dlgPopupAdvancedSearchEquipment').fadeOut('fast'); 
    });
}

/**
 * Show Championship Popup when click on left menu
 */
function showChampionshipPopup() {
    // Close left menu
    var leftMenu = $('#leftMenu');
    if(leftMenu.is(':visible')) {
        showHideLeftMenu(null, null, true);
    }
    
    closePopupTeamSelect();
    // Check team has been registed
    if (hasTeam()) {
        // Show Champion popup
        var championshipPopup = $('#dlgPopupChampionship');
        scalePopup(championshipPopup);
        
        // Show popup
        if (!championshipPopup.is(':visible')) {
            championshipPopup.fadeIn('fast');
            $("#wrapPanelMain").fadeIn('slow');
        }

        // Close Setting dialog
        $("#wrapPanelMain").on('click', function () {
            if (championshipPopup.is(':visible')) {
                championshipPopup.fadeOut('fast');
                $("#wrapPanelMain").fadeOut('slow');
            }
        });
        
        loadTeamList(1);
        
    } else {
        // Show Team info popup
        showChampionInfoPopup();
    }
}

loadTeamList = function(section) {   
    if (section === undefined) {
        section = 1;
    }
    var url = BASE_URL + '/ajax/team?section_id='+section;    
    $.ajax({
        cache: false,
        async: true,
        type: 'get',
        url: url,             
        beforeSend: function() {  
            return true;
        },
        success: function (response) {
            if (section == 1) {
                $('#pcsGeneralData').html(response);  
            } else if (section == 2) {
                $('#pcsCompanyData').html(response);                
            } else {
                $('#pcsUniversityData').html(response);    
            }              
            $('.dlgPopupChampionshipContent').each(function(){
                $(this).mCustomScrollbar('update');
            });
        }
    });
};

/**
 * Show Guest popup
 */
function showGuestPopup() {
    // Close side menu
    var menu = $('#leftMenu');
    if(menu.is(':visible')) {
        showHideLeftMenu();
    }
    
    // Close right menu
    var rightMenu = $('#headerRightMenu');
    if(rightMenu.is(':visible')) {
        showHideRightMenu();
    }
    
    // Close some popup
    if ($('#dlgPopupReviewSubmit').is(':visible')) {
        $('#dlgPopupReviewSubmit').fadeOut('fast');
        $("#wrapPanelUnderSpot").fadeOut('fast');
    }
    if ($('#dlgPopupReviewComment').is(':visible')) {
        $('#dlgPopupReviewComment').fadeOut('fast');
        $("#wrapPanelUnderSpot").fadeOut('fast');
    }
        
    // Init
    var guestPopup = $('#dlgPopupGuest');
    
    scalePopup(guestPopup);
    
    // Show popup
    if(!guestPopup.is(':visible')) {
        guestPopup.fadeIn('fast');
        $("#wrapPanelMain").fadeIn('slow');
    }
    
    // Close Setting dialog
    $("#wrapPanelMain, #dlgPopupGuestCancel").on('click', function(){
        if (guestPopup.is(':visible')) {
            guestPopup.fadeOut('fast');
            $("#wrapPanelMain").fadeOut('slow');
        }
    });
    
    return false;
}

/**
 * Close left Spot
 */
function closeLeftUser() {
    closeAllSideView();
}

/**
 * Show left user view
 * 
 * @param {int} id
 * @param {boolean} openFromOutSide
 * @returns {Boolean}
 */
function showLeftUser(id, openFromOutSide) {
    if (id === undefined) {
        id = 0;
    }
    if (id == 0 && GUEST == 1) {
        return false;
    }
    var leftUser = $('#leftUser');
    
    if (openFromOutSide) {
        clearStack();
    }
    
    // Show user panel
    if (typeof openFromOutSide !== 'undefined' && openFromOutSide) {
        leftUser.find('#leftUserTitleBack').hide();
        closeAllSideView(function(){
            openSideView(SIDEVIEW_TYPE.USER_PROFILE, function(){
                loadUserInfo(id);
            }, true);
        });
    } else {
        leftUser.find('#leftUserTitleBack').show();
        openSideView(SIDEVIEW_TYPE.USER_PROFILE, function () {
            loadUserInfo(id);
        }, false);
    }
    
    return false;
}

/**
 * Load user's info by ajax
 * 
 * @param {int} id
 */
function loadUserInfo(id) {
    var url = BASE_URL + '/users/profile/'+id;
    
    $('#userPageBody').html('');
    $('#leftSideViewLoader').show();
    
    ajaxUserPage = $.ajax({
        cache: false,
        async: true,
        type: 'get',
        url: url,             
        beforeSend: function() {
            return true;
        },
        success: function (response) {
            // TODO: Hide loader
            $('#leftSideViewLoader').hide();
            $('#userPageBody').html(response);
            
            $('#leftUserContainer').mCustomScrollbar('destroy');
            $('#leftUserContainer').mCustomScrollbar(mCustomScrollbarLeftUserOption);
            $('#leftUserNav').removeClass('leftUserNavFixed');
            
            // auto scroll when click navigator bar
            leftUserNavClick();
            
            initJsAjaxSubmit();
        },
        error: function() {
            $('#leftSideViewLoader').hide();
        }
    });
}

/**
 * Show Share Url popup
 * @param {string} url
 */
function showShareUrlPopup(url) {
    // Init
    var shareUrlPopup = $('#dlgPopupShareUrl');
    
    scalePopup(shareUrlPopup);
    
    $('#shareUrlInput').val(url);
    // Show popup
    if(!shareUrlPopup.is(':visible')) {
        closeAllPopup();
        shareUrlPopup.fadeIn('fast');
        $("#wrapPanelMain").fadeIn('slow');
    }
    
    // Close Setting dialog
    $("#wrapPanelMain, #dlgPopupShareUrlClose").on('click', function(){
        if (shareUrlPopup.is(':visible')) {
            shareUrlPopup.fadeOut('fast');
            $("#wrapPanelMain").fadeOut('slow');
            try {
                $('#shareUrlInput').select();
                document.execCommand("copy");
            } catch(err) {
                
            }
        }
    });
}

/**
 * Open popup view to add comment
 * 
 * @param {int} id
 * @param {int} google_place_id
 */
function showReviewSubmitPopup(id, google_place_id) {
    // Init
    var reviewSubmitPopup = $('#dlgPopupReviewSubmitContainer');
    
    var updateReviewFacility = function() {
        var _dlgPopupReviewContentNo = $('#dlgPopupReviewContentNo');
        var _dlgPopupReviewSubmitContainer = $('#dlgPopupReviewSubmitContainer');
        var _count = 0;
        var _found = false;
        
        var _more = _dlgPopupReviewContentNo.find('.dlgPopupAdvancedSearchTopEquipmentItem.physicalTypeMore');
        _more.hide();
        for (var i = 0; i < facilityList.length; i++) {
            var _checked = _dlgPopupReviewSubmitContainer.find('#dlgPopupReviewSubmitFacility_' + facilityList[i]).prop('checked');
            if (_checked) {
                _found = true;
                if (_count < 3) {
                    _dlgPopupReviewContentNo.find('.dlgPopupAdvancedSearchTopEquipmentItem[data-id="' + facilityList[i] + '"]').show();
                    _count++;
                } else if (_count >= 3) {
                    _more.show();
                    break;
                }
                
            } else {
                _dlgPopupReviewContentNo.find('.dlgPopupAdvancedSearchTopEquipmentItem[data-id="' + facilityList[i] + '"]').hide();
            }
        }
        
        if (!_found) {
            $('#dlgPopupReviewContentNoEmpty').show();
        } else {
            $('#dlgPopupReviewContentNoEmpty').hide();
        }
    };
    
    //scalePopup(reviewSubmitPopup);
    
    $('#dlgPopupReviewSubmit #place_id').val(id);
    $('#dlgPopupReviewSubmit #google_place_id').val(google_place_id);
    
    // Reset popup data
    reviewSubmitPopup.find('#review_point').val('0');
    reviewSubmitPopup.find('#place_review_id').val('');
    reviewSubmitPopup.find('textarea').val('');
    reviewSubmitPopup.find('.dlgPopupReviewSubmitLevelFace').removeClass('on');
    reviewSubmitPopup.find('#dlgPopupReviewSubmitLevelNumber').html('-');
    reviewSubmitPopup.find('.leftSpotEditEntranceStepsRange').removeClass('on');
    reviewSubmitPopup.find('#leftSpotEditEntranceStepsText').html('-');
    reviewSubmitPopup.find('input[type="checkbox"]').prop('checked', false);
    reviewSubmitPopup.find('input[type="text"]').val('');
    reviewSubmitPopup.find('input[type="file"]').val('');
    $('#dlgPopupReviewSubmit #dlgPopupReviewSubmitFile2').hide();
    $('#dlgPopupReviewSubmit #dlgPopupReviewSubmitFile3').hide();
    $('#dlgPopupReviewSubmit #dlgPopupReviewSubmitFile4').hide();
    $('#dlgPopupReviewSubmit #dlgPopupReviewSubmitFile5').hide();
    var dlgPopupReviewSubmitBtnPost = $('#dlgPopupReviewSubmitBtnPost');
    dlgPopupReviewSubmitBtnPost.text(dlgPopupReviewSubmitBtnPost.attr('data-text-create'));
    
    // Set title
    var dlgPopupReviewSubmitTitle = $('#dlgPopupReviewSubmitTitle');
    dlgPopupReviewSubmitTitle.text(dlgPopupReviewSubmitTitle.attr('data-title-empty'));
    var leftSpotDetailTitleText = $('#leftSpotDetailTitleText');
    if (leftSpotDetailTitleText.length > 0 && $.trim(leftSpotDetailTitleText.text()) !== '') {
        dlgPopupReviewSubmitTitle.text($.trim(leftSpotDetailTitleText.text()));
    }
    
    if (__myReview !== null && __myReview && typeof __myReview === 'object') {
        reviewSubmitPopup.find('#place_review_id').val(__myReview.id);
        reviewSubmitPopup.find('#dlgPopupReviewSubmitCommentValue').val(__myReview.comment);
        setReviewPointIcon(__myReview.review_point);
        markSpotEntranceStep(__myReview.entrance_steps);
        
        for (var i = 0; i < facilityList.length; i++) {
            if (__myReview[facilityList[i]] && __myReview[facilityList[i]] > 0) {
                reviewSubmitPopup.find('#dlgPopupReviewSubmitFacility_' + facilityList[i]).prop('checked', true);
            }
        }
        dlgPopupReviewSubmitBtnPost.text(dlgPopupReviewSubmitBtnPost.attr('data-text-update'));
    }
    
    updateReviewFacility();
    
    // Active Facility
    $('#dlgPopupReviewFacility .dlgPopupAdvancedSearchEquipmentItem').unbind('click').bind('click', function(){
        if ($(this).hasClass('on') === false) {
            $(this).addClass('on');              
        } else {           
            $(this).removeClass('on');
        }
    });
    
    // Update Facility
    $('#dlgPopupReviewFacility .dlgPopupAdvancedSearchEquipmentButton').unbind('click').bind('click', function(){
        var dlgPopupReviewFacilityContainer = $('#dlgPopupReviewFacilityContainer');
        dlgPopupReviewFacilityContainer.find('.dlgPopupAdvancedSearchEquipmentItem').each(function(){
            var _checked = $(this).hasClass('on');
            var _data_id = $(this).attr('data-id');
            reviewSubmitPopup.find('#dlgPopupReviewSubmitFacility_' + _data_id).prop('checked', _checked);
        });
        updateReviewFacility();
        
        $('#dlgPopupReviewFacilityContainer').hide();
        $('#dlgPopupReviewSubmitForm').fadeIn('fast');
    });
    
    // Show Facility
    $('#dlgPopupReviewContentNo').unbind('click').bind('click', function(){
        // Show
        var dlgPopupReviewFacilityContainer = $('#dlgPopupReviewFacilityContainer');
        
        for (var i = 0; i < facilityList.length; i++) {
            var _checked = reviewSubmitPopup.find('#dlgPopupReviewSubmitFacility_' + facilityList[i]).prop('checked');
            var _item = dlgPopupReviewFacilityContainer.find('.dlgPopupAdvancedSearchEquipmentItem[data-id="' + facilityList[i] + '"]');
            if (_item.length > 0) {
                if (_checked) {
                    _item.addClass('on');
                } else {
                    _item.removeClass('on');
                }
            }
        }
        
        $('#dlgPopupReviewSubmitForm').hide();
        dlgPopupReviewFacilityContainer.fadeIn('fast');
    });
    
    $('#dlgPopupReviewFacilityContainer .dlgPopupAdvancedSearchEquipmentClose').unbind('click').bind('click', function() {
        // Hide
        $('#dlgPopupReviewFacilityContainer').hide();
        $('#dlgPopupReviewSubmitForm').fadeIn('fast');
    });
    
    // Delete file
    $('.dlgPopupReviewSubmitFile .button-delete-file').unbind('click').bind('click', function(){
        var parent = $(this).closest('.dlgPopupReviewSubmitFile');
        var id = parent.attr('id');
        
        parent.find('input[type="file"]').val('');
        parent.find('input[type="text"]').val('');
        
        if (id == 'dlgPopupReviewSubmitFile1') {
            // First item
        } else {
            parent.hide();
        }
    });
    
    // Show popup
    if(!reviewSubmitPopup.is(':visible')) {
        closeAllPopup();
        
        // TODO: move map        
        reviewSubmitPopup.fadeIn('fast');
        reviewSubmitPopup.animate({scrollTop: 0}, 'fast');
    }
    
    // Close Setting dialog
    /*$('#dlgPopupReviewSubmitContainer').on('click', function (e) {
        if (e.target !== this) {
            // Not click to a child
            return false;
        }

        if (reviewSubmitPopup.is(':visible')) {
            reviewSubmitPopup.fadeOut('fast');
            $("#wrapPanelUnderSpot").fadeOut('slow');
        }
    });*/
    
    // Close Setting dialog
    $("#dlgPopupReviewSubmitBtnCancel").unbind('click').bind('click', function(){
        if (reviewSubmitPopup.is(':visible')) {
            reviewSubmitPopup.fadeOut('fast');
            $("#wrapPanelUnderSpot").fadeOut('slow');
        }
    });
}

function callbackReviewSubmit(place_id, google_play_id, place_detail) {
    // KienNH, 2016/02/26 begin
    if (place_detail) {
        addEditPlaceStack(place_detail);
    }
    // KienNH end
    
    loadDetailSpot(place_id, 1, google_play_id);
    for (i = 1; i <= 5; i++) {
        $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelFace' + i).removeClass('on');
    }
    $('#dlgPopupReviewSubmitForm #dlgPopupReviewSubmitLevelNumber').html('-');
    $('#dlgPopupReviewSubmitForm form')[0].reset();
    $('#dlgPopupReviewSubmitBtnCancel').click();    
}

$(document).on('change', '.btn-file :file', function () {
    var input = $(this);
    var numFiles = input.get(0).files ? input.get(0).files.length : 1;
    var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
    
    if (input.val() != '') {
        if (input.attr('id') == 'image_path1') {
            $('#dlgPopupReviewSubmit #dlgPopupReviewSubmitFile2').show();
        }
        if (input.attr('id') == 'image_path2') {
            $('#dlgPopupReviewSubmit #dlgPopupReviewSubmitFile3').show();
        }
        if (input.attr('id') == 'image_path3') {
            $('#dlgPopupReviewSubmit #dlgPopupReviewSubmitFile4').show();
        }
        if (input.attr('id') == 'image_path4') {
            $('#dlgPopupReviewSubmit #dlgPopupReviewSubmitFile5').show();
        }
    }
    //$(this).parents('.input-group').find('.button-delete-file').show();
});

$(document).ready(function () {
    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text');
        var log = numFiles > 1 ? numFiles + ' files selected' : label;
        if (input.length) {
            input.val(log);
        }
    }); 
});

/**
 * Open popup Review Comment
 * 
 * @param {int} reviewId
 */
function showReviewCommentPopup(reviewId) {
    // Init
    var reviewCommentPopup = $('#dlgPopupReviewComment');
    
    scalePopup(reviewCommentPopup);
    
    var url = BASE_URL + '/places/review/'+reviewId;
    $.ajax({
        cache: false,
        async: true,
        type: 'get',
        url: url,             
        beforeSend: function() { 
            $('#dlgPopupReviewComment').html('');
            return true;
        },
        success: function (response) {
            $('#dlgPopupReviewComment').html(response);
            initJsAjaxSubmit('#dlgPopupReviewComment');
            guestMode();
            $('#dlgPopupReviewCommentItems').mCustomScrollbar(mCustomScrollbarOption);
            // Close Setting dialog
            $("#dlgPopupReviewCommentBtnCancel").on('click', function(){
                if (reviewCommentPopup.is(':visible')) {
                    reviewCommentPopup.fadeOut('fast');
                    $("#wrapPanelUnderSpot").fadeOut('slow');
                }
            });
        }
    });
    
    
    // Show popup
    if(!reviewCommentPopup.is(':visible')) {
        closeAllPopup();
        reviewCommentPopup.fadeIn('fast', function(){
            // Fix layout
            $('#dlgPopupReviewCommentContainer').outerHeight(reviewCommentPopup.outerHeight() - $('#dlgPopupReviewCommentHeader').outerHeight()).mCustomScrollbar('update');
        });        
        $("#wrapPanelUnderSpot").fadeIn('slow');
    }
    
    // Close Setting dialog
    $("#wrapPanelUnderSpot").on('click', function(){
        if (reviewCommentPopup.is(':visible')) {
            reviewCommentPopup.fadeOut('fast');
            $("#wrapPanelUnderSpot").fadeOut('slow');
        }
    });
    
}

submitComment = function($this) {
    if (jQuery.trim($('#dlgPopupReviewCommentInput').val()) == '') {
        return false;
    }
    var frm = $($this); 
    $.ajax({
        cache: false,
        async: false,
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm !== undefined ? frm.serialize() : null,
        beforeSend: function() {           
            return true;
        },
        success: function (response) {   
            var result = JSON.parse(response);                           
            if (result.status !== undefined && result.status == 'ok') {   
                var cnt = parseInt($('#dlgPopupReviewCommentTotalComment span').html()) + 1;
                $('#dlgPopupReviewCommentTotalComment span').html(cnt);
                if ($('.count-comment-'+result.review_id).length > 0) {
                    $('.count-comment-'+result.review_id).html(cnt);
                }
                $('#dlgPopupReviewCommentNewItem .dlgPopupReviewCommentItemDate').html(result.date);
                $('#dlgPopupReviewCommentNewItem .dlgPopupReviewCommentItemDetail').html(result.comment);
                $($('#dlgPopupReviewCommentNewItem').html()).insertAfter('#dlgPopupReviewCommentNewItem');
                $('#dlgPopupReviewCommentInput').val(''); 
                $('#dlgPopupReviewCommentItems').mCustomScrollbar('update');
            }
            return false;
        }
    }); 
    return false;
};

guestMode = function() { 
    if (GUEST == 0) {
        return false;  
    }
    $(".follow").removeClass('.ajax-submit');
    $(".unfollow").removeClass('.ajax-submit');
    $(".like").removeClass('.ajax-submit');
    $(".unlike").removeClass('.ajax-submit');
    $(".follow").unbind('follow');
    $(".unfollow").unbind('unfollow');
    $(".like").unbind('click');
    $(".unlike").unbind('click');
    $("#headerRightMenuUser").unbind('click');
    $("#leftSpotEditSubmit").unbind('click');
    $("#dlgPopupReviewSubmitBtnPost").unbind('click');
    $("#dlgPopupReviewCommentBtnPost").unbind('click');
    $("#headerRightMenuChangeTeam").unbind('click');
    $("#leftMenuItemChampionship a").unbind('click');
    $("#headerRightMenuUser, \n\
        #headerRightMenuNotice, \n\
        #headerRightMenuSetting, \n\
        #headerRightMenuChangeInfo, \n\
        #headerRightMenuChangePassword, \n\
        #leftMenuItemChampionship a, \n\
        #leftMenuItemGoPlaces, \n\
        #leftMenuItemMyTimeline, \n\
        #dlgPopupReviewSubmitBtnPost, \n\
        #dlgPopupReviewCommentBtnPost, \n\
        #leftSpotEditSubmit, \n\
        .follow, \n\
        .unfollow, \n\
        .like, \n\
        .unlike, \n\
        #headerRightMenuChangeTeam"
    ).on('click', function(){
        return showGuestPopup();
    });
};

/**
 * Hide right menu if click outside it
 * 
 * @param {event} e
 */
$(document).on('click', function (e) {
    var rightBox = $('#headerRightBox');
    var rightMenu = $('#headerRightMenu');

    // Check if click outside of right box
    if (!rightBox.is(e.target) // if the target of the click isn't the container...
            && rightBox.has(e.target).length === 0) // ... nor a descendant of the container
    {
        // Hide right menu
        if(rightMenu.is(':visible')) {
            rightBox.removeClass('active');
            rightMenu.slideUp(100, function () {

            });
        }
    }
    
    // Check if click outsize of left menu
    var leftBox = $('#headerLeftMenu');
    var leftMenu = $('#leftMenu');
    if (!leftBox.is(e.target) && leftBox.has(e.target).length === 0) {
        // Hide left menu
        if(leftMenu.is(':visible')) {
            showHideLeftMenu();
        }
    }
    
    $('#leftRankingTraveler').unbind('click');
    $('#leftRankingTraveler').on('click', function(){ 
        var tab = $(this).data('tab');
        if (tab == undefined || tab == '' || tab == '1') {
            $(this).data('tab', '2');
        } else {
            $(this).data('tab', '1');
        }
        loadRankingSpot();             
        var aText = $('#leftRankingHeader span').html();
        var bText = $(this).html();
        $(this).html(aText);
        $('#leftRankingHeader span').html(bText);
    });
});

/**
 * Hide all Left Spot Header button
 */
function hideLeftSpotHeaderBtn() {
    $('#leftSpotSearchTypeCategory, #leftSpotSearchTypeAdvanced').each(function(){
        $(this).css('display', 'none');
    });
}

/*
 * Show hide left sideview
 */
function showHideLeftSideView() {
    var leftSideView = $('#leftSideView');
    var sideViewShowing = isLeftSideViewShowing();
    var left = sideViewShowing ? sideLeftHide : sideLeftShow;
    
    leftSideView.animate({left: left}, speedSpot, function(){
        // Set button status
        if (!sideViewShowing) {
            leftSideView.find('#leftSideViewHide').removeClass('on');
        } else {
            leftSideView.find('#leftSideViewHide').addClass('on');
        }
    });
    
    return false;
}

/**
 * Check left sideview is showing or hiding
 * @returns {Boolean}
 */
function isLeftSideViewShowing() {
    return $('#leftSideView').offset().left >= 0;
}

/**
 * Check left menu is showing or hiding
 * @returns {Boolean}
 */
function isLeftMenuShowing() {
    return $('#leftUser').offset().left >= 0;
}

/**
 * Check left spot is showing or hiding
 * @returns {Boolean}
 */
function isLeftSpotShowing() {
    return $('#leftSpot').offset().left >= 0;
}

/**
 * Check left spot detail is showing or hiding
 * @returns {Boolean}
 */
function isLeftSpotDetailShowing() {
    return $('#leftSpotDetail').offset().left >= 0;
}

/**
 * Close left Spot
 */
function closeLeftSpotDetail() {
    closeAllSideView();
}

function closeAllPopup() {
    $('.wrapPanel').fadeOut('fast');
    $('.dlgPopoup').fadeOut('fast');
}

/**
 * Show spot info from spot detail view
 */
function goSpotInfoFromDetail() {
    $('#leftSpotContainerDetail').hide();
    $('#leftSpotContainerInfo').show();
    $('#leftSpotContainerEdit').hide(); 
    closeAllPopup();
    
    setLeftViewContentHeight();// Update scroll
    $('#leftSpotInfoContainer').mCustomScrollbar(mCustomScrollbarOption);
}

/**
 * Show spot edit from spot info view
 */
function goSpotEditFromInfo() {
    $('#leftSpotContainerDetail').hide();
    $('#leftSpotContainerInfo').hide();
    $('#leftSpotContainerEdit').show();
    
    setLeftViewContentHeight();// Update scroll
    $('#leftSpotEditContainer').mCustomScrollbar(mCustomScrollbarOption);
}

/**
 * Set height for scroll view
 */
function setLeftViewContentHeight() {
    var leftSideView = $('#leftSideView');
    if (leftSideView.length > 0) {
        // 
        var leftSpotHeader = $('#leftSpotHeader');
        var leftSpotScrollMain = $('#leftSpotScrollMain');
        if (leftSpotHeader.length > 0 && leftSpotScrollMain.length > 0) {
            leftSpotScrollMain.height(leftSideView.outerHeight() - leftSpotHeader.outerHeight());
        }
        
        // Spot ranking
        var leftRankingHeader = $('#leftRankingHeader');
        var leftRankingCategories = $('#leftRankingCategories');
        var leftSpotScrollRanking = $('#leftSpotScrollRanking');
        if (leftRankingHeader.length > 0 && leftRankingCategories.length > 0 && leftSpotScrollRanking.length > 0) {
            leftSpotScrollRanking.height(leftSideView.outerHeight() - leftRankingHeader.outerHeight() - leftRankingCategories.outerHeight());
        }
        
        // User ranking
        var leftUserRankingScroll = $('#leftUserRankingScroll');
        var leftUserRankingHeader = $('#leftUserRankingHeader');
        if (leftUserRankingHeader.length > 0 && leftUserRankingScroll.length > 0) {
            leftUserRankingScroll.height(leftSideView.outerHeight() - leftUserRankingHeader.outerHeight());
        }
    }
    
    var leftSpotDetail = $('#leftSpotDetail');
    if (leftSpotDetail.length > 0) {
        // 
        var leftSpotDetailHeaderContainer = $('#leftSpotDetailHeaderContainer');
        var leftSpotDetailContainer = $('#leftSpotDetailContainer');
        if (leftSpotDetailHeaderContainer.length > 0 && leftSpotDetailContainer.length > 0) {
            leftSpotDetailContainer.height(leftSpotDetail.outerHeight() - leftSpotDetailHeaderContainer.outerHeight());
        }
        
        // 
        var leftSpotInfoHeaderContainer = $('#leftSpotInfoHeaderContainer');
        var leftSpotInfoContainer = $('#leftSpotInfoContainer');
        if (leftSpotInfoHeaderContainer.length > 0 && leftSpotInfoContainer.length > 0) {
            leftSpotInfoContainer.height(leftSpotDetail.outerHeight() - leftSpotInfoHeaderContainer.outerHeight());
        }
        
        // 
        var leftSpotEditHeaderContainer = $('#leftSpotEditHeaderContainer');
        var leftSpotEditContainer = $('#leftSpotEditContainer');
        if (leftSpotEditHeaderContainer.length > 0 && leftSpotEditContainer.length > 0) {
            leftSpotEditContainer.height(leftSpotDetail.outerHeight() - leftSpotEditHeaderContainer.outerHeight());
        }
    }
}

/**
 * Close all side view
 * 
 * @param {function} callback
 */
function closeAllSideView(callback) {
    clearPlaceTypeFilter();
    if (map) {
        var markers = getMarkers();
        markerCollisionDetection(markers);
    }
    clearStack();
    unsetMarkerEffect();
    
    // Cancel ajax request
    abortAjaxRequest();
    
    // Close sideview
    var leftSideView = $('#leftSideView');
    leftSideView.animate({left: sideLeftHide}, speedSpot, function () {
        leftSideView.hide();
        $('#leftSpot').hide();
        $('#leftSpotDetail').hide();
        $('#leftUser').hide();
        
        $('#leftUserNav').removeClass('leftUserNavFixed');
        
        // Callback
        if (typeof callback === 'function') {
            callback();
        }
    });
}

/**
 * Cancel ajax request and remove ajax loader 
 */
function abortAjaxRequest() {
    try { ajaxSpotSearch.abort(); } catch(err) {}
    try { ajaxLeftRanking.abort(); } catch(err) {}
    try { ajaxLeftRecommentSpot.abort(); } catch(err) {}
    try { ajaxLeftUserRanking.abort(); } catch(err) {}
    
    // Remove load more
    $('.leftSideViewLoaderMoreRecommendSpot').remove();
}

/**
 * Scale popup before show it
 * 
 * @param {object} popup
 * @param {int} exHeight
 */
function scalePopup(popup, exHeight) {
    // Check popup
    if (typeof popup !== 'object') {
        // Get popup displaying
        $('.dlgPopoup').each(function(){
            if ($(this).is(':visible')) {
                popup = $(this);
                return false;
            }
        });
    }
    
    // Again check popup
    if (typeof popup !== 'object') {
        return false;
    }
    
    // Init
    var marginTop = 14 * 2;/* height of close button - outside popup */
    var zoomNumber = 1;
    
    // Get view height
    var viewHeight = $('#mainContainer').height();
    
    // Get popup height
    var popupHeight = popup.outerHeight();
    
    // Fix height for IE
    var ieVersion = detectIE();
    if (ieVersion) {
        popup.css('margin-top', '-' + popupHeight / 2 + 'px');
    }
    
    if (typeof exHeight !== 'undefined') {
        popupHeight += exHeight;
    }
    
    // Check for scale
    if (popupHeight + marginTop > viewHeight) {
        zoomNumber = viewHeight / (popupHeight + marginTop);
    }
    
    // Scale
    if (Modernizr.testProp('transform') === true) {
        var scale = 'scale(' + zoomNumber + ')';
        popup
            .css('-ms-transform', scale)
            .css('-moz-transform', scale)
            .css('-o-transform', scale)
            .css('-webkit-transform', scale)
            .css('transform', scale);
    } else {
        popup.css('zoom', zoomNumber);
    }
}

/**
 * Open popup Review Comment
 * 
 * @param {int} userId
 */
function showFollowPopup(userId) {
    // Init
    var followPopup = $('#dlgPopupFollow');
    
    scalePopup(followPopup);
    
    var url = BASE_URL + '/users/follow/'+userId;
    $.ajax({
        cache: false,
        async: true,
        type: 'get',
        url: url,             
        beforeSend: function() { 
            followPopup.html('');
            return true;
        },
        success: function (response) {
            followPopup.html(response);
            initJsAjaxSubmit('#followPopup');
            guestMode();
            $('#dlgPopupFollowItems').mCustomScrollbar(mCustomScrollbarOption);
            // Close Setting dialog
            $("#dlgPopupFollowBtnCancel").on('click', function(){
                if (followPopup.is(':visible')) {
                    followPopup.fadeOut('fast');
                    $("#wrapPanelUnderSpot").fadeOut('slow');
                }
            });
        }
    });
    
    
    // Show popup
    if(!followPopup.is(':visible')) {
        closeAllPopup();
        followPopup.fadeIn('fast', function(){
            // Fix layout
            $('#dlgPopupFollowContainer').outerHeight(followPopup.outerHeight() - $('#dlgPopupFollowHeader').outerHeight()).mCustomScrollbar('update');
        });        
        $("#wrapPanelUnderSpot").fadeIn('slow');
    }
    
    // Close Setting dialog
    $("#wrapPanelUnderSpot").on('click', function(){
        if (followPopup.is(':visible')) {
            followPopup.fadeOut('fast');
            $("#wrapPanelUnderSpot").fadeOut('slow');
        }
    });
    
}

function closePopupChampionship() {
    var championInfoPopup = $("#dlgPopupChampionship");
    if (championInfoPopup.is(':visible')) {
        championInfoPopup.fadeOut('fast');
    }
    var championInfoPopup = $('#dlgPopupChampionInfo');
    if (championInfoPopup.is(':visible')) {
        championInfoPopup.fadeOut('fast');        
    }
    $("#wrapPanelTop").fadeOut('slow');
}

function closePopupTeamSelect() {
    var teamSelectPopup = $('#dlgPopupTeamSelect');
    if (teamSelectPopup.is(':visible')) {
        teamSelectPopup.fadeOut('fast');       
    }
    var dlgPopupTeamCreate = $('#dlgPopupTeamCreate');
    if (dlgPopupTeamCreate.is(':visible')) {
        dlgPopupTeamCreate.fadeOut('fast');        
    }
    $("#wrapPanelTop").fadeOut('slow');
}

/**
 * Show popup select team
 * @param {boolean} showChampionship
 */
function showSelectTeamPopup(showChampionship) {
    
    closePopupChampionship();
        
    // Hide Champion info popup
    $('#dlgPopupChampionInfoBtnClose').click();
    
    // Init
    var teamSelectPopup = $('#dlgPopupTeamSelect');
    scalePopup(teamSelectPopup);
    
    if (typeof showChampionship !== 'undefined' && showChampionship) {
        teamSelectPopup.find('#dlgPopupTeamSelectBtnUpdate').show();
        teamSelectPopup.find('#dlgPopupTeamSelectBtnUpdateAndClose').hide();
    } else {
        teamSelectPopup.find('#dlgPopupTeamSelectBtnUpdate').hide();
        teamSelectPopup.find('#dlgPopupTeamSelectBtnUpdateAndClose').show();
    }
    
    // Set value
    $('#dlgPopupTeamSelectTeamInputId').val(TEAM_ID);
    $('#dlgPopupTeamSelectTeamInputName').val(TEAM_NAME);
    $('#dlgPopupTeamSelectTeamInputName').typeahead('val', TEAM_NAME);
    
    $('#dlgPopupTeamCreateBtnUpdate').unbind('click').bind('click', function () {
        createTeam(showChampionship);
    });
    
    // Show popup
    if (!teamSelectPopup.is(':visible')) {
        teamSelectPopup.fadeIn('fast');
        $("#wrapPanelMain").fadeIn('slow');
    }

    // Close Setting dialog
    $("#wrapPanelMain").on('click', function () {
        if (teamSelectPopup.is(':visible')) {
            teamSelectPopup.fadeOut('fast');
            $("#wrapPanelMain").fadeOut('slow');
        }
    });
}

/**
 * Check user has bean registed team
 * @returns {Boolean}
 */
function hasTeam() {
    return typeof TEAM_ID !== 'undefined' && TEAM_ID > 0;
}

/**
 * Show Champion info popup
 */
function showChampionInfoPopup() {
    var championInfoPopup = $('#dlgPopupChampionInfo');
    scalePopup(championInfoPopup);
    
    if (hasTeam()) {
        championInfoPopup.find('#dlgPopupChampionInfoBtnStart').hide();
        championInfoPopup.find('#dlgPopupChampionInfoBtnClose').show();
    } else {
        championInfoPopup.find('#dlgPopupChampionInfoBtnStart').show();
        championInfoPopup.find('#dlgPopupChampionInfoBtnClose').hide();
    }
    
    // Show popup
    if (!championInfoPopup.is(':visible')) {
        championInfoPopup.fadeIn('fast');
        $("#wrapPanelChampionInfo").fadeIn('slow');
    }

    // Close Setting dialog
    $("#wrapPanelChampionInfo, #dlgPopupChampionInfoBtnClose").on('click', function () {
        if (championInfoPopup.is(':visible')) {
            championInfoPopup.fadeOut('fast');
            $("#wrapPanelChampionInfo").fadeOut('slow');
        }
    });
}

/**
 * Show popup for creating new Team
 */
function showCreateTeamPopup() {
        
    // Close select team popup
    var teamSelectPopup = $('#dlgPopupTeamSelect');
    teamSelectPopup.fadeOut('fast');
    
    var teamCreatePopup = $('#dlgPopupTeamCreate');
    scalePopup(teamCreatePopup);
    
    // Reset value
    $('#dlgPopupTeamCreateInputTeamName').val('');
    $('#dlgPopupTeamCreateInputTeamSection').val('');
    $('.leftSpotEditCustomSelectbox').selectpicker('refresh');
    
    // Show popup
    if (!teamCreatePopup.is(':visible')) {
        teamCreatePopup.fadeIn('fast');
        $("#wrapPanelMain").fadeIn('slow');
    }

    // Close Setting dialog
    $("#wrapPanelMain").on('click', function () {
        if (teamCreatePopup.is(':visible')) {
            teamCreatePopup.fadeOut('fast');
            $("#wrapPanelMain").fadeOut('slow');
        }
    });
}

/**
 * Show popup select team from create team popup
 */
function goBackSelectTeamPopup() {
    // Hide create popup
    var teamCreatePopup = $('#dlgPopupTeamCreate');
    teamCreatePopup.fadeOut('fast');
    
    // Show select team popup
    var teamSelectPopup = $('#dlgPopupTeamSelect');
    scalePopup(teamSelectPopup);
    teamSelectPopup.fadeIn('fast');
}

/**
 * Update  team for current user
 * @param {boolean} showChampionship
 */
function updateTeam(showChampionship) {
    var team_name = jQuery.trim($('#dlgPopupTeamSelectTeamInputName').val());
    var team_id = jQuery.trim($('#dlgPopupTeamSelectTeamInputId').val());
    if (team_id == '' || team_name == '') {
        showErrorPopup(ERROR_MESSAGE_NAME_EMPTY);
        return false;
    }
    
    // Show loader
    var loader = $('.dlgPopoupLoader');
    loader.show();
    // Update team
    
    $.post(BASE_URL + '/ajax/tmpUpdateTeam', {
        team_id: team_id,
        name: team_name
    }, function(data){
        
        // Close loader
        loader.hide();
        
        // check result
        if (data.status == 200) {
            // Save OK
            // Close popup
            $("#wrapPanelMain").click();
            
            // Show championship
            // Update TEAM_ID and TEAM_NAME
            TEAM_ID = data.team_id;
            TEAM_NAME = data.team_name;
            
            $('#dlgPopupTeamSelectTeamInputId').val(TEAM_ID);
            $('#dlgPopupTeamSelectTeamInputName').val(TEAM_NAME);
            $('#dlgPopupTeamSelectTeamInputName').typeahead('val', TEAM_NAME);
            
            var message = MESSAGE_TEAM_CHANGED_JS.format(TEAM_NAME);
            showErrorPopup(message, showChampionshipPopup, LABEL_INFORMATION);
        } else {
            // Show error
            if (data.message !== undefined) {
                showErrorPopup(data.message);
            }
        }
    }, 'json');
}

/**
 * Create team for current user
 * @param {boolean} showChampionship
 */
function createTeam(showChampionship) {
    var team_name = jQuery.trim($('#dlgPopupTeamCreateInputTeamName').val());
    var team_section = jQuery.trim($('#dlgPopupTeamCreateInputTeamSection').val());
    if (team_name == '') {
        showErrorPopup(ERROR_MESSAGE_NAME_EMPTY);
        return false;
    }
    if (team_section == '') {
        showErrorPopup(ERROR_MESSAGE_SECTION_EMPTY);
        return false;
    }
    
    // Show loader
    var loader = $('.dlgPopoupLoader');
    loader.show();
   
    // Update team
    $.post(BASE_URL + '/ajax/tmpCreateTeam', {
        name: team_name,
        section: team_section
    }, function(data){
        // Close loader
        loader.hide();
        // check result
        if (data.status == 200) {
            // Save OK
            // Close popup
            $("#wrapPanelMain").click();
            
            // Update TEAM_ID and TEAM_NAME
            TEAM_ID = data.team_id;
            TEAM_NAME = data.team_name;
            
            $('#dlgPopupTeamSelectTeamInputId').val(TEAM_ID);
            $('#dlgPopupTeamSelectTeamInputName').val(TEAM_NAME);
            $('#dlgPopupTeamSelectTeamInputName').typeahead('val', TEAM_NAME);
            
            // Show championship
            var message = MESSAGE_TEAM_CHANGED_JS.format(TEAM_NAME);
            showErrorPopup(message, showChampionshipPopup, LABEL_INFORMATION);
        } else {
            // Save NG
            // TODO: show error 
            if (data.message !== undefined) {
                showErrorPopup(data.message);
            }                       
        }
    }, 'json');
}

/**
 * Show category popup when click on left menu
 * @param {string} url
 */
function showStaticHtmlPopup(url) {
    // Init
    var taticHtmlPopup = $('#dlgPopupStaticHtml');
    
    scalePopup(taticHtmlPopup);
    
    $('#dlgPopupStaticHtmlContent').html('');
    $('<iframe>', {
        src: url + (url.indexOf('?') >= 0 ? '&' : '?') + $.now(),
        frameborder: 0
    }).appendTo('#dlgPopupStaticHtmlContent');
    
    // Show popup
    if(!taticHtmlPopup.is(':visible')) {
        taticHtmlPopup.fadeIn('fast');
        $("#wrapPanelMain").fadeIn('slow');
    }
    
    // Close Setting dialog
    $("#wrapPanelMain").on('click', function(){
        if (taticHtmlPopup.is(':visible')) {
            taticHtmlPopup.fadeOut('fast');
            $("#wrapPanelMain").fadeOut('slow');
        }
    });
}

/**
 * Show popup error
 * @param {string} message
 * @param {function} callback
 * @param {string} title
 */
function showErrorPopup(message, callback, title) {
    var dlgTitle = (typeof title !== 'undefined' && title != '') ? title : LABEL_ERROR;
    var bb = bootbox.dialog({
        message: message,
        title: dlgTitle,
        className: 'bootbox-bmaps-alert',
        buttons: {
            close: {
                label: LABEL_CLOSE,
                className: "btn-bmaps",
                callback: function () {
                    bb.modal('hide');
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            }
        },
        onEscape: true,
        closeButton: false,
        backdrop: true
    });
    
    $('header').on('click', function(){
        try {
            bb.modal('hide');
        } catch(err){}
    });
}

/**
 * Show popup confirm before logout
 */
function confirmLogout() {
    var bc = bootbox.dialog({
        message: MESSAGE_CONFIRM_LOGOUT,
        className: 'bootbox-bmaps-alert',
        buttons: {
            OK: {
                label: 'OK',
                className: "btn-bmaps",
                callback: function () {
                    window.location.href = BASE_URL + '/logout';
                }
            },
            CANCEL: {
                label: LABEL_CANCEL,
                className: "btn",
                callback: function(){
                    bc.modal('hide');
                }
            }
        },
        onEscape: true,
        closeButton: false,
        backdrop: true
    });
    
    $('header').on('click', function(e){
        try {
            var logoutItem = $('#headerRightLogout');
            if (!logoutItem.is(e.target) // if the target of the click isn't the container...
            && logoutItem.has(e.target).length === 0) // ... nor a descendant of the container
            {
                bc.modal('hide');
            }
        } catch(err){}
    });
}

/**
 * Show confirm when delete spot
 * @param {int} placeId
 * @param {boolean} delFlg
 */
function confirmDeleteReportSpot(placeId, delFlg) {
    // Not allow Guest
    if (GUEST) {
        return showGuestPopup();
    }
    
    var title = delFlg ? MESSAGE_CONFIRM_DELETE_SPOT : MESSAGE_REPORT_SPOT;
    
    // Delete or Report
    var bbReportDelete = bootbox.dialog({
        message: title,
        className: 'bootbox-bmaps-alert',
        buttons: {
            OK: {
                label: 'OK',
                className: "btn-bmaps",
                callback: function () {
                    if (delFlg) {
                        deleteSpot(placeId);
                    } else {
                        showReportSpotPopup(placeId);
                    }
                }
            },
            CANCEL: {
                label: LABEL_CANCEL,
                className: "btn",
                callback: function(){
                    bbReportDelete.modal('hide');
                }
            }
        },
        onEscape: true,
        closeButton: false,
        backdrop: true
    });

    $('header').on('click', function(e){
        try {
            bbReportDelete.modal('hide');
        } catch(err){}
    });
}

/**
 * Show popup report spot
 * @param {Integer} placeId
 */
function showReportSpotPopup(placeId) {
    showMainLoader(true);
    $.get(BASE_URL + '/ajax/spot_report/' + placeId, function(data){
        showMainLoader(false);
        var popup = $('#dlgPopupSpotReport');
        popup.find('#dlgPopupSpotReportContent').html(data);
        
        // Show popup
        popup.fadeIn('fast');
        $("#wrapPanelMain").fadeIn('slow');
        
        // Close Setting dialog
        $("#wrapPanelMain, #dlgPopupSpotReportBtnCancel").on('click', function(){
            if (popup.is(':visible')) {
                popup.fadeOut('fast');
                $("#wrapPanelMain").fadeOut('slow');
            }
        });
        
        // Send report
        $('#dlgPopupSpotReportBtnSend').on('click', function(){
            var popup = $('#dlgPopupSpotReport');
            var place_id = popup.find("input[name='place_id']").val();
            var report_id = '';
            var report_comment = '';
            var selected = popup.find("input[name='report_id']:checked");
            if (selected.length > 0) {
                report_id = selected.val();
            }
            if (report_id == 'other') {
                report_id = '0';
                report_comment = popup.find('#dlgPopupSpotReportItemComment').val();
            }
            $('#dlgPopupSpotReportBtnCancel').click();
            showMainLoader(true);
            $.post(BASE_URL + '/ajax/send_spot_report', {
                place_id: place_id,
                report_id: report_id,
                report_comment: report_comment
            }, function(data){
                showMainLoader(false);
            }, 'json');
        });
    }).always(function() {
        showMainLoader(false);
    });
}

/**
 * Show/Hide main loader
 * @param {boolean} show
 */
function showMainLoader(show) {
    if (show) {
        $('#mainLoader').show();
    } else {
        $('#mainLoader').hide();
    }
}

/**
 * Delete Spot
 * @param {Integer} placeId
 */
function deleteSpot(placeId) {
    showMainLoader(true);
    $.post(BASE_URL + '/ajax/delete_spot', {
        place_id: placeId
    }, function(data){
        showMainLoader(false);
        if (data.status == 200) {
            // Delete OK: Remove spot on Map
            unsetMarkerEffect(true);
            backSideView();
        } else {
            // Delete NG: Show Error
            showErrorPopup(MESSAGE_CANNOT_DELETE_SPOT);
        }
    }, 'json');
}

/**
 * Get current Spot entrance step value when edit spot
 */
function getCurrentSpotEntranceSteps() {
    var currentValue = $('#leftSpotEditEntranceStepsValue').val();
    if (currentValue == '') {
        currentValue = '-1';
    }
    return parseInt(currentValue);
}

/**
 * Active face
 * @param {int} step
 */
function markSpotEntranceStep(step) {
    $('.leftSpotEditEntranceStepsRange').removeClass('on');
    //leftSpotEditEntranceStepsRange1-5
    /*
     * 0 -> 1
     * 1 -> 2
     * 2 -> 3
     * 3 -> 4
     * 4 -> 5
     */
    if (step !== '' && step >= 0) {
        for (var i = 0; i <= step; i++) {
            $('#leftSpotEditEntranceStepsRange' + (i + 1)).addClass('on');
        }
    }
}

/**
 * Fix style on IE
 */
function fixStyleIE() {
    return false;
    
    var ieVersion = detectIE();
    if (ieVersion) {
        // Fix container Height
        var containerHeight = $('#mainContainer').height();
        $('#articleContainer').height(containerHeight);
    }
}

/**
 * Restore mCustomScrollbar after destroy
 * @param {jquery object} container
 */
function restoreMCustomScrollbar(container) {
    if (container && container.length > 0) {
        container.find('.mCustomScrollbarMark').each(function () {
            $(this).removeClass('mCustomScrollbarMark');
            if ($(this).attr('id') === 'leftUserContainer') {
                $(this).mCustomScrollbar(mCustomScrollbarLeftUserOption);
                $('#leftUserNav').removeClass('leftUserNavFixed');
                leftUserNavClick();
            } else {
                $(this).mCustomScrollbar(mCustomScrollbarOption);
            }
            
            // Restore position
            try {
                var scroll_position = $(this).data('scroll_position');
                if (typeof scroll_position !== 'undefined' && scroll_position != '') {
                    $(this).mCustomScrollbar('scrollTo', scroll_position);
                }
            } catch (e) {}
        });
    }
}

/**
 * Action on left user nav
 */
function leftUserNavClick() {
    $('#leftUserNav li').on('click', function (e) {
        if ($('#leftUserNav').hasClass('leftUserNavFixed')) {
            var height = $('#leftUserTitle').outerHeight();
            height += $('#leftUserCover').outerHeight();
            height += $('#leftMenuProfileComment').outerHeight();
            height += $('#leftMenuFollowContainer').outerHeight();

            $('#leftUserContainer').mCustomScrollbar('scrollTo', height);
        }
        
        $('#leftUserNav li').removeClass('active');
        $(this).addClass('active');
        
        $('#leftUserNavContentContainer .tab-pane').removeClass('active');
        $('#leftUserNavContentContainer .tab-pane' + $(this).find('a').attr('href')).addClass('active');
    });
}

/**
 * Open left side view
 * 
 * @param {Enum} type
 * @param {Funtion} callback
 * @param {Boolean} ignoreBackupCurrentView
 */
function openSideView(type, callback, ignoreBackupCurrentView) {
    // Hide menu
    $('#leftMenu').hide();
    $('#wrapPanelTop').hide();
    abortAjaxRequest();// Cancel ajax request
    
    // Hide current view
    var leftSideView = $('#leftSideView');
    
    leftSideView.clearQueue().finish();
    leftSideView.animate({left: sideLeftHide}, speedSpot, function () {
        // Stack manage --------------------------------------------------------
        $('#leftSideView').find('.mCustomScrollbar').each(function () {
            $(this).addClass('mCustomScrollbarMark');
            $(this).mCustomScrollbar('destroy');
        });
        
        if (typeof ignoreBackupCurrentView !== 'undefined' && ignoreBackupCurrentView) {
            clearStack();
        } else {
            var leftSideViewData = $('#leftSideView').clone(true, true);
            var currentView = {
                type: type,
                data: leftSideViewData
            };
            SIDEVIEW_STACK.push(currentView);
        }
        restoreMCustomScrollbar($('#leftSideView'));
        leftSideView = $('#leftSideView');
        
        // Show necessary view -------------------------------------------------
        if (type === SIDEVIEW_TYPE.SPOT_RECOMMEND || type === SIDEVIEW_TYPE.SPOT_RANKING || 
                type === SIDEVIEW_TYPE.SPOT_SEARCH_KEYWORD || type === SIDEVIEW_TYPE.SPOT_SEARCH_ADVANCE || type === SIDEVIEW_TYPE.SPOT_SEARCH_CATEGORY) {
            // List
            $('#leftSpot').show();
            $('#leftSpotDetail').hide();
            $('#leftUser').hide();
            $('#leftUserRanking').hide();
            
            if (type === SIDEVIEW_TYPE.SPOT_RANKING) {
                $('#leftSpotContainer').hide();
                $('#leftRankingContainer').show();
            } else {
                $('#leftSpotContainer').show();
                $('#leftRankingContainer').hide();
            }
        } else if (type === SIDEVIEW_TYPE.SPOT_DETAIL) {
            // Detail
            $('#leftSpot').hide();
            $('#leftSpotDetail').show();
            $('#leftUser').hide();
            $('#leftUserRanking').hide();
        } else if (type === SIDEVIEW_TYPE.USER_PROFILE) {
            // User
            $('#leftSpot').hide();
            $('#leftSpotDetail').hide();
            $('#leftUser').show();
            $('#leftUserRanking').hide();
        } else if (type === SIDEVIEW_TYPE.USER_RANKING) {
            // User ranking
            // User
            $('#leftSpot').hide();
            $('#leftSpotDetail').hide();
            $('#leftUser').hide();
            $('#leftUserRanking').show();
        }
        
        // Clear view ----------------------------------------------------------
        $('#spotBody').html('');
        $('#leftRankingList').html('');
        $('#spotDetailBody').html('');
        $('#userPageBody').html('');
        
        // Show spot panel -----------------------------------------------------
        $('#leftSideViewLoader').show();
        leftSideView.show();
        leftSideView.attr('data-type', type);
        leftSideView.attr('data-page', '');
        leftSideView.clearQueue().finish();
        leftSideView.animate({left: sideLeftShow}, speedSpot, function () {
            leftSideView.find('#leftSideViewHide').removeClass('on');
            if (typeof(callback) === 'function') {
                callback();
            }
        });
    });
}

/**
 * Go back previous left side view
 */
function backSideView() {
    //goBackLeftSpotPanelList
    var previousView = SIDEVIEW_STACK.pop();
    
    if (typeof previousView !== 'undefined' && previousView) {
        var leftSideView = $('#leftSideView');
        var container = $('#asideContainer');
        var leftSideViewData = previousView.data;
        
        unsetMarkerEffect();
        closeAllPopup();// Close all popup
        
        // Hide and remove current side view
        leftSideView.clearQueue().finish();
        leftSideView.animate({left: sideLeftHide}, speedSpot, function () {
            leftSideView.remove();
            leftSideViewData.appendTo(container);
            leftSideView = $('#leftSideView');
            
            abortAjaxRequest();// Cancel ajax request
            updateListPlaceDetail();// KienNH, 2016/02/26 update spot detail
            reloadPlaceDetail();// KienNH, 2016/02/29
            
            // Show previous side view
            leftSideView.clearQueue().finish();
            leftSideView.animate({left: sideLeftShow}, speedSpot, function () {
                // Show previous side view success
                // Update scroll
                restoreMCustomScrollbar(leftSideView);
            });
        });
    } else {
        // Opp... Close all view
        closeAllSideView();
    }
    
    return false;
}

/**
 * Update list spot when 1 spot editted
 */
function updateListPlaceDetail() {
    try {
        var leftSideView = $('#leftSideView');
        var arrContainer = ['#leftRankingList', '#spotBody', '#luRegisteredSpot', '#luSubmissionsReviews'];
        
        if (EDIT_PLACE_STACK && EDIT_PLACE_STACK.length > 0) {
            for (var index = 0; index < arrContainer.length; index++) {
                var container = $(arrContainer[index]);
                if (leftSideView && leftSideView.find(container).length > 0) {
                    container.find('.leftSpotItem').each(function () {
                        var _this = $(this);
                        var id = _this.attr('data-id');
                        var google_place_id = _this.attr('data-google-place-id');

                        $.each(EDIT_PLACE_STACK, function (key, value) {
                            var stack_id = value.id;
                            var stack_google_place_id = value.google_place_id;
                            var stack_html = $(value.html);

                            if (id == stack_id && google_place_id == stack_google_place_id) {
                                if (_this.find('.leftRankingItemLevel').length > 0) {
                                    var level = _this.find('.leftRankingItemLevel').first();
                                    _this.html(stack_html.html());
                                    _this.find('.leftSpotItemTotalLike').remove();
                                    _this.find('.leftSpotItemLeftContent').prepend(level);
                                } else {
                                    _this.html(stack_html.html());
                                }
                                return false;
                            }
                        });
                    });
                }
            }
        }
    } catch (e) {}
}

/**
 * Reload spot detail
 */
function reloadPlaceDetail() {
    try {
        var leftSideView = $('#leftSideView');
        if (leftSideView.find('#leftSpotContainerDetail').length > 0 && EDIT_PLACE_STACK.length > 0) {
            // Init
            var leftSpotContainerDetail = leftSideView.find('#leftSpotContainerDetail');
            var place_id = leftSpotContainerDetail.attr('data-place_id');
            var google_place_id = leftSpotContainerDetail.attr('data-google_place_id');
            var found = false;
            
            // Find spot is updated or not?
            for (var i = 0; i < EDIT_PLACE_STACK.length; i++) {
                var place_stack = EDIT_PLACE_STACK[i];
                var stack_id = place_stack.id;
                var stack_google_place_id = place_stack.google_place_id;
                
                if (place_id == stack_id && google_place_id == stack_google_place_id) {
                    found = true;
                }
            }
            
            // Found: reload detail
            if (found) {
                var leftSpotDetailHeader = leftSideView.find('#leftSpotDetailHeader');
                var openFromOutSide = false;
                if (!leftSpotDetailHeader.is(':visible')) {
                    openFromOutSide = true;
                }
                loadDetailSpot(place_id, 1, google_place_id, null, openFromOutSide);
            }
        }
        
    } catch (e) {}
}

/**
 * Add Place detail to stack
 * @param {object} place_detail
 */
function addEditPlaceStack(place_detail) {
    try {
        if (EDIT_PLACE_STACK.length > 0) {
            // Delete old info
            for (var key = EDIT_PLACE_STACK.length - 1; key >= 0; key--) {
                var value = EDIT_PLACE_STACK[key];
                var stack_id = value.id;
                var stack_google_place_id = value.google_place_id;
                
                if (place_detail.id == stack_id && place_detail.google_place_id == stack_google_place_id) {
                    EDIT_PLACE_STACK.splice(key, 1);
                }
            }
        }
        EDIT_PLACE_STACK.push(place_detail);
    } catch (e) {}
}

/**
 * Clear sideview and place detail stack
 */
function clearStack() {
    SIDEVIEW_STACK = [];
    EDIT_PLACE_STACK = [];
}

/**
 * Load more data
 * @param {object} item
 */
function loadMoreListPlace(item) {
    var leftSideView = $(item).closest('#leftSideView');
    if (leftSideView.length > 0 && leftSideView.is(':visible')) {
        // Load more recommend
        if (leftSideView.attr('data-type') == SIDEVIEW_TYPE.SPOT_RECOMMEND) {
            // Page
            var page = leftSideView.attr('data-page');
            if (typeof page !== 'undefined') {
                if (page == LAST_PAGE) {
                    // Fetched all data, do nothing
                } else {
                    // Current page
                    if (page == '' || page <= 0) {
                        page = 1;
                    } else {
                        try {
                            page = parseInt(page, 10);
                        } catch (e) {
                            page = 1;
                        }
                    }
                    page++;// Next page
                    loadMoreRecommendSpot(page);// Load more
                }
            }
        }
        
        // TODO: Something else...
    }
}

var fnGetRequestParam = function(name) {
    if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search)) {
        return decodeURIComponent(name[1]);
    }
    return null;
};

/**
 * Show popup place review history
 * @param {int} place_id
 * @param {int} user_id
 */
var showPlaceReviewHistory = function(place_id, user_id) {
    if (place_id && user_id) {
        closeAllPopup();
        
        var dlgPopupPlaceReviewHistory = $('#dlgPopupPlaceReviewHistory');
        scalePopup(dlgPopupPlaceReviewHistory);
        
        dlgPopupPlaceReviewHistory.fadeIn('fast');
        $("#wrapPanelUnderSpot").fadeIn('slow');
        
        var url = BASE_URL + '/places/reviewhistory/' + place_id + '/' + user_id;
        $.ajax({
            cache: false,
            async: true,
            type: 'get',
            url: url,             
            beforeSend: function() {
                var loading = 'Loading...';
                if ($('.pageLoading').length > 0) {
                    loading = $('.pageLoading').html();
                }
                $('#dlgPopupPlaceReviewHistoryScroll').html(loading);
                return true;
            },
            success: function (response) {
                $('#dlgPopupPlaceReviewHistoryScroll').html(response);
            }
        });
        
        // Close Setting dialog
        $("#wrapPanelUnderSpot, #dlgPopupPlaceReviewHistoryClose").on('click', function () {
            if (dlgPopupPlaceReviewHistory.is(':visible')) {
                dlgPopupPlaceReviewHistory.fadeOut('fast');
                $("#wrapPanelUnderSpot").fadeOut('slow');
            }
        });
    }
};

/**
 * Get current location of map
 * 
 * @returns {object}
 */
function getCurrentMapLocation() {
    var latitude = getCookie(cookieLatitude);
    var longitude = getCookie(cookieLongitude);
    
    if (!latitude || !longitude) {
        if (map) {
            latitude = map.getCenter().lat();
            longitude = map.getCenter().lng();
        }
    }
    
    if (!latitude || !longitude) {
        return null;
    }
    
    return {
        lat: latitude,
        lng: longitude
    };
}
