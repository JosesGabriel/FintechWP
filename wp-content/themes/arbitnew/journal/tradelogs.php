
    <div class="tradelogsbox">
        <div class="box-portlet">

            <div class="box-portlet-header" style="padding-bottom: 20px;">
            <span class="title_logss">Tradelogs</span>
                <div class="headright" style="display:none;">
                    <form action="" method="get" id="ptchangenum">
                        <input type="number" id="ptnum" name="ptnum">
                        <input type="hidden" name="pt" value="1">
                        <a href="#" class="dmoveto">Go</a>
                    </form>
                </div>
                <div class="tradelogsbutton">
                    <div class="dbuttonrecord">
                        <form action="" method="post" class="recordform">
                            <input type="hidden" name="recorddata" value="record">
                            <input type="submit" name="record" value="Record" class="record-data-btn recorddata">
                        </form>
                    </div>
                </div>
            </div>
            <div class="box-portlet-content">
                <div class="stats-info">
                    <div class="dstatstrade showtradelogs overridewidth dstatstrade1">
                        <ul>
                            <li class="headerpart headerpart-tradelogs">
                                <div style="width:100%;">
                                    <div style="width:45px">Stocks</div>                                                                                	
                                    <div style="width:65px">Date</div>
                                    <div style="width:55px" class="table-title-live">Volume</div>
                                    <div style="width:65px" class="table-title-live">Ave. Price</div>
                                    <div style="width:95px" class="table-title-live">Buy Value</div>
                                    <div style="width:65px" class="table-title-live">Sell Price</div>
                                    <div style="width:88px" class="table-title-live">Sell Value</div>
                                    <div style="width:80px" class="table-title-live">Profit/Loss</div>
                                    <div style="width:65px" class="table-title-live">%</div>
                                    <div style="width:65px; text-align:center">Action</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="deleteform">
                        <form class="deleteformitem" action="" method="post">
                            <input type="hidden" value="" name="todelete" id="todelete">
                        </form>
                    </div>
                    <!-- <div class="pagination">
                        <div class="pginner">
                            <ul>
                                <?php for ($i = 1; $i <= $dpage; ++$i) {
                                    ?>
                                    <li><a href="/journal/?pt=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php
                                } ?>
                            </ul>
                        </div>
                    </div>	 -->
                </div>
            </div>

        </div>
    </div>
    <br class="clear">

    <div class="totalpl">
            <p>Total Profit/Loss as of <?php echo date('F j, Y'); ?>: <span class="totalplscore"></span></p>
    </div>
    <br class="clear">