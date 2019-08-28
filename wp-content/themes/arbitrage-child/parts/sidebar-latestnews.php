<div class="latest-news">
    <div class="to-top-title">Bulletins
        <!-- <div class="to-top-dropdown"><i class="fas fa-chevron-circle-down"></i></div> -->
    </div>
    
    <hr class="style14 style15" style="width: 90% !important;margin-bottom: 0px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
    <div class="to-content-part">
        <div class="to-rss-inner">
            <?php echo dynamic_sidebar( 'et_pb_widget_area_1' ); ?>
            <div class="to-bottom-seemore" style="display: inline-flex;">
    
            <div class="see-more-btn" id="show_hide">
                <strong style="font-size:13px;"><a href="https://arbitrage.ph/bulletins/">View all</a></strong>
            </div>

        </div>
            <br class="clear">
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
	.to-top-dropdown {
		float: right;
		font-size: 12px;
		color: #fffffe;
    	line-height: 1.7;
    	cursor: pointer;
	}
    div#show_hide {
        margin-left: 0;
        margin-bottom: 3px;
    }
</style>