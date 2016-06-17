<?php
Configure::write('API.Timeout', 30);

Configure::write('API.secretKey', 'bmaps');
Configure::write('API.rewriteUrl', array());

Configure::write('API.url_users_login', 'users/login');
Configure::write('API.url_users_login_facebook', 'users/fblogin');
Configure::write('API.url_users_login_twitter', 'users/twitterlogintoken');
Configure::write('API.url_users_recommend', 'users/recommend');
Configure::write('API.url_users_register', 'users/registeremail');
Configure::write('API.url_users_updateprofile', 'mobile/users/updateprofile');
Configure::write('API.url_users_timeline', 'users/timeline');
Configure::write('API.url_users_profile', 'users/profile');
Configure::write('API.url_users_forgetpassword', 'users/forgetpassword');
Configure::write('API.url_users_updatepassword', 'users/updatepassword');
Configure::write('API.url_users_registeractive', 'users/registeractive');
Configure::write('API.url_users_updateteam', 'users/updateteam');
Configure::write('API.url_users_changepassword', 'users/changepassword');

Configure::write('API.url_useractivations_check', 'useractivations/check');

Configure::write('API.url_userphysicals_all', 'userphysicals/all');

Configure::write('API.url_users_settings_all', 'usersettings/all');
Configure::write('API.url_users_settings_update', 'usersettings/update');

Configure::write('API.url_notices_list', 'notices/list');

Configure::write('API.url_placefavorites_all', 'placefavorites/all');
Configure::write('API.url_placefavorites_top', 'placefavorites/top');
Configure::write('API.url_placecategories_all', 'placecategories/all');
Configure::write('API.url_placesubcategories_all', 'placesubcategories/all');

Configure::write('API.url_helps_all', 'helps/all');

Configure::write('API.url_placereviewlikes_add', 'placereviewlikes/add');
Configure::write('API.url_placereviewlikes_disable', 'placereviewlikes/disable');

Configure::write('API.url_places_recommend', 'places/recommend');
Configure::write('API.url_places_ranking', 'places/ranking');
Configure::write('API.url_places_wanttovisit', 'places/wanttovisit');
Configure::write('API.url_places_detail', 'places/detail');
Configure::write('API.url_places_addupdate', 'places/addupdate');
Configure::write('API.url_places_disable', 'places/disable');
Configure::write('API.url_places_search', 'places/search');
Configure::write('API.url_places_autocomplete', 'places/autocomplete');
Configure::write('API.url_placepins_add', 'placepins/add');

Configure::write('API.url_placereviews_addupdate', 'placereviews/addupdate');
Configure::write('API.url_placereviews_detail', 'placereviews/detail');
Configure::write('API.url_placereviews_history', 'placereviews/history');
Configure::write('API.url_placereviewcomments_addupdate', 'placereviewcomments/addupdate');

Configure::write('API.url_followusers_add', 'followusers/add');
Configure::write('API.url_followusers_disable', 'followusers/disable');
Configure::write('API.url_followusers_list', 'followusers/list');
Configure::write('API.url_followusers_ifollow', 'followusers/ifollow');
Configure::write('API.url_followusers_followme', 'followusers/followme');

Configure::write('API.url_teams_list', 'teams/list');
Configure::write('API.url_teams_all', 'teams/all');

Configure::write('API.url_mobile_config', 'mobile/config');
Configure::write('API.url_violationreports_add', 'violationreports/add');

Configure::write('API.url_coins_history', 'coins/history');
Configure::write('API.url_coins_ranking', 'coins/ranking');
Configure::write('API.url_users_checkloginfailed', 'users/checkloginfailed');

Configure::write('API.url_emails_contact', 'emails/contact');

Configure::write('API.url_test', 'pages/test');
