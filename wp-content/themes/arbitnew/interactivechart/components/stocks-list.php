<div
    ng-controller="stocksList"
    class="vertical-box tab-pane fade in active" id="allstock">
    <?php if ( ! WP_PROD_ENV): ?>
    <table class="table table-condensed m-b-0" style="font-size: 10px; width:90%;">
        <thead style="position: fixed; background-color: #2c3e50">
            <tr>
                <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('symbol')" style="padding: 3px 12px 3px 6px !important; cursor: pointer;">
                    <strong>STOCK</strong>
                </th>
                <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('last')" style="padding: 3px 15px 3px 4px !important; cursor: pointer;">
                    <strong>LAST</strong>
                </th>
                <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('change_percentage')" style="padding: 3px !important; cursor: pointer;">
                    <strong>CHANGE</strong>
                </th>
                <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('value')" style="padding: 3px !important; cursor: pointer;">
                    <strong>VALUE</strong>
                </th>
                <th class="text-default border-default text-left" nowrap="nowrap" ng-click="sortStocks('trades')" style="padding: 3px 3px 3px 10px !important; cursor: pointer;">
                    <strong>TRADES</strong>
                </th>
            </tr>
        </thead>
    </table>

    <table class="dstocklistitems table table-condensed m-b-0 text-inverse border-default" style="font-size: 10px; border-bottom: 1px solid; width:97%; margin-top: 19px;">
        <tbody>
            
            <tr 
                ng-repeat="stock in stocks | orderBy: sort : reverse track by stock.symbol" 
                ng-class="{'text-green': stock.displayChange > 0, 'text-red': stock.displayChange < 0, 'text-yellow': stock.displayChange == 0, 'hidden': sort != 'symbol' && !latest_trading_date.isSame(stock.lastupdatetime, 'day')}" 
                change-alt="stock"
                style="font-weight: bold;"
                >
                <td class="text-default dspecitem" style="padding: 0px 7px 0 7px !important;" ng-click="select(stock.symbol)" style="cursor: pointer;">
                    <div style="width: 0; height: 0; overflow: hidden; display: block;">
                        <input type="radio" name="selected_stock" ng-model="selectedStock" value="{{::stock.symbol}}" id="select-{{::stock.symbol}}"/>
                    </div>
                    <div class="ditemone" style="cursor: pointer;">{{::stock.symbol}}</div>
                </td>
                <td align="left" ng-click="select(stock.symbol)" style="cursor: pointer;">{{stock.last | number:2}}</td>
                <td align="left" ng-click="select(stock.symbol)" style="cursor: pointer;text-align: center;">{{stock.change_percentage | number:2}}%</td>
                <td align="left" class="text-default" ng-click="select(stock.symbol)" style="cursor: pointer;">{{stock.displayValue}}</td>
                <td align="right" class="text-default" ng-click="select(stock.symbol)" style="cursor: pointer;padding-right: 5px !important;">{{stock.trades | numeraljs:'0,0'}}</td>
            </tr>
            <tr ng-if="stocks.length == 0">
                <td colspan="5" align="center" style="color: #fff">No Data Found</td>
            </tr>
        </tbody>
    </table>
    <?php else: ?>
    <div
        style="padding: 20px; text-align: center; color: #fff;">Temporarily disabled.</div>
    <?php endif ?>
</div>