<div class="wrapPanel" id="wrapPanelTop"></div>
<div class="wrapPanel" id="wrapPanelMain"></div>
<div class="wrapPanel" id="wrapPanelSetting"></div>
<div class="wrapPanel" id="wrapPanelUnderSpot"></div>
<div class="wrapPanel" id="wrapPanelChampionInfo"></div>
<div class="wrapPanel" id="wrapPanelLogin"></div>

<div class="dlgPopoup" id="dlgPopupSetting">
    <div id="dlgPopupSettingHeader"><?php echo __('LABEL_MENU_SETTINGS'); ?></div>
    <div id="dlgPopupSettingContent">
        <div class="myToggleItem">
            <div class="myToggleItemLabel">
                <span><p></p></span>
            </div>
            <input type="checkbox" id="dlgPopupSettingItem" name="" value=""/>
            <div class="myToggle">
                <label for="dlgPopupSettingItem"><i></i></label>
            </div>
        </div>
    </div>
    <div id="dlgPopupSettingButton">
        <div id="dlgPopupSettingButtonCancel"><?php echo __('LABEL_CANCEL'); ?></div>
        <div id="dlgPopupSettingButtonSave"><?php echo __('LABEL_SAVE'); ?></div>
    </div>
</div>

<div class="dlgPopoup" id="dlgPopupCategory">
    <div id="dlgPopupCategoryTitle" class="noselect">
        <?php echo __d('category', 'CATEGORY_POPUP_TITLE') ?>
    </div>
    <div id="dlgPopupCategoryContent">
        <?php foreach(AppModel::categories_all() as $category): ?>
        <?php 
            $aId = array(
                1 => 'dlgPopupCategoryMobility',
                2 => 'dlgPopupCategoryCar',
                3 => 'dlgPopupCategoryLeisure',
                4 => 'dlgPopupCategoryFood',
                5 => 'dlgPopupCategoryLife',
                6 => 'dlgPopupCategoryPublic',
                7 => 'dlgPopupCategoryWellness',
                8 => 'dlgPopupCategoryShop'
            );
        ?>
        <a  id="<?php echo $aId[$category['type_id']] ?>"
            data-category-id="<?php echo $category['type_id'];?>"
            class="dlgPopupCategoryItem noselect" 
            href="<?php 
                echo $this->Html->url(array(
                    'controller' => 'top', 
                    'action' => 'index',
                    '?' => array(
                        'place_category_type_id' => $category['type_id']
                    )
                ));
            ?>">
            <div class="dlgPopupCategoryItemText"><?php echo $category['name'] ?></div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="dlgPopoup" id="dlgPopupAdvancedSearch">
    <div id="dlgPopupAdvancedSearchContainer">
        <div id="dlgPopupAdvancedSearchTop">
            <div id="dlgPopupAdvancedSearchTitle" class="noselect">
                <div id="dlgPopupAdvancedSearchTitleCancel">
                    <?php echo __('LABEL_CANCEL');?>
                </div>
                <?php echo __('LABEL_FILTERING_CONDITION');?>
                <div id="dlgPopupAdvancedSearchTitleReset">
                    <?php echo __('LABEL_RESET');?>
                </div>
            </div>
            <div id="dlgPopupAdvancedSearchTopReview">
                <div id="dlgPopupAdvancedSearchTopReviewTitle">
                    <span><?php echo __('LABEL_SPOT_REVIEW');?></span>
                </div>
                <div id="dlgPopupAdvancedSearchTopReviewContent">
                    <div id="dlgPopupAdvancedSearchTopReviewMinus" class="dlgPopupAdvancedSearchTopReviewBtn noselect"></div>
                    <div class="dlgPopupAdvancedSearchTopReviewFace" id="dlgPopupAdvancedSearchTopReviewFace1"><?php echo __('LABEL_RATE_VALUE_1'); ?></div>
                    <div class="dlgPopupAdvancedSearchTopReviewFace" id="dlgPopupAdvancedSearchTopReviewFace2"><?php echo __('LABEL_RATE_VALUE_2'); ?></div>
                    <div class="dlgPopupAdvancedSearchTopReviewFace" id="dlgPopupAdvancedSearchTopReviewFace3"><?php echo __('LABEL_RATE_VALUE_3'); ?></div>
                    <div class="dlgPopupAdvancedSearchTopReviewFace" id="dlgPopupAdvancedSearchTopReviewFace4"><?php echo __('LABEL_RATE_VALUE_4'); ?></div>
                    <div class="dlgPopupAdvancedSearchTopReviewFace" id="dlgPopupAdvancedSearchTopReviewFace5"><?php echo __('LABEL_RATE_VALUE_5'); ?></div>
                    <div id="dlgPopupAdvancedSearchTopReviewNumber">-</div>                    
                    <div id="dlgPopupAdvancedSearchTopReviewPlus" class="dlgPopupAdvancedSearchTopReviewBtn noselect"></div>
                </div>
            </div>
            <div id="dlgPopupAdvancedSearchTopStep">
                <div id="dlgPopupAdvancedSearchTopStepTitle">
                    <span><?php echo __('LABEL_ENTRY_STEPS');?></span>
                </div>
                <div id="dlgPopupAdvancedSearchTopReviewContent">
                    <div id="dlgPopupAdvancedSearchTopStepMinus" class="dlgPopupAdvancedSearchTopStepBtn noselect"></div>                    
                    <div class="dlgPopupAdvancedSearchTopStepRange" id="dlgPopupAdvancedSearchTopStepRange1"><span>0</span><div></div></div>
                    <div class="dlgPopupAdvancedSearchTopStepRange" id="dlgPopupAdvancedSearchTopStepRange2"><span>1</span><div></div></div>
                    <div class="dlgPopupAdvancedSearchTopStepRange" id="dlgPopupAdvancedSearchTopStepRange3"><span>2</span><div></div></div>
                    <div class="dlgPopupAdvancedSearchTopStepRange" id="dlgPopupAdvancedSearchTopStepRange4"><span>3</span><div></div></div>
                    <div class="dlgPopupAdvancedSearchTopStepRange" id="dlgPopupAdvancedSearchTopStepRange5"><span>3+</span><div></div></div>
                    
                    <div id="dlgPopupAdvancedSearchTopStepNumber">-</div>
                    
                    <div id="dlgPopupAdvancedSearchTopStepPlus" class="dlgPopupAdvancedSearchTopStepBtn noselect"></div>
                </div>
            </div>
            <div id="dlgPopupAdvancedSearchTopEquipment">
                <div id="dlgPopupAdvancedSearchTopEquipmentTitle">
                    <span><?php echo __('LABEL_FACILITY_AND_OTHER_RATING'); ?></span>
                </div>
                <div id="dlgPopupAdvancedSearchTopEquipmentContentNo" class="dlgPopupAdvancedSearchTopEquipmentItem noselect">
                    <?php echo __('MESSAGE_NOTHING_IS_SELECTED'); ?>
                </div>
                <div id="dlgPopupAdvancedSearchTopEquipmentContent" class="noselect" style="display:none">
                    <div style="display:none" data-id="is_flat" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment1.png"/>
                    </div>
                    <div style="display:none" data-id="is_spacious" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment2.png"/>
                    </div>
                    <div style="display:none" data-id="is_silent" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment3.png"/>
                    </div>
                    <div style="display:none" data-id="is_bright" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment4.png"/>
                    </div>                    
                    <div style="display:none" data-id="count_parking" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment9.png"/>
                    </div>
                    <div style="display:none" data-id="count_wheelchair_parking" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment7.png"/>
                    </div>                    
                    <div style="display:none" data-id="count_elevator" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment6.png"/>
                    </div>
                    <div style="display:none" data-id="count_wheelchair_rent" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment10.png"/>
                    </div>
                    <div style="display:none" data-id="count_wheelchair_wc" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment5.png"/>
                    </div>
                    <div style="display:none" data-id="count_ostomate_wc" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment8.png"/>
                    </div>
                    <div style="display:none" data-id="count_nursing_room" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment11.png"/>
                    </div>
                    <div style="display:none" data-id="count_babycar_rent" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment12.png"/>
                    </div>
                    <div style="display:none" data-id="with_assistance_dog" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment13.png"/>
                    </div>
                    <div style="display:none" data-id="is_universal_manner" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment14.png"/>
                    </div>
                    <div style="display:none" data-id="with_credit_card" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment15.png"/>
                    </div>
                    <div style="display:none" data-id="with_emoney" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment16.png"/>
                    </div>
                    <div style="display:none" data-id="count_plug" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment17.png"/>
                    </div>
                    <div style="display:none" data-id="count_wifi" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment18.png"/>
                    </div>
                    <div style="display:none" data-id="count_smoking_room" class="dlgPopupAdvancedSearchTopEquipmentItem">
                        <img src="<?php echo BASE_URL ?>/img/equipment19.png"/>
                    </div>                    
                    <div class="dlgPopupAdvancedSearchTopEquipmentItem physicalTypeMore">
                        <img src="<?php echo BASE_URL ?>/img/equipmentMore.png"/>
                    </div>
                </div>
            </div>
            
            <div id="dlgPopupAdvancedSearchTopPhysical">
                <div id="dlgPopupAdvancedSearchTopPhysicalTitle">
                    <span><?php echo __('LABEL_USERS_PHYSICAL_TYPE'); ?></span>
                </div>
                <div id="dlgPopupAdvancedSearchTopPhysicalContentNo" class="dlgPopupAdvancedSearchTopPhysicalItem noselect">
                    <?php echo __('MESSAGE_NOTHING_IS_SELECTED'); ?>
                </div>
                <div id="dlgPopupAdvancedSearchTopPhysicalContent" class="noselect" style="display:none">
                    
                    <div style="display:none" data-id="1" class="dlgPopupAdvancedSearchTopPhysicalItem" id="dlgPopupAdvancedSearchTopPhysical1">
                        <img src="<?php echo BASE_URL ?>/img/physicalType1.png"/>
                    </div>
                    <div style="display:none" data-id="2" class="dlgPopupAdvancedSearchTopPhysicalItem" id="dlgPopupAdvancedSearchTopPhysical2">
                        <img src="<?php echo BASE_URL ?>/img/physicalType2.png"/>
                    </div>
                    <div style="display:none" data-id="3" class="dlgPopupAdvancedSearchTopPhysicalItem" id="dlgPopupAdvancedSearchTopPhysical3">
                        <img src="<?php echo BASE_URL ?>/img/physicalType3.png"/>
                    </div>
                    <div style="display:none" data-id="4" class="dlgPopupAdvancedSearchTopPhysicalItem" id="dlgPopupAdvancedSearchTopPhysical4">
                        <img src="<?php echo BASE_URL ?>/img/physicalType4.png"/>
                    </div>
                    <div style="display:none" data-id="5" class="dlgPopupAdvancedSearchTopPhysicalItem" id="dlgPopupAdvancedSearchTopPhysical5">
                        <img src="<?php echo BASE_URL ?>/img/physicalType5.png"/>
                    </div>
                    <div style="display:none" data-id="6" class="dlgPopupAdvancedSearchTopPhysicalItem" id="dlgPopupAdvancedSearchTopPhysical6">
                        <img src="<?php echo BASE_URL ?>/img/physicalType6.png"/>
                    </div>
                    <div style="display:none" data-id="7" class="dlgPopupAdvancedSearchTopPhysicalItem" id="dlgPopupAdvancedSearchTopPhysical7">
                        <img src="<?php echo BASE_URL ?>/img/physicalType7.png"/>
                    </div>
                    <div style="display:none" data-id="8" class="dlgPopupAdvancedSearchTopPhysicalItem" id="dlgPopupAdvancedSearchTopPhysical8">
                        <img src="<?php echo BASE_URL ?>/img/physicalType8.png"/>
                    </div>                   
                    <div style="display:none" data-id="99" class="dlgPopupAdvancedSearchTopPhysicalItem" id="dlgPopupAdvancedSearchTopPhysical9">
                        <img src="<?php echo BASE_URL ?>/img/physicalType9.png"/>
                    </div>                   
                    <div class="dlgPopupAdvancedSearchTopPhysicalItem physicalTypeMore">
                        <img src="<?php echo BASE_URL ?>/img/physicalTypeMore.png"/>
                    </div>
                </div>
            </div>
            <div data-url="<?php 
                    echo $this->Html->url(array(
                        'controller' => 'top', 
                        'action' => 'index'
                    ))
                ?>"
                 id="dlgPopupAdvancedSearchTopBtn" 
                 class="noselect"><?php echo __('LABEL_FILTERING'); ?></div>
        </div>
        
        <div id="dlgPopupAdvancedSearchEquipment1" class="dlgPopupAdvancedSearchEquipment">
            <div class="dlgPopupAdvancedSearchEquipmentContent">
                <div class="dlgPopupAdvancedSearchEquipmentTitle"><?php echo __('LABEL_FACILITY_AND_OTHER_RATING');?></div>
                <div class="dlgPopupAdvancedSearchEquipmentDetail">
                    <div class="dlgPopupAdvancedSearchEquipmentLine1">
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect on" data-id="is_flat">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_FLAT');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="is_spacious">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_SPACIOUS');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="is_silent">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_SILENT');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="is_bright">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_BRIGHT');?></div>
                        </div>
                    </div>
                    <div class="dlgPopupAdvancedSearchEquipmentLine2">
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_parking">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_PARKING');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_wheelchair_parking">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_WHEELCHAIR_PARKING');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_elevator">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_ELEVATOR');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_wheelchair_rent">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_WHEELCHAIR_RENT');?></div>
                        </div>
                    </div>
                    <div class="dlgPopupAdvancedSearchEquipmentLine3">
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_wheelchair_wc">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_WHEELCHAIR_WC');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_ostomate_wc">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_OSTOMATE_WC');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_nursing_room">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_NURSING_ROOM');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_babycar_rent">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_BABYCAR_RENT');?></div>
                        </div>
                    </div>
                    <div class="dlgPopupAdvancedSearchEquipmentLine4">
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="with_assistance_dog">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_WITH_ASSISTANCE_DOG');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="is_universal_manner">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_UNIVERSAL_MANNER');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="with_credit_card">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_WITH_CREDIT_CARD');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="with_emoney">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_WITH_EMONEY');?></div>
                        </div>
                    </div>
                    <div class="dlgPopupAdvancedSearchEquipmentLine5">
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_plug">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_PLUG');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_wifi">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_WIFI');?></div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_smoking_room">
                            <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                            <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_SMOKING_ROOM');?></div>
                        </div>
                    </div>
                </div>
                <div class="dlgPopupAdvancedSearchEquipmentButton noselect"><?php echo __('LABEL_DECIDE');?></div>
            </div>
            <div class="dlgPopupAdvancedSearchEquipmentClose"></div>
        </div>
        
        <!-- All physicalType -->
        <div id="dlgPopupAdvancedSearchEquipment2" class="dlgPopupAdvancedSearchEquipment">
            <div class="dlgPopupAdvancedSearchEquipmentContent">
                <div class="dlgPopupAdvancedSearchEquipmentTitle"><?php echo __('LABEL_USERS_PHYSICAL_TYPE');?></div>
                <div class="dlgPopupAdvancedSearchEquipmentDetail">
                    <?php 
                    $physicalTypes = AppModel::physical_type_all();
                    $lineIndex = 1;
                    for ($i = 0; $i < count($physicalTypes); $i+=3) {                        
                        echo "<div class=\"dlgPopupAdvancedSearchEquipmentLine{$lineIndex}\">";
                        for ($j = $i; $j < $i+3; $j++) {
                            if (isset($physicalTypes[$j])) {
                                $physicalType = $physicalTypes[$j];
                                echo "
                                <div class=\"dlgPopupAdvancedSearchEquipmentItem noselect\" data-id=\"{$physicalType['type_id']}\">
                                    <div class=\"dlgPopupAdvancedSearchEquipmentItemImage\"></div>
                                    <div class=\"dlgPopupAdvancedSearchEquipmentItemName\">{$physicalType['name']}</div>
                                </div>
                                ";
                            }
                        }
                        echo "</div>";
                        $lineIndex++;
                    }                    
                    ?>                    
                </div>
                <div class="dlgPopupAdvancedSearchEquipmentButton noselect"><?php echo __('LABEL_DECIDE');?></div>
            </div>
            <div class="dlgPopupAdvancedSearchEquipmentClose"></div>
        </div>
    </div>
</div>

<div class="dlgPopoup" id="dlgPopupChampionship">
    <div id="dlgPopupChampionshipTitle" class="noselect">
        <?php echo __('LABEL_RANKING_NOW');?>
        <div id="dlgPopupChampionshipTitleBtn">
            <?php echo __('LABEL_WHAT_IS_CHAMPHIONSHIP');?>
        </div>
    </div>
    <ul class="nav nav-pills" id="dlgPopupChampionshipNav">
        <li class="active"><a onclick="loadTeamList(1)" data-toggle="pill" href="#pcsGeneral"><?php echo __('LABEL_ORDINARY');?></a></li>
        <li><a onclick="loadTeamList(2)" data-toggle="pill" href="#pcsCompany"><?php echo __('LABEL_COMPANY');?></a></li>
        <li><a onclick="loadTeamList(3)" data-toggle="pill" href="#pcsUniversity"><?php echo __('LABEL_UNIVERSITY');?></a></li>
    </ul>
    <div class="tab-content">
        <div id="pcsGeneral" class="tab-pane dlgPopupChampionshipContent active">
            <div id="pcsGeneralData"></div>
        </div>
        <div id="pcsCompany" class="tab-pane dlgPopupChampionshipContent">
            <div id="pcsCompanyData"></div>
        </div>
        <div id="pcsUniversity" class="tab-pane dlgPopupChampionshipContent">
            <div id="pcsUniversityData"></div>
        </div>
    </div>
</div>

<div class="dlgPopoup" id="dlgPopupGuest">
    <div id="dlgPopupGuestHeader">
        <div id="dlgPopupGuestTitle">
            <?php echo __('MESSAGE_PLEASE_JOIN_CREATE_MAPS');?>
        </div>
        <div id="dlgPopupGuestDesc">
            <?php echo __('MESSAGE_REGIST_EXPLAIN');?>
        </div>
    </div>
    <div id="dlgPopupGuestBtns">
        <a class="btnGuest noselect" id="btnGuestFacebook" href="javascript: void(0)" data-action="actionLoginFacebook" data-action-type="function">
            <?php echo __('LOGIN_SIGNUP_WITH_FACEBOOK'); ?>
        </a>
        <a class="btnGuest noselect" id="btnGuestTwitter" href="javascript: void(0)" data-action="<?php echo BASE_URL ?>/login/twitter" data-action-type="url">
            <?php echo __('LOGIN_SIGNUP_WITH_TWITTER'); ?>
        </a>
        <a class="btnGuest noselect" id="btnGuestEmail" href="javascript: void(0)" data-action="<?php echo BASE_URL ?>/login/email" data-action-type="url">
            <?php echo __('LOGIN_SIGNUP_WITH_EMAIL'); ?>
        </a>
    </div>
    <div id="dlgPopupGuestCancel" class="noselect">
        Ｘ <?php echo __('LABEL_CANCEL');?>
    </div>
</div>

<div class="dlgPopoup" id="dlgPopupShareUrl">
    <form>
        <div id="dlgPopupShareUrlInput">
            URL
            <input id="shareUrlInput" type="text" name="data[ShareURL][url]" value="http://bmaps.world/map?000000"/>
        </div>
        <div id="dlgPopupShareUrlDesc">
            <?php echo __('MESSAGE_SHARE_WITH_URL');?>
        </div>
        <div id="dlgPopupShareUrlClose" class="noselect">
            <?php echo __('LABEL_CLOSE') ?>
        </div>
    </form>
</div>

<div class="dlgPopoup" id="dlgPopupAddSpot">
    <div id="dlgPopupAddSpotTitle">
        <?php echo __('MESSAGE_CLICK_ADD_SPOT_ON_MAP');?>
    </div>
    <div id="dlgPopupAddSpotCloseTop"></div>
    <div id="dlgPopupAddSpotForm">
        <form>
            <div class="dlgPopupAddSpotFormRow">
                <?php echo __('LABEL_NAME');?>
                <input type="text" id="add_new_spot_name" value=""/>
            </div>
            <div class="dlgPopupAddSpotFormRow">
                <?php echo __('LABEL_ADDRESS');?>
                <input type="text" id="add_new_spot_address" value=""/>
            </div>
            <div class="dlgPopupAddSpotFormRow">
                <?php echo __('LABEL_CATEGORY');?>
                <select id="add_new_spot_category" class="myCustomSelectbox" id="dlgPopupAddSpotCategory">
                    <option value="" selected="0"><?php echo __('MESSAGE_SELECT_FROM_PULLDOWN');?></option>

                    <?php foreach(AppModel::categories_all() as $category): ?>
                    <option value="<?php echo $category['type_id'] ?>"><?php echo $category['name'] ?></option>
                    <?php endforeach; ?>                        
                </select>
            </div>
            <div id="dlgPopupAddSpotBtns">
                <input type="hidden" id="dlgPopupAddSpotLat" name="" value=""/>
                <input type="hidden" id="dlgPopupAddSpotLng" name="" value=""/>
                <button type="button" id="dlgPopupAddSpotBtnRegister"><?php echo __('LABEL_DO_REGIST');?></button>
                <button type="button" id="dlgPopupAddSpotBtnCancel"><?php echo __('LABEL_CANCEL');?></button>
            </div>
        </form>
    </div>
</div>

<div class="scrollPopup" id="dlgPopupReviewSubmitContainer">
    <div id="dlgPopupReviewSubmit">
        <div id="dlgPopupReviewSubmitTitle" data-title-empty="<?php echo htmlspecialchars(__('MESSAGE_INPUT_REVIEW_TEXT_AND_SUBMIT')) ?>">
            
        </div>
        <div id="dlgPopupReviewSubmitForm">
            <form action="<?php 
                    echo $this->Html->url(array(
                        'controller' => 'places', 
                        'action' => 'postreview'
                    ))
                 ?>"
                 target="postreview"
                  method="POST"
                  enctype="multipart/form-data">
                <div id="dlgPopupReviewSubmitComment">
                    <div class="dlgPopupReviewSubmitRight">
                        <textarea name="data[comment]" id="dlgPopupReviewSubmitCommentValue" placeholder="<?php echo __('LABEL_COMMENT_INPUT') ?>"></textarea>
                    </div>
                </div>
                
                <div id="dlgPopupReviewSubmitLevel">
                    <div class="dlgPopupReviewSubmitLeft"><?php echo __('LABEL_SPOT_REVIEW');?></div>
                    <div class="dlgPopupReviewSubmitRight">
                        <div class="dlgPopupReviewSubmitLevelBtn noselect" id="dlgPopupReviewSubmitLevelMinus"></div>
                        <div class="dlgPopupReviewSubmitLevelFace" id="dlgPopupReviewSubmitLevelFace1"><?php echo __('LABEL_RATE_VALUE_1');?></div>
                        <div class="dlgPopupReviewSubmitLevelFace" id="dlgPopupReviewSubmitLevelFace2"><?php echo __('LABEL_RATE_VALUE_2');?></div>
                        <div class="dlgPopupReviewSubmitLevelFace" id="dlgPopupReviewSubmitLevelFace3"><?php echo __('LABEL_RATE_VALUE_3');?></div>
                        <div class="dlgPopupReviewSubmitLevelFace" id="dlgPopupReviewSubmitLevelFace4"><?php echo __('LABEL_RATE_VALUE_4');?></div>
                        <div class="dlgPopupReviewSubmitLevelFace" id="dlgPopupReviewSubmitLevelFace5"><?php echo __('LABEL_RATE_VALUE_5');?></div>
                        <div id="dlgPopupReviewSubmitLevelNumber">-</div>
                        <div class="dlgPopupReviewSubmitLevelBtn noselect" id="dlgPopupReviewSubmitLevelPlus"></div>
                    </div>
                </div>
                
                <div id="dlgPopupReviewSubmitEntranceSteps">
                    <div class="dlgPopupReviewSubmitLeft"><?php echo __('LABEL_ENTRY_STEPS');?></div>
                    <div class="dlgPopupReviewSubmitRight">
                        <div id="leftSpotEditEntranceStepsMinus" class="leftSpotEditEntranceStepsBtn noselect"></div>
                        <div class="leftSpotEditEntranceStepsRange" id="leftSpotEditEntranceStepsRange1"><span>0</span><div></div></div>
                        <div class="leftSpotEditEntranceStepsRange" id="leftSpotEditEntranceStepsRange2"><span>1</span><div></div></div>
                        <div class="leftSpotEditEntranceStepsRange" id="leftSpotEditEntranceStepsRange3"><span>2</span><div></div></div>
                        <div class="leftSpotEditEntranceStepsRange" id="leftSpotEditEntranceStepsRange4"><span>3</span><div></div></div>
                        <div class="leftSpotEditEntranceStepsRange" id="leftSpotEditEntranceStepsRange5"><span>3+</span><div></div></div>
                        <div id="leftSpotEditEntranceStepsText">-</div>
                        <input type="hidden" id="leftSpotEditEntranceStepsValue" name="data[entrance_steps]" value=""/>
                        <div id="leftSpotEditEntranceStepsPlus" class="leftSpotEditEntranceStepsBtn noselect"></div>
                    </div>
                </div>
                
                <div id="dlgPopupReviewSubmitFacility">
                    <div class="dlgPopupReviewSubmitLeft"><?php echo __('LABEL_FACILITY_AND_OTHER_RATING');?></div>
                    <div class="dlgPopupReviewSubmitRight">
                        <div id="dlgPopupReviewContentNo" class="dlgPopupAdvancedSearchTopEquipmentItem noselect">
                            <span style="display:none" id="dlgPopupReviewContentNoEmpty">
                                <?php echo __('MESSAGE_NOTHING_IS_SELECTED'); ?>
                            </span>
                            <div style="display:none" data-id="is_flat" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment1.png"/>
                            </div>
                            <div style="display:none" data-id="is_spacious" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment2.png"/>
                            </div>
                            <div style="display:none" data-id="is_silent" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment3.png"/>
                            </div>
                            <div style="display:none" data-id="is_bright" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment4.png"/>
                            </div>                    
                            <div style="display:none" data-id="count_parking" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment9.png"/>
                            </div>
                            <div style="display:none" data-id="count_wheelchair_parking" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment7.png"/>
                            </div>                    
                            <div style="display:none" data-id="count_elevator" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment6.png"/>
                            </div>
                            <div style="display:none" data-id="count_wheelchair_rent" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment10.png"/>
                            </div>
                            <div style="display:none" data-id="count_wheelchair_wc" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment5.png"/>
                            </div>
                            <div style="display:none" data-id="count_ostomate_wc" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment8.png"/>
                            </div>
                            <div style="display:none" data-id="count_nursing_room" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment11.png"/>
                            </div>
                            <div style="display:none" data-id="count_babycar_rent" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment12.png"/>
                            </div>
                            <div style="display:none" data-id="with_assistance_dog" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment13.png"/>
                            </div>
                            <div style="display:none" data-id="is_universal_manner" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment14.png"/>
                            </div>
                            <div style="display:none" data-id="with_credit_card" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment15.png"/>
                            </div>
                            <div style="display:none" data-id="with_emoney" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment16.png"/>
                            </div>
                            <div style="display:none" data-id="count_plug" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment17.png"/>
                            </div>
                            <div style="display:none" data-id="count_wifi" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment18.png"/>
                            </div>
                            <div style="display:none" data-id="count_smoking_room" class="dlgPopupAdvancedSearchTopEquipmentItem">
                                <img src="<?php echo BASE_URL ?>/img/equipment19.png"/>
                            </div>                    
                            <div style="display:none" class="dlgPopupAdvancedSearchTopEquipmentItem physicalTypeMore">
                                <img src="<?php echo BASE_URL ?>/img/equipmentMore.png"/>
                            </div>
                        </div>
                        
                        <div style="display: none">
                        <?php foreach(Configure::read('Config.placeFacilityIcon') as $key => $icon): ?>
                            <input type="checkbox" name="data[facility][]" value="<?php echo $key ?>" id="dlgPopupReviewSubmitFacility_<?php echo $key ?>"/>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div id="dlgPopupReviewSubmitFile">
                    <div id="dlgPopupReviewSubmitFile1" class="dlgPopupReviewSubmitFile">
                        <div class="dlgPopupReviewSubmitLeft"></div>
                        <div class="dlgPopupReviewSubmitRight">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        <input id="image_path1" name="data[image_path1]" type="file"/>
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                                <span class="button-delete-file">
                                    <img src="<?php echo BASE_URL ?>/img/buttonCancel2.png"/>
                                </span>
                            </div>

                        </div>
                    </div>

                    <div id="dlgPopupReviewSubmitFile2" class="dlgPopupReviewSubmitFile" style="display:none">
                        <div class="dlgPopupReviewSubmitLeft"></div>
                        <div class="dlgPopupReviewSubmitRight">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        <input id="image_path2" name="data[image_path2]" type="file"/>
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                                <span class="button-delete-file">
                                    <img src="<?php echo BASE_URL ?>/img/buttonCancel2.png"/>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div id="dlgPopupReviewSubmitFile3" class="dlgPopupReviewSubmitFile" style="display:none">
                        <div class="dlgPopupReviewSubmitLeft"></div>
                        <div class="dlgPopupReviewSubmitRight">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        <input id="image_path3" name="data[image_path3]" type="file"/>
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                                <span class="button-delete-file">
                                    <img src="<?php echo BASE_URL ?>/img/buttonCancel2.png"/>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div id="dlgPopupReviewSubmitFile4" class="dlgPopupReviewSubmitFile" style="display:none">
                        <div class="dlgPopupReviewSubmitLeft"></div>
                        <div class="dlgPopupReviewSubmitRight">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        <input id="image_path4" name="data[image_path4]" type="file"/>
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                                <span class="button-delete-file">
                                    <img src="<?php echo BASE_URL ?>/img/buttonCancel2.png"/>
                                </span>
                            </div>
                        </div>
                    </div>                

                    <div id="dlgPopupReviewSubmitFile5" class="dlgPopupReviewSubmitFile" style="display:none">
                        <div class="dlgPopupReviewSubmitLeft"></div>
                        <div class="dlgPopupReviewSubmitRight">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        <input id="image_path5" name="data[image_path5]" type="file"/>
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                                <span class="button-delete-file">
                                    <img src="<?php echo BASE_URL ?>/img/buttonCancel2.png"/>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="dlgPopupReviewSubmitBtns">
                    <div class="dlgPopupReviewSubmitLeft"></div>
                    <div class="dlgPopupReviewSubmitRight">
                        <input type="hidden" id="review_point" name="data[review_point]" value="0" />
                        <input type="hidden" id="place_id" name="data[place_id]" />
                        <input type="hidden" id="google_place_id" name="data[google_place_id]" />
                        <input type="hidden" id="place_review_id" name="data[id]" value="" />
                        <button 
                            type="submit" 
                            id="dlgPopupReviewSubmitBtnPost"
                            data-text-create="<?php echo __('LABEL_DO_SUBMIT');?>"
                            data-text-update="<?php echo __('LABEL_DO_UPDATE');?>">
                        </button>                
                        <button type="button" id="dlgPopupReviewSubmitBtnCancel"><?php echo __('LABEL_CANCEL');?></button>
                    </div>
                </div>
            </form>
            <iframe name="postreview" style="display:none;"></iframe>
        </div>
        
        <div id="dlgPopupReviewFacilityContainer">
            <div id="dlgPopupReviewFacility" class="dlgPopupAdvancedSearchEquipment">
                <div class="dlgPopupAdvancedSearchEquipmentContent">
                    <div class="dlgPopupAdvancedSearchEquipmentTitle"><?php echo __('LABEL_FACILITY_AND_OTHER_RATING');?></div>
                    <div class="dlgPopupAdvancedSearchEquipmentDetail">
                        <div class="dlgPopupAdvancedSearchEquipmentLine1">
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="is_flat">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_FLAT');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="is_spacious">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_SPACIOUS');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="is_silent">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_SILENT');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="is_bright">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_BRIGHT');?></div>
                            </div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentLine2">
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_parking">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_PARKING');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_wheelchair_parking">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_WHEELCHAIR_PARKING');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_elevator">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_ELEVATOR');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_wheelchair_rent">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_WHEELCHAIR_RENT');?></div>
                            </div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentLine3">
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_wheelchair_wc">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_WHEELCHAIR_WC');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_ostomate_wc">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_OSTOMATE_WC');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_nursing_room">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_NURSING_ROOM');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_babycar_rent">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_BABYCAR_RENT');?></div>
                            </div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentLine4">
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="with_assistance_dog">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_WITH_ASSISTANCE_DOG');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="is_universal_manner">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_IS_UNIVERSAL_MANNER');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="with_credit_card">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_WITH_CREDIT_CARD');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="with_emoney">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_WITH_EMONEY');?></div>
                            </div>
                        </div>
                        <div class="dlgPopupAdvancedSearchEquipmentLine5">
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_plug">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_PLUG');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_wifi">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_WIFI');?></div>
                            </div>
                            <div class="dlgPopupAdvancedSearchEquipmentItem noselect" data-id="count_smoking_room">
                                <div class="dlgPopupAdvancedSearchEquipmentItemImage"></div>
                                <div class="dlgPopupAdvancedSearchEquipmentItemName"><?php echo __('LABEL_FACILITY_ITEM_COUNT_SMOKING_ROOM');?></div>
                            </div>
                        </div>
                    </div>
                    <div class="dlgPopupAdvancedSearchEquipmentButton noselect"><?php echo __('LABEL_DECIDE');?></div>
                </div>
                <div class="dlgPopupAdvancedSearchEquipmentClose"></div>
            </div>
        </div>
    </div>
</div>

<div class="dlgPopoup" id="dlgPopupReviewComment">
    
</div>

<div class="dlgPopoup" id="dlgPopupFollow">
    
</div>

<div class="dlgPopoup" id="dlgPopupTeamSelect">
    <div class="dlgPopupTeamHeader"></div>
    <div class="dlgPopupTeamContent">
        <div class="dlgPopupTeamTitle">
            <?php echo __('LABEL_SELECT_TEAM_TITLE') ?>
        </div>
        <div class="dlgPopupTeamLabel">
            <?php echo __('LABEL_TEAM_NAME') ?>
        </div>
        <div id="dlgPopupTeamSelectTeam">
            <input type="text" name="teamName" placeholder="<?php echo __('LABEL_TEAM_NAME') ?>" value="<?php if(!empty($AppUI->team_name)) echo htmlspecialchars($AppUI->team_name) ?>" id="dlgPopupTeamSelectTeamInputName"/>
            <input type="hidden" name="teamId" value="<?php if(!empty($AppUI->team_id)) echo $AppUI->team_id ?>" id="dlgPopupTeamSelectTeamInputId"/>
            <div class="noselect" id="dlgPopupTeamSelectInputSearch"></div>
            <img id="dlgPopupTeamSelectInputSearchSpinner" src="<?php echo BASE_URL ?>/img/ajax_loader2.gif"/>
        </div>
        <div id="dlgPopupTeamSelectResult"></div>
        <script id="dlgPopupTeamResultTemplate" type="text/x-jsrender">
            <div class="dlgPopupTeamItem" data-id="{{:id}}">
                <div class="dlgPopupTeamName">{{:name}}</div>
            </div>
        </script>
    </div>
    <div class="noselect" id="dlgPopupTeamSelectBtnCreate"><?php echo __('LABEL_SIGNUP_TEAM') ?></div>
    <div class="noselect" id="dlgPopupTeamSelectBtnUpdate"><?php echo __('LABEL_DECISION') ?></div>
    <div class="noselect" id="dlgPopupTeamSelectBtnUpdateAndClose"><?php echo __('LABEL_DECISION') ?></div>
    <div class="dlgPopoupLoader">
        <img src="<?php echo BASE_URL ?>/img/ajax_loader2.gif" />
    </div>
</div>

<div class="dlgPopoup" id="dlgPopupChampionInfo">
    <div id="dlgPopupChampionInfoContent">
        <div id="dlgPopupChampionInfoHeader">
            <img src="<?php echo BASE_URL ?>/img/championshipInfo.png"/>
        </div>
        <div class="dlgPopupChampionInfoTitle">
            <?php echo __('LABEL_CHAMPIONSHIP_TITLE_1') ?>
        </div>
        <div class="dlgPopupChampionInfoDetail">
            <?php echo __('LABEL_CHAMPIONSHIP_DETAIL_1') ?>
        </div>
        <div class="dlgPopupChampionInfoTitle dlgPopupChampionInfoTitleBottom">
            <?php echo __('LABEL_CHAMPIONSHIP_TITLE_2') ?>
        </div>
        <div class="dlgPopupChampionInfoDetail dlgPopupChampionInfoDetailBottom">
            <?php echo __('LABEL_CHAMPIONSHIP_DETAIL_2') ?>
        </div>
    </div>
    <div class="noselect" id="dlgPopupChampionInfoBtnStart"><?php echo __('LABEL_BUTTON_START') ?></div>
    <div class="noselect" id="dlgPopupChampionInfoBtnClose"><?php echo __('LABEL_CLOSE') ?></div>
</div>

<div class="dlgPopoup" id="dlgPopupTeamCreate">
    <div class="dlgPopupTeamHeader">
        <div id="dlgPopupTeamCreateCancel" class="noselect">
            <?php echo __('LABEL_CANCEL') ?>
        </div>
    </div>
    <div class="dlgPopupTeamContent">
        <div class="dlgPopupTeamTitle">
            <?php echo __('LABEL_CREATE_TEAM_TITLE') ?>
        </div>
        <div class="dlgPopupTeamLabel">
            <?php echo __('LABEL_TEAM_NAME') ?>
        </div>
        <input type="text" placeholder="<?php echo __('LABEL_TEAM_NAME') ?>" name="data[Team][name]" value="" id="dlgPopupTeamCreateInputTeamName"/>
        <div class="dlgPopupTeamLabel dlgPopupTeamLabelSection">
            <?php echo __('LABEL_SECTION') ?>
        </div>
        <select name="data[Team][section]" class="leftSpotEditCustomSelectbox" id="dlgPopupTeamCreateInputTeamSection">
            <option value="" selected="selected"><?php echo __('LABEL_SECTION_INPUT') ?></option>
            <option value="1"><?php echo __('LABEL_SECTION_GENERAL') ?></option>
            <option value="2"><?php echo __('LABEL_SECTION_COMPANY') ?></option>
            <option value="3"><?php echo __('LABEL_SECTION_UNIVERSITY') ?></option>
        </select>
    </div>
    <div class="noselect" id="dlgPopupTeamCreateBtnUpdate"><?php echo __('LABEL_DECISION') ?></div>
    <div class="dlgPopoupLoader">
        <img src="<?php echo BASE_URL ?>/img/ajax_loader2.gif" />
    </div>
</div>

<div class="dlgPopoup" id="dlgPopupStaticHtml">
    <div id="dlgPopupStaticHtmlContent"></div>
</div>

<div class="dlgPopoup" id="dlgPopupSpotReport">
    <div id="dlgPopupSpotReportContent"></div>
</div>

<div class="dlgPopoup" id="dlgPopupLoginRule">
    <div id="dlgPopupLoginRuleTitle" class="noselect"><?php echo __('LABEL_AGREE_TERMS_OF_USE') ?></div>
    <div id="dlgPopupLoginRuleContent">
        <iframe src="<?php echo htmlspecialchars($this->Common->getWebLink('userpolicy')) ?>"></iframe>
    </div>
    <div id="dlgPopupLoginRuleBtn" class="noselect">
        <?php echo __('LABEL_AGREE') ?>
    </div>
</div>

<div class="dlgPopoup" id="dlgPopupPlaceReviewHistory">
    <div id="dlgPopupPlaceReviewHistoryTitle" class="noselect">
        <?php echo __('LABEL_HISTORY');?>
    </div>
    <div id="dlgPopupPlaceReviewHistoryContainer">
        <div id="dlgPopupPlaceReviewHistoryScroll"></div>
    </div>
    <button id="dlgPopupPlaceReviewHistoryClose"><?php echo __('LABEL_CLOSE') ?></button>
</div>
