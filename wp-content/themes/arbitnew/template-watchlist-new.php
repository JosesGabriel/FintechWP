<?php include_once "watchlist/header-files.php";?>

<!-- #main-header -->
<div id="main-content" class="oncommonsidebar">

    <div class="inner-placeholder">
        <div class="inner-main-content">
            <div class="left-dashboard-part">
                <div class="dashboard-sidebar-left">
                    <div class="dashboard-sidebar-left-inner">
                        <?php include_once "parts/sidebar-profile.php";?>
                    </div>
                </div>
            </div>
            <div class="center-dashboard-part">

            </div>

            <div class="right-dashboard-part">
                <div class="right-dashboard-part-inner">
                      <?php include_once "watchlist/sidebar-viewedstocks.php";?>
                      <?php include_once "watchlist/sidebar-topgainerslosers.php";?>    
                      <?php include_once "parts/sidebar-latestnews.php";?>    
                      <?php include_once "parts/sidebar-footer.php";?>               
                </div>

            </div>
            <br class="clear">

        </div>
    </div>

</div> <!-- #main-content -->
