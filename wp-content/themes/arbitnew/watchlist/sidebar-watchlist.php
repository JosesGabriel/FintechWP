<?php

global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;

$ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);

include "watchlist-sidebarloader.php";
?>
<script type="text/javascript">
  jQuery(function() {

    var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
    var dcount = 0;
    jQuery('.to-watch-data .to-stock a span').each(function(index, el) {
      if (dcount == '10') {
        dcount = 0;
      }
      jQuery(el).css('border-color', colors[dcount]);
      dcount++;
    });
  });
</script>

  <div class="watch-list" style="margin-top:10px;">
	    <div class="watch-list-inner">

		      <div class="to-top-title">Watchlist
		        <div class="dplsicon"><a href="/watchlist/"> <i class="fa fa-plus-circle"></i></a></div>
		      </div>

		      <hr class="style14 style15">
			      <div class="to-content-part">

				        <div id="tableStock" class="table table-striped">
				          <!--Table body-->
					          <div class="even" style="max-height: 302px;display: block;overflow: hidden;">




					          </div>
				        </div>
			      </div>
		    
	    </div>
  </div>