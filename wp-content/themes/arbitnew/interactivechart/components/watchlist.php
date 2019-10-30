<div
    ng-controller="watchlist"
    class="vertical-box tab-pane" id="watchlists">
    <div class="arb_watchlst_cont">
        <ul class="watchlist_main">
            <li 
                ng-if="watchlist.length"
                ng-repeat="stock in watchlist">
                <div class="watch-content watchlist_1 row" style="margin:0;">
                    <div class="watch_left col-md-6 col-xs-6">
                        <span class="watch_stockcode">{{::stock.symbol}}</span><br>
                        <span class="watch_stockname">{{::stock.description}}</span>
                    </div>
                    <div class="watch_right col-md-6  col-xs-6">
                        <span class="watch_stockprice">{{stock.value | number:2}}</span><br>
                        <span 
                            ng-class="{'text-green': stock.change > 0, 'text-red': stock.change < 0, 'text-yellow': stock.change == 0}"
                            class="watch_stockchange">
                            <span class="stock_pricechange">
                                <i class="fas" ng-class="{'fa-arrow-up': stock.change > 0, 'fa-arrow-down': stock.change < 0}"></i> {{stock.change | number:2}}
                            </span>
                            <span class="stock_prcntchange">({{stock.change_percentage | number:2}}%)</span>
                        </span>
                    </div>
                </div>
            </li>
            <li ng-if="watchlist.length < 1"
                style="padding: 20px; text-align: center; color: #fff;">No watchlist data.</li>
        </ul>
    </div>
</div>