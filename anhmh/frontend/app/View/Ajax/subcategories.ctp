<option value=""><?php echo __('MESSAGE_SELECT_FROM_PULLDOWN');?></option>
<?php if (!empty($subcategories)) : ?>
<?php foreach($subcategories as $subcategory): ?>
<option value="<?php echo $subcategory['type_id'] ?>"><?php echo $subcategory['name'] ?></option>
<?php endforeach; ?>
<?php endif; ?>