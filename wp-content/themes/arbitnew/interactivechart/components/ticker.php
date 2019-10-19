<div class="arb_top_ticker">
    
    <div ng-controller="ticker" class="sd_border_btm arb_custom_ticker_wrapper">
<<<<<<< HEAD
        <div class="ticker-enabler">
            <button 
                ng-click="tickerEnabler()"
                class="btn btn-xs btn-link"><i id="ticker_eye" class="fa" ng-class="{'fa-eye': enable, 'fa-eye-slash': !enable}"></i></button>
            <button 
                ng-click="$root.tickerBeep = !$root.tickerBeep"
                class="btn btn-xs btn-link"><i class="fa" ng-class="{'fa-volume-up': $root.tickerBeep, 'fa-volume-off': !$root.tickerBeep}"></i></button>
        </div>
            <ul ng-show="enable" class="list-inline marqueethis arb_custom_ticker">
                <li ng-repeat="transaction in ticker" ng-class="::{'text-green': 0 < transaction.change, 'text-red': transaction.change < 0, 'text-grey': transaction.change == 0}" data-update="item_{{::transaction.counter}}">
                    <i class="fas " ng-class="{'fa-arrow-up': transaction.change > 0, 'fa-arrow-down': transaction.change < 0, 'normpadd': transaction.change == 0}" style="font-size: 14px;"></i>
                    <a href="/chart/{{::transaction.symbol}}" target="_blank"><strong class="text-white" style="font-size:14px">{{::transaction.symbol}}</strong></a><br>
                    <strong style="font-black: bold !important;">{{::transaction.price}}</strong>
                    &nbsp;(<strong style="font-weight: bold !important;">{{::transaction.shares}}</strong>)
                </li>
            </ul>
        </div>
=======
        <ul class="ticker_enabler-dropdown">
            <a href="#" class="arb-side-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 28" width="26" height="28"><g fill="currentColor" fill-rule="evenodd"><path fill-rule="nonzero" d="M14 17a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0-1a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path><path d="M5.005 16A1.003 1.003 0 0 1 4 14.992v-1.984A.998.998 0 0 1 5 12h1.252a7.87 7.87 0 0 1 .853-2.06l-.919-.925c-.356-.397-.348-1 .03-1.379l1.42-1.42a1 1 0 0 1 1.416.007l.889.882A7.96 7.96 0 0 1 12 6.253V5c0-.514.46-1 1-1h2c.557 0 1 .44 1 1v1.253a7.96 7.96 0 0 1 2.06.852l.888-.882a1 1 0 0 1 1.416-.006l1.42 1.42a.999.999 0 0 1 .029 1.377s-.4.406-.918.926a7.87 7.87 0 0 1 .853 2.06H23c.557 0 1 .447 1 1.008v1.984A.998.998 0 0 1 23 16h-1.252a7.87 7.87 0 0 1-.853 2.06l.882.888a1 1 0 0 1 .006 1.416l-1.42 1.42a1 1 0 0 1-1.415-.007l-.889-.882a7.96 7.96 0 0 1-2.059.852v1.248c0 .56-.45 1.005-1.008 1.005h-1.984A1.004 1.004 0 0 1 12 22.995v-1.248a7.96 7.96 0 0 1-2.06-.852l-.888.882a1 1 0 0 1-1.416.006l-1.42-1.42a1 1 0 0 1 .007-1.415l.882-.888A7.87 7.87 0 0 1 6.252 16H5.005zm3.378-6.193l-.227.34A6.884 6.884 0 0 0 7.14 12.6l-.082.4H5.005C5.002 13 5 13.664 5 14.992c0 .005.686.008 2.058.008l.082.4c.18.883.52 1.71 1.016 2.453l.227.34-1.45 1.46c-.004.003.466.477 1.41 1.422l1.464-1.458.34.227a6.959 6.959 0 0 0 2.454 1.016l.399.083v2.052c0 .003.664.005 1.992.005.005 0 .008-.686.008-2.057l.399-.083a6.959 6.959 0 0 0 2.454-1.016l.34-.227 1.46 1.45c.003.004.477-.466 1.422-1.41l-1.458-1.464.227-.34A6.884 6.884 0 0 0 20.86 15.4l.082-.4h2.053c.003 0 .005-.664.005-1.992 0-.005-.686-.008-2.058-.008l-.082-.4a6.884 6.884 0 0 0-1.016-2.453l-.227-.34 1.376-1.384.081-.082-1.416-1.416-1.465 1.458-.34-.227a6.959 6.959 0 0 0-2.454-1.016L15 7.057V5c0-.003-.664-.003-1.992 0-.005 0-.008.686-.008 2.057l-.399.083a6.959 6.959 0 0 0-2.454 1.016l-.34.227-1.46-1.45c-.003-.004-.477.466-1.421 1.408l1.457 1.466z"></path></g></svg>
            </a>
            <ul id="droppouts" style="display: none;">
                <div class="ticker-enabler">
                    <button 
                        ng-click="tickerEnabler()"
                        class="btn btn-xs btn-link"><i id="ticker_eye" class="fa" ng-class="{'fa-eye': enable, 'fa-eye-slash': !enable}"></i></button>|<button 
                        ng-click="$root.tickerBeep = !$root.tickerBeep"
                        class="btn btn-xs btn-link"><i class="fa" ng-class="{'fa-volume-up': $root.tickerBeep, 'fa-volume-off': !$root.tickerBeep}"></i></button>
                </div>        
            </ul>
        </ul>
        <ul ng-show="enable" class="list-inline marqueethis arb_custom_ticker" id="webTicker">
            <li ng-repeat="transaction in ticker" ng-class="::{'text-green': 0 < transaction.change, 'text-red': transaction.change < 0, 'text-grey': transaction.change == 0}" data-update="item_{{::transaction.counter}}">
                <i class="fas " ng-class="{'fa-arrow-up': transaction.change > 0, 'fa-arrow-down': transaction.change < 0, 'normpadd': transaction.change == 0}" style="font-size: 14px;"></i>
                {{::transaction.counter}}
                <a href="/chart/{{::transaction.symbol}}" target="_blank"><strong class="text-white" style="font-size:14px">{{::transaction.symbol}}</strong></a><br>
                <strong style="font-black: bold !important;">{{::transaction.price}}</strong>
                &nbsp;(<strong style="font-weight: bold !important;">{{::transaction.shares}}</strong>)
            </li>
        </ul>
>>>>>>> 7d1b62d2575b3bbc6b46d37c1b9ce6bdc14c0086
    </div>
</div>