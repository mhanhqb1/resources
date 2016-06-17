<div id="topMapContainer"></div>
<div id="topMapFilterFacilities" class="btnWhite"><div><?php echo __('LABEL_ALT_FILTER_FACILITIES'); ?></div></div>
<div id="topMapFilterCategories" class="btnWhite"><div><?php echo __('LABEL_ALT_FILTER_CATEGORIES'); ?></div></div>
<div id="topMapZoomIn"></div>
<div id="topMapZoomOut"></div>
<div id="topMapNewSpot"></div>
<div id="topMapCurrentLocation"></div>

<?php if(isset($query['keyword'])):?>
<script type="text/javascript">
    $(document).ready(function () {
        google.maps.event.addListenerOnce(map, 'idle', headerSearch);
    });
</script>
<?php endif;?>