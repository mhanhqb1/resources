<script type="text/javascript" src="<?php echo BASE_URL ?>/js/profile.js?<?php echo date('Ymd') ?>"></script>



<form method="POST"
    id="editProfileForm"
    enctype="multipart/form-data">
    
    
    
    <div id="prfTitle"><?php echo __('LABEL_PUBLIC_PROFILE_EDIT');?></div>
    
    <div class="prfLine"><?php echo __('LABEL_IMAGE_AVATAR');?></div>
    
    <div id="prfIcon">
        <div id="prfIconPreview" style="background-image: url(<?php echo $AppUI->image_path?>)"></div>
        <input type="file" id="prfIconFile" name="data[User][image_path]"/>
        <div id="prfDeleteAvatar" class="prfDeleteImage noselect"><?php echo __('LABEL_DELETE') ?></div>
    </div>
    
    <div class="prfLine"><?php echo __('LABEL_IMAGE_HEADER');?></div>
    
    <div id="prfCover" style="background-image: url(<?php echo $AppUI->cover_image_path?>)">
        <input type="file" id="prfCoverFile" name="data[User][cover_image_path]"/>
        <div id="prfDeleteCover" class="prfDeleteImage noselect"><?php echo __('LABEL_DELETE') ?></div>
    </div>
    
    <div class="prfLine"><?php echo __('LABEL_NICKNAME');?></div>
    
    <div id="prfNickname">
        <input type="text" name="data[User][name]" value="<?php echo $AppUI->name?>"/>
    </div>
    
    <div class="prfLine"><?php echo __('LABEL_PROFILE_COMMENT');?></div>
    
    <div id="prfComment">
        <textarea name="data[User][memo]"><?php echo $AppUI->memo?></textarea>
    </div>
    
    <input type="hidden" id="delete_avatar_flg" name="data[User][delete_avatar_flg]" value=""/>
    <input type="hidden" id="delete_cover_flg" name="data[User][delete_cover_flg]" value=""/>
    
    <button type="submit" id="prfSave"><?php echo __('LABEL_DO_UPDATE'); ?></button>
</form>
