<div class="latest-news">
    <div class="to-top-title">Bulletins ... <div class="to-top-dropdown"><i class="fas fa-chevron-circle-down"></i></div></div>
    
    <hr class="style14 style15" style="width: 92.5% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
    <div class="to-content-part">
        <div class="to-rss-inner">
            <?php dynamic_sidebar( 'et_pb_widget_area_1' ); ?>
            <!-- <br class="clear"> -->
        </div>
    </div>
    <!-- <div class="to-bottom-title">
        powerd by Google News 
        <a href="#" class="to-view-more">View all News</a>
    </div> -->
</div>
<script type="text/javascript">
		jQuery('.srr-tab-wrap').hide();
		jQuery('.to-top-dropdown').click(function(){
			event.stopPropagation();
			jQuery('.srr-tab-wrap').toggle();
		});
        
		jQuery(document).on("click", function () {
		    jQuery(".srr-tab-wrap").hide();
		});
        jQuery(document).on("click", function () {
            jQuery(".closehideme").hide();
        });
</script>
<style type="text/css">
    .srr-wrap.srr-style-none .srr-item {
        display: -webkit-box !important;
        width: 100% !important;
    }
</style>