<div id="leftSpot" class="asideShadow">
    <div id="leftSpotMainContainer">
        <div id="leftSpotMainContainerSlider">
            <div id="leftSpotContainer">
                <div id="leftSpotHeader" class="noselect">
                    <span><?php echo __('LABEL_HOT_SPOT');?></span>
                    <div id="leftSpotSearchTypeCategory"></div>
                    <div id="leftSpotSearchTypeAdvanced">
                        <div style="display:none" data-id="is_flat" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment1w.png"/>
                        </div>
                        <div style="display:none" data-id="is_spacious" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment2w.png"/>
                        </div>
                        <div style="display:none" data-id="is_silent" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment3w.png"/>
                        </div>
                        <div style="display:none" data-id="is_bright" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment4w.png"/>
                        </div>                    
                        <div style="display:none" data-id="count_parking" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment9w.png"/>
                        </div>
                        <div style="display:none" data-id="count_wheelchair_parking" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment7w.png"/>
                        </div>                    
                        <div style="display:none" data-id="count_elevator" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment6w.png"/>
                        </div>
                        <div style="display:none" data-id="count_wheelchair_rent" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment10w.png"/>
                        </div>
                        <div style="display:none" data-id="count_wheelchair_wc" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment5w.png"/>
                        </div>
                        <div style="display:none" data-id="count_ostomate_wc" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment8w.png"/>
                        </div>
                        <div style="display:none" data-id="count_nursing_room" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment11w.png"/>
                        </div>
                        <div style="display:none" data-id="count_babycar_rent" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment12w.png"/>
                        </div>
                        <div style="display:none" data-id="with_assistance_dog" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment13w.png"/>
                        </div>
                        <div style="display:none" data-id="is_universal_manner" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment14w.png"/>
                        </div>
                        <div style="display:none" data-id="with_credit_card" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment15w.png"/>
                        </div>
                        <div style="display:none" data-id="with_emoney" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment16w.png"/>
                        </div>
                        <div style="display:none" data-id="count_plug" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment17w.png"/>
                        </div>
                        <div style="display:none" data-id="count_wifi" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment18w.png"/>
                        </div>
                        <div style="display:none" data-id="count_smoking_room" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipment19w.png"/>
                        </div>
                        
                        <?php
                            $physicalTypes = array();
                            $physicalTypesImg = Configure::read('Config.physicalTypeIconWhite');
                            $physicalTypesRaw = AppModel::physical_type_all();
                            foreach ($physicalTypesRaw as $physicalType) {
                                if (!empty($physicalTypesImg[$physicalType['type_id']])) {
                                    $physicalType['image'] = BASE_URL . '/' . $physicalTypesImg[$physicalType['type_id']];
                                    $physicalTypes[] = $physicalType;
                                }
                            }
                        ?>   
                        
                        <?php foreach ($physicalTypes as $physicalType): ?>
                        <div style="display:none" data-id="physical_type_<?php echo $physicalType['type_id'] ?>" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo $physicalType['image'] ?>"/>
                        </div>
                        <?php endforeach; ?>
                        
                        <div style="display:inline-block" data-id="more" class="dlgPopupAdvancedSearchTopEquipmentItem">
                            <img src="<?php echo BASE_URL ?>/img/equipmentMore_w.png"/>
                        </div>
                    </div>
                    <div id="leftSpotClose"></div>
                </div>
                <div id="leftSpotScrollMain">
                    <div id="spotBody"></div>
                </div>
            </div>
            
            <div id="leftRankingContainer">
                <div id="leftRankingHeader" class="noselect">
                    <span><?php echo __('LABEL_TOTAL_RANKING');?></span>
                    <div id="leftRankingTraveler"><?php echo __('LABEL_USER_SUBMIT_RANKING');?></div>
                    <div id="leftRankingClose"></div>
                </div>
                <div id="leftRankingCategories" class="noselect">
                    <?php echo __('LABEL_CATEGORY');?>
                    <select 
                        onchange="return loadRankingSpot();"                      
                        class="leftRankingCustomSelectbox">
                        <option value=""><?php echo __('LABEL_ALL');?></option>                        
                        <?php foreach(AppModel::categories_all() as $category): ?>
                        <option value="<?php echo $category['type_id'] ?>"><?php echo $category['name'] ?></option>
                        <?php endforeach; ?>                        
                    </select>
                </div>
                <div id="leftSpotScrollRanking">
                    <div id="leftRankingList"></div>
                </div>
            </div>
        </div>
    </div>
</div>
