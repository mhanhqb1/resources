<!DOCTYPE html>
<html lang="<?php echo !empty($lpLang2Digit) ? $lpLang2Digit : 'jp' ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Expires" content="0">
        
        <title><?php echo $title_for_layout ?></title>
        <link rel="shortcut icon" href="<?php echo BASE_URL ?>/favicon.ico" />
        
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/bootstrap-select.min.css"/>
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/lightbox.css"/>
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style.css?<?php echo date('Ymd') ?>" media="only screen and (min-width:640px)"/>
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style_sp.css?<?php echo date('Ymd') ?>" media="only screen and (max-width:639px)"/>
        <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style_ie.css?<?php echo date('Ymd') ?>">
        
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/jsrender.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/bootstrap-select.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/typeahead.bundle.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/modernizr-custom.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/jsconstants?<?php echo date('Ymd') ?>"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/common_func.js?<?php echo date('Ymd') ?>"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/common.js?<?php echo date('Ymd') ?>"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjPXrcBpNB17WboJyLWJx6KuIYnlcJ4EY&libraries=places"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/google_place_type.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/map.js"></script>
        <?php if (empty($AppUI->id)) : ?>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/login_action.js?<?php echo date('Ymd') ?>"></script>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/guest.js?<?php echo date('Ymd') ?>"></script>
        <script src="https://connect.facebook.net/en_US/all.js"></script>
        <script type="text/javascript">
            var fb_app_id = '<?php echo FACEBOOK_APP_ID ?>';
            $(function () {
                FB.init({
                    appId: fb_app_id,
                    cookie: true,
                    status: true,
                    oauth: true,
                    xfbml: true
                });
            });
        </script>
        <?php endif ?>
    </head>
    <body class="<?php echo !empty($lpLang2Digit) ? $lpLang2Digit : 'jp' ?>">
        <?php echo $this->element('header'); ?>
        <main>
            <div id="mainContainer">
                <div id="containerTable">
                    <div id="containerRow">
                        <aside>
                            <div id="asideContainer">
                                <?php echo $this->element('left_menu'); ?>
                                <div id="leftSideView" data-type="" data-page="">
                                    <div id="leftSideViewHide" class="btnWhite"></div>
                                    
                                    <?php echo $this->element('left_spot'); ?>
                                    <?php echo $this->element('left_spot_detail'); ?>
                                    <?php echo $this->element('left_user'); ?>
                                    <?php echo $this->element('user_ranking'); ?>
                                    
                                    <div id="leftSideViewLoader">
                                        <img src="<?php echo BASE_URL ?>/img/ajax_loader.gif"/>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <article>
                            <div id="articleContainer" class="container_<?php echo $this->params->params['controller'] ?>_<?php echo $this->params->params['action'] ?>">
                                <div class="content">
                                    <?php echo $this->Session->flash(); ?>
                                    <?php echo $this->fetch('content'); ?>
                                </div>
                                <?php echo $this->element('popup'); ?>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </main>
        <?php echo $this->element('footer'); ?>
        <div id="mainLoader">
            <div id="mainLoaderInner">
                <img src="<?php echo BASE_URL ?>/img/ajax_loader.gif"/>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo BASE_URL ?>/js/lightbox.min.js"></script>
        <script id="leftSpotItemTemplate" type="text/x-jsrender">
            <div class="leftSpotItem" data-key="{{:google_place_id}}-{{:id}}" data-id="{{:id}}" data-google-place-id="{{:google_place_id}}" data-type-id="{{:place_category_type_id}}" onclick="return goLeftSpotDetail($(this))">
                <div class="leftSpotItemLeft" style="background-image: url({{>place_image_path}})">
                </div>
                <div class="leftSpotItemLeftContent">
                    <div class="leftSpotItemTotalLike noselect">
                        <span class="leftSpotItemTotalLikeNumber">{{:count_follow}}</span><span><?php echo __('LABEL_PLACE_WANT_TO_GO');?></span>
                    </div>
                    <div class="leftSpotItemLeftAddress">
                        <!--div class="leftSpotItemLeftAddressTop">{{>name}}</div-->
                        <div class="leftSpotItemLeftAddressBot">{{>address}}</div>
                    </div>
                </div>
                <div class="leftSpotItemRight">
                    <div class="leftSpotItemRightTop">
                        <div class="leftSpotItemTitle">{{>name}}</div>
                        <div class="leftSpotItemReview">
                            <div class="leftSpotItemReviewIcon">
                                <img src="{{:~getCategoryIconUrl(place_category_type_id)}}">
                            </div>
                            <div class="leftSpotItemReviewDetail">
                                <div class="leftSpotItemReviewLabel">
                                    <?php echo __('LABEL_SPOT_REVIEW');?>
                                </div>
                                <div class="leftSpotItemReviewPoint">
                                    <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace1{{if review_point >= 1}} on{{/if}}"></div>
                                    <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace2{{if review_point >= 2}} on{{/if}}"></div>
                                    <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace3{{if review_point >= 3}} on{{/if}}"></div>
                                    <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace4{{if review_point >= 4}} on{{/if}}"></div>
                                    <div class="leftSpotItemReviewPointFace leftSpotItemReviewPointFace5{{if review_point >= 5}} on{{/if}}"></div>
                                    <span>
                                        {{if review_point == 0}}
                                            --
                                        {{else }}
                                            {{:review_point}}
                                        {{/if}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="leftSpotItemRightBot">
                        <div class="leftSpotItemEquipment">
                            <div class="leftSpotItemEquipmentLabel">
                                <?php echo __('LABEL_FACILITY_DETAIL');?>
                            </div>
                            {^{if #view.data.length}}
                            <div class="leftSpotItemEquipmentDetail">
                                {{for ~features(#view.data)}}{{if available}}
                                <div class="leftSpotItemEquipmentItem">
                                    <img src="{{:icon_url}}">
                                </div>
                                {{/if}}{{/for}}
                            </div>
                            {{else}}
                            <span class="spotNotReview">
                                <?php echo __('LABEL_REVIEW_NO_FACILITY') ?>
                            </span>
                            {{/if}}
                        </div>
                        <div class="leftSpotItemReviewChart">
                            <div class="leftSpotItemReviewChartLabel">
                                <?php echo __('LABEL_ENTRY_STEPS');?>
                            </div>
                            {{if entrance_steps != -1}}
                            <div class="leftSpotItemReviewChartDetail">
                                <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel1{{if entrance_steps >= 0}} on{{/if}}"></div>
                                <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel2{{if entrance_steps >= 1}} on{{/if}}"></div>
                                <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel3{{if entrance_steps >= 2}} on{{/if}}"></div>
                                <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel4{{if entrance_steps >= 3}} on{{/if}}"></div>
                                <div class="leftSpotItemReviewChartLevel leftSpotItemReviewChartLevel5{{if entrance_steps >= 4}} on{{/if}}"></div>
                            </div>
                            <div class="leftSpotItemReviewChartNumber">
                                {{if entrance_steps == -1}}
                                    -
                                {{else entrance_steps == 4}}
                                    3+
                                {{else}}
                                    {{:entrance_steps}}
                                {{/if}}
                            </div>
                            {{else}}
                            <span class="spotNotReview">
                                <?php echo __('LABEL_REVIEW_NO_STEP') ?>
                            </span>
                            {{/if}}
                        </div>
                    </div>
                </div>
            </div>
        </script>
    </body>
</html>
