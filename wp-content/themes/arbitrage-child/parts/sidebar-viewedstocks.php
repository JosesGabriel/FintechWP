<script type="text/javascript">

jQuery(function(){
  
  function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };
  var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
  var dcount = 0;
  jQuery('.top-stocks .to-content-part ul .even span, .top-stocks .to-content-part ul .odd span').each(function(index,el){
    if (dcount == '10') {dcount = 0; }
    jQuery(el).css('border-color',colors[dcount]);
    dcount++;
  });
});
</script>

<div class="top-stocks">
    <div class="to-top-title"><strong>Most Watched Stocks</strong></div>
    <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
    <div class="to-content-part">


        <?php 
        global $current_user;
        $user = wp_get_current_user();
        $userID = $current_user->ID;

            $ismetadis = get_user_meta($userID, '_watchlist_instrumental', true);
            print_r($ismetadis);
        ?>
        
		                <ul>
				            <li class="odd">
				                <span>MRC</span>
				                <a href="#">MRC Allied, Inc. <br><p>31 Following</p></a>
				            </li>
				            <li class="even">
				                <span>ABA</span>
				                <a href="#">AbaCore Capital Holdings, Inc.<br><p>322 Following</p></a>
				            </li>
				            <li class="odd">
				                <span>FOOD</span>
				                <a href="#">Alliance Select Food  Int’l Inc.<br><p>323 Following</p></a>
				            </li>
				            <li class="even">
				                <span>STI</span>
				                <a href="#">STI Education System, Inc.<br><p>325 Following</p></a>
				            </li>
				            <div class="hide-show watched-hidden-content">
				                <li class="odd">
				                    <span>FOOD</span>
				                    <a href="#">Alliance Select Food  Int’l Inc.<br><p>326 Following</p></a>
				                </li>
				                <li class="even">
				                    <span>STI</span>
				                    <a href="#">Alliance Select Food  Int’l Inc.<br><p>323 Following</p></a>
				                </li>
				                <li class="odd">
				                    <span>FOOD</span>
				                    <a href="#">Alliance Select Food  Int’l Inc.<br><p>123 Following</p></a>
				                </li>
				                <li class="even">
				                    <span>STI</span>
				                    <a href="#">Alliance Select Food  Int’l Inc.<br><p>332 Following</p></a>
				                </li>
				            </div>
				        </ul>
    </div>
    <!-- <div class="to-bottom-seemore" style="display: inline-flex;">
        <i class="fas fa-sort-down" style="
        font-size: 16px;
        margin-right: 3px;
        vertical-align: initial;
    "></i>
        <div class="see-more-btn button-toggle-content">
            <strong>See more</strong>
        </div>
    </div> -->
    <div class="to-bottom-seemore" style="display: inline-flex;color: #cecece;font-size: 13px;">
        <div class="see-more-btn button-toggle-content">
            <i class="fas fa-sort-down" id="fa-up" style="
                font-size: 13px;
                margin-right: 3px;
                vertical-align: initial;
                bottom: 0px;
                top: -2px;
                position: relative;
            "></i>
            <strong>See more</strong>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
// $(document).ready(function(){
// 	$('.button-toggle-content').on('click', function(){
// 		$('.watched-hidden-content').toggle();
// 	});
// });
$(document).ready(function(){
    $(".button-toggle-content").click(function () {
        $(".watched-hidden-content").toggle('slow');
        if($(".button-toggle-content").hasClass('isopen')){
            $(".button-toggle-content").html('<i class="fas fa-sort-down" id="fa-up" style="bottom: 0px;top: -2px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Show more</strong>').removeClass('isopen').slideDown( "slow" );
            $(".watched-hidden-content").slideUp( "slow" );
        }else {
            $(".button-toggle-content").html('<i class="fas fa-sort-up" id="fa-up" style="bottom: 0;top: 4px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Hide</strong>').addClass('isopen');
            $(".watched-hidden-content").slideDown( "slow" );
        }
    });
});
</script>

<style type="text/css">
     .top-stocks .to-content-part ul .even span {
        border: 2px solid;
        height: 42px;
        width: 42px;
        line-height: 40px;
        font-size: 11px !important;
        text-align: center;
        display: block; 
        border-radius: 25px;
    }
    .top-stocks .to-content-part ul .even a{
        width: 75%;
        color: #fff;
        font-weight: 500;
    }
    .top-stocks .to-content-part ul .odd a{
        width: 75%;
    }
    
    .top-stocks .to-content-part ul .even {
        display: inline-flex;
        text-overflow: ellipsis;
        width: 98%;
        padding: 7px;
        padding-left: 11px;
    }
    .top-stocks .to-content-part ul .odd {
        display: inline-flex;
        text-overflow: ellipsis;
        width: 98%;
        padding: 7px;
        padding-left: 11px;
    }
    .top-stocks .to-content-part ul .odd span {
        border: 2px solid;
        height: 42px;
        width: 42px;
        line-height: 40px;
        font-size: 11px !important;
        text-align: center;
        display: block;
        border-radius: 25px;
    }
    .watch-list-inner .to-content-part .even tr:last-child {
        border-bottom: none !important;
    }
   .top-stocks {
    background-color: #142b46;
}
    .top-stocks .to-top-title {
        padding-top: 10px !important;
        padding-left: 15px !important;
        padding-bottom: 0 !important;
    }
    .to-bottom-seemore {
        padding: 0px 0px 8px 16px;
        font-size: 12px !important;
        font-weight: 300 !important;
        cursor: pointer;
        color: #d8d8d8 !important;
    }
    .see-more-btn, .see-more-btn a {
        color: #d8d8d8 !important;
    }
    .hide-show {
        display: none;
    }
    .right-dashboard-part {
        float: left;
        width: 27%;
        padding: 21px 0px !important;
    }
    .top-stock .to-content-part {
        padding-bottom: 0 !important;
    }
    .top-stocks .to-content-part ul li a {
        padding: 2px 10px !important;
    }
    .top-stocks .to-content-part ul .even a p{
        color: #999999 !important;
        margin-bottom: 0;
    }
    .top-stocks .to-content-part ul .odd a p{
        color: #999999 !important;
        margin-bottom: 0;
    }
    .top-stocks .to-content-part {
        padding-bottom: 0 !important;
    }
    .gravatar .avatar .avatar-80 .um-avatar .um-avatar-default {
        top: 17px !important;
        bottom: 8px !important;
        position: relative !important;
    }

	.to-content-part {
	    background: #142c46;
	    padding:4px;
	}

	hr.style14.style13 {
    display: none;
}



</style>
