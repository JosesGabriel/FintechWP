<div class="vertical-box tab-pane fade" id="watchlists">
    <div class="arb_watchlst_cont">
        <table>
            <!-- <thead style="text-transform: uppercase;font-weight: normal !important;font-family: 'Roboto', Arial !important;">
                <tr>
                    <th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Stock</strong></th>
                    <th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Day Range</strong></th>
                    <th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Price</strong></th>
                    <th style="font-weight: normal !important;font-family: 'Roboto', Arial !important;color: #dedede;"><strong>Change</strong></th>
                </tr>
            </thead> -->
            <?php
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, '/wp-json/data-api/v1/stocks/history/latest?exchange=PSE' );

                curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $dhistofronold = curl_exec($curl);
                curl_close($curl);

                $dhistoforchart = json_decode($dhistofronold);
            ?>
            <tbody>
                <?php $havemeta = get_user_meta($user_id, '_watchlist_instrumental', true); ?>
                <?php if ($havemeta && $dhistoforchart): ?>

                <?php foreach ($havemeta as $key => $value) { ?>
                <?php
                    $stockinfo = $dhistoforchart->data;
                    $dstock = $value['stockname'];
                    $dprice = 0;
                    $dchange = 0;

                        foreach($stockinfo as $stkey => $stvals){
                            if($stvals->symbol == $dstock ){
                                $dprice = $stvals->last;
                                $dchange = $stvals->changepercentage;
                                $dlow = $stvals->low;
                                $dhigh = $stvals->high;
                            }
                        }
                    ?>
                    <tr class="tr-background">
                        <td ng-click="select('<?php echo $value['stockname']; ?>')">	<div class="block"><?php echo $value['stockname']; ?></div></td>
                        <td ng-click="select('<?php echo $value['stockname']; ?>')"><?php echo number_format( $dlow, 2, '.', ',' ); ?> ~ <?php echo number_format( $dhigh, 2, '.', ',' ); ?></td>
                        <td style="text-align: left;" ng-click="select('<?php echo $value['stockname']; ?>')">
                            <?php if ($dchange > 0): ?>
                                <div class="chgreen-price" style="text-align: right;">&#8369;<?php echo number_format( $dprice, 2, '.', ',' ); ?></div>
                            <?php else: ?>
                                <div class="chred-price" style="text-align: right;">&#8369;<?php echo number_format( $dprice, 2, '.', ',' ); ?></div>
                            <?php endif ?>
                        </td>
                        <td style="padding-left: 4px !important;" ng-click="select('<?php echo $value['stockname']; ?>')">
                            <?php if ($dchange > 0): ?>
                                <div class="chgreen"><?php echo number_format( $dchange, 2, '.', ',' ); ?>%</div>
                            <?php else: ?>
                                <div class="chred"><?php echo number_format( $dchange, 2, '.', ',' ); ?>%</div>
                            <?php endif ?>

                        </td>
                    </tr>
                <?php } ?>
                <?php endif ?>

            </tbody>
        </table>
        <ul class="watchlist_main">
            <li>
                <div class="watch-content watchlist_1">
                    <span class="watch_left">
                        <span class="watch_stockcode">BDO</span>
                        <span class="watch_stockname">Banco De Oro</span>
                    </span>
                    <span class="watch_right">
                        <span class="watch_stockprice">148.30</span>
                        <span class="watch_stockchange" style="color: #25ae5f;">
                            <span class="stock_pricechange"><i class="fas  fa-arrow-up"></i>1.50</span>
                            <span class="stock_prcntchange">(1.02%)</span>
                    </span>
                </div>
            </li>
            <li>
                <div class="watch-content watchlist_2">
                    <span class="watch_left">
                        <span class="watch_stockcode">BDO</span>
                        <span class="watch_stockname">Banco De Oro</span>
                    </span>
                    <span class="watch_right">
                        <span class="watch_stockprice">148.30</span>
                        <span class="watch_stockchange" style="color: #25ae5f;">
                            <span class="stock_pricechange"><i class="fas  fa-arrow-up"></i>1.50</span>
                            <span class="stock_prcntchange">(1.02%)</span>
                    </span>
                </div>
            </li>
            <li>
                <div class="watch-content watchlist_3">
                    <span class="watch_left">
                        <span class="watch_stockcode">BDO</span>
                        <span class="watch_stockname">Banco De Oro</span>
                    </span>
                    <span class="watch_right">
                        <span class="watch_stockprice">148.30</span>
                        <span class="watch_stockchange" style="color: #25ae5f;">
                            <span class="stock_pricechange"><i class="fas  fa-arrow-up"></i>1.50</span>
                            <span class="stock_prcntchange">(1.02%)</span>
                    </span>
                </div>
            </li>
            <li>
                <div class="watch-content watchlist_4">
                    <span class="watch_left">
                        <span class="watch_stockcode">BDO</span>
                        <span class="watch_stockname">Banco De Oro</span>
                    </span>
                    <span class="watch_right">
                        <span class="watch_stockprice">148.30</span>
                        <span class="watch_stockchange" style="color: #25ae5f;">
                            <span class="stock_pricechange"><i class="fas  fa-arrow-up"></i>1.50</span>
                            <span class="stock_prcntchange">(1.02%)</span>
                    </span>
                </div>
            </li>
            <li>
                <div class="watch-content watchlist_5">
                    <span class="watch_left">
                        <span class="watch_stockcode">BDO</span>
                        <span class="watch_stockname">Banco De Oro</span>
                    </span>
                    <span class="watch_right">
                        <span class="watch_stockprice">148.30</span>
                        <span class="watch_stockchange" style="color: #25ae5f;">
                            <span class="stock_pricechange"><i class="fas  fa-arrow-up"></i>1.50</span>
                            <span class="stock_prcntchange">(1.02%)</span>
                    </span>
                </div>
            </li>
        </ul>
    </div>
</div>