<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/bootstrap-select.min.css"/>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/datepicker/datepicker3.css"/>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login.css?<?php echo date('Ymd') ?>" media="only screen and (min-width:640px)"/>
<link rel="stylesheet" href="<?php echo BASE_URL ?>/css/login_sp.css?<?php echo date('Ymd') ?>" media="only screen and (max-width:639px)"/>
<script type="text/javascript" src="<?php echo BASE_URL ?>/js/bootstrap-select.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>/datepicker/bootstrap-datepicker.js?<?php echo date('Ymd') ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>/js/login.js?<?php echo date('Ymd') ?>"></script>
<script type="text/javascript" src="<?php echo BASE_URL ?>/js/register.js?<?php echo date('Ymd') ?>"></script>
<div id="lgiRegisterPanel">
    <div id="lgiRegisterError">
        <?php echo $this->Session->flash(); ?>
    </div>
    <div id="lgiRegisterTitle">
        <?php echo !empty($label_title_page) ? $label_title_page : __('LABEL_REGISTER_PROFILE_INFO'); ?>
    </div>    
    
    <form method="POST" action="">
        <input type="text" name="data[Register][name]" placeholder="<?php echo __('LABEL_ENTER_NICKNAME'); ?>" id="lgiRegisterNickname" tabindex="10" value="<?php if(!empty($registerData['name'])) echo htmlspecialchars($registerData['name']) ?>"/>
        
        <select name="data[Register][sex_id]" id="lgiRegisterSelect1" class="lgiCustomSelectbox" tabindex="11">
            <option value="" <?php if(empty($registerData['sex_id'])) echo 'selected="selected"' ?>><?php echo __('LABEL_SELECT_GENDER')?></option>
            <option <?php if (!empty($registerData['sex_id']) && $registerData['sex_id'] == 1) echo 'selected="selected"'?> value="1"><?php echo __('Male')?></option>
            <option <?php if (!empty($registerData['sex_id']) && $registerData['sex_id'] == 2) echo 'selected="selected"'?> value="2"><?php echo __('Female')?></option>
            <option <?php if (!empty($registerData['sex_id']) && $registerData['sex_id'] == 3) echo 'selected="selected"'?> value="3"><?php echo __('LABEL_OTHER')?></option>
        </select>
        
        <input type="text" name="data[Register][birthday]" 
               placeholder="<?php echo __('LABEL_ENTER_BIRTHDAY'); ?>" 
               id="lgiRegisterNickname" 
               class="datepicker" 
               tabindex="12"
               value="<?php if (!empty($registerData['birthday'])) echo date('Y-m-d', strtotime($registerData['birthday']))?>"/>
        
        <div class="lgiRegisterZipcode">
            <div id="lgiRegisterZipcodeLabel"><?php echo __('LABEL_ENTER_ZIP_CODE')?></div>            
            <input type="text" name="data[Register][zipcode2]" id="lgiRegisterZipcode2" tabindex="17" placeholder="0000" maxlength="4" value="<?php if(!empty($registerData['zipcode2'])) echo htmlspecialchars($registerData['zipcode2']) ?>"/>
            <div id="lgiRegisterZipcodeSeparator">―</div>
            <input type="text" name="data[Register][zipcode1]" id="lgiRegisterZipcode1" tabindex="15" placeholder="000" maxlength="3" value="<?php if(!empty($registerData['zipcode1'])) echo htmlspecialchars($registerData['zipcode1']) ?>"/>
        </div>
        
        <div id="lgiRegisterSelectPhysicalType">
            <?php
                $_currentTypeId = $_currentTypeName = '';
                foreach($physicals as $physical) {
                    if (!empty($registerData['user_physical_type_id']) && $registerData['user_physical_type_id'] == $physical['type_id']) {
                        $_currentTypeId = $physical['type_id'];
                        $_currentTypeName = $physical['name'];
                        break;
                    }
                }
            ?>
            <input type="hidden" name="data[Register][user_physical_type_id]" id="lgiRegisterSelectPhysicalTypeValue" value="<?php echo $_currentTypeId ?>"/>
            <span id="lgiRegisterSelectPhysicalTypeImage" data-id="<?php echo $_currentTypeId ?>" class="<?php if(empty($_currentTypeId)) echo 'nonPhysicalTypeId' ?>"></span>
            <span id="lgiRegisterSelectPhysicalTypeText"><?php echo empty($_currentTypeName) ? __('LABEL_SELECT_PHYSICAL_CHARACTERISTIC') : $_currentTypeName ?></span>
        </div>
        
        <div class="lgiRegisterBtns">
            <button type="submit" id="lgiRegisterBtnNext"><?php echo $label_button_save; ?></button>
        </div>
    </form>
   
</div>

<div class="wrapPanel" id="wrapPanelRegisterInfo"></div>
<div class="dlgPopoup" id="dlgPopupSelectPhysicalType">
    <div class="dlgPopupSelectPhysicalTypeContent">
        <div class="dlgPopupSelectPhysicalTypeTitle"><?php echo __('LABEL_USERS_PHYSICAL_TYPE');?></div>
        <div class="dlgPopupSelectPhysicalTypeDetail">
            <?php 
                $physicalTypes = AppModel::physical_type_all();
                $lineIndex = 1;
                for ($i = 0; $i < count($physicalTypes); $i+=3) {                        
                    echo "<div class=\"dlgPopupSelectPhysicalTypeLine{$lineIndex}\">";
                    for ($j = $i; $j < $i+3; $j++) {
                        if (isset($physicalTypes[$j])) {
                            $physicalType = $physicalTypes[$j];
                            echo "
                            <div class=\"dlgPopupSelectPhysicalTypeItem noselect\" data-id=\"{$physicalType['type_id']}\">
                                <div class=\"dlgPopupSelectPhysicalTypeItemImage\"></div>
                                <div class=\"dlgPopupSelectPhysicalTypeItemName\">{$physicalType['name']}</div>
                            </div>
                            ";
                        }
                    }
                    echo "</div>";
                    $lineIndex++;
                }                    
            ?>
        </div>
    </div>
    <div id="dlgPopupSelectPhysicalTypeClose"></div>
</div>
