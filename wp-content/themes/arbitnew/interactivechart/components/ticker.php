<div class="arb_top_ticker">
    <div ng-controller="dev-ticker" class="sd_border_btm arb_custom_ticker_wrapper">
        <div class="ticker-enabler">
            <button 
                ng-click="tickerEnabler()"
                class="btn btn-xs btn-link"><i id="ticker_eye" class="fa" ng-class="{'fa-eye': enable, 'fa-eye-slash': !enable}"></i></button>
            <button 
                ng-click="$root.tickerBeep = !$root.tickerBeep"
                class="btn btn-xs btn-link"><i class="fa" ng-class="{'fa-volume-up': $root.tickerBeep, 'fa-volume-off': !$root.tickerBeep}"></i></button>
        </div>
        <ul ng-show="enable" class="list-inline marqueethis arb_custom_ticker" id="webTicker">
            <li ng-repeat="transaction in ticker" ng-class="::{'text-green': 0 < transaction.change, 'text-red': transaction.change < 0, 'text-grey': transaction.change == 0}">
                <i class="fas " ng-class="{'fa-arrow-up': transaction.change > 0, 'fa-arrow-down': transaction.change < 0, 'normpadd': transaction.change == 0}" style="font-size: 14px;"></i>
                <a href="/chart/{{::transaction.symbol}}" target="_blank"><strong class="text-white" style="font-size:14px">{{::transaction.symbol}}</strong></a><br>
                <strong style="font-black: bold !important;">{{::transaction.price}}</strong>
                &nbsp;(<strong style="font-weight: bold !important;">{{::transaction.shares}}</strong>)
            </li>
        </ul>
    </div>
</div>