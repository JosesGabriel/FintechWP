<div ng-controller="stockInfo">
    <div id="stock-details" style="display:block" ng-if="hasData">
        <?php require "modals/buy-sell.php" ?>

        <div style="padding: 3px 5px 5px 40px; margin-bottom: 2px;" id="sval" class="sd_border_btm">
            
            <div class="arb_stock_name"><!-- STOCK NAME -->
                <i class="fas " ng-class="{'fa-arrow-up': stock.change > 0, 'fa-arrow-down': stock.change < 0}" style="font-size: 35px;position: absolute; left: 4px;"></i>
                <div class="name text-uppercase text-default" style="font-size: 15px; font-weight: bold; white-space: nowrap; width: 100%; overflow: hidden;
                text-overflow: ellipsis;">{{stockInfo.description}}</div>
                <div class="figures" style="margin-top: 0; overflow: visible; white-space: nowrap;">
                    <span style="
                        font-size: 25px;
                        font-weight: bold;
                        letter-spacing: -1px;" class="text-default">{{stock.displayLast}}</span>
                    <span ng-class="{'text-green': stock.change > 0, 'text-red': stock.change < 0, 'text-yellow': stock.change == 0}" style="
                        font-size: 14px;
                        line-height: 1.42857143;">
                        <span style="font-size: 17px;font-weight: bold;margin-left: 5px;">{{stock.displayDifference}}</span>
                        <span style="font-size: 17px;font-weight: bold;margin-left: 5px;">({{stock.displayChange}}%)</span>
                    </span>
                    <small class="arb_markcap">Market Capitalization: {{stock.displayMarketCap}}</small>
                </div>
            </div>
        </div>

        <div class="border-default" style="min-height: 77px;">
            <div style="float: left; width: 50%;">
                <table class="table table-condensed m-b-0 ">
                    <tbody style="font-size: 10px;">
                        <tr>
                            <td style="border-top: none; font-weight: bold; padding: 5px;" class="text-uppercase">Previous</td>
                            <td style="border-top: none; font-weight: bold; padding: 5px;" class="text-default"><strong>{{stock.displayPrevious}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Low</td>
                            <td style="font-weight: bold; padding: 5px;" class="" changediv="stock.low"><strong ng-class="{'text-green': stock.low > stock.previous, 'text-red': stock.low < stock.previous}">{{stock.displayLow}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">52WkLow</td>
                            <td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock.weekYearLow > stock.last, 'text-red': stock.weekYearLow < stock.last}">{{stock.weekYearLow}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Volume</td>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase text-default" changediv="stock.volume"><strong>{{stock.volume | abbr}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Trades</td>
                            <td style="font-weight: bold; padding: 5px;" class="text-default" changediv="stock.trades"><strong>{{stock.trades | numeraljs: '0,0'}}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="float: left; width: 50%;">
                <table class="table table-condensed m-b-0 sd_border_btm">
                    <tbody style="font-size: 10px;">
                        <tr>
                            <td style="border-top: none; font-weight: bold; padding: 5px;" class="text-uppercase">Open</td>
                            <td style="border-top: none; font-weight: bold; padding: 5px;"><strong ng-class="{'text-green': stock.open > stock.previous, 'text-red': stock.open < stock.previous}">{{stock.displayOpen}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">High</td>
                            <td style="font-weight: bold; padding: 5px;" changediv="stock.high"><strong ng-class="{'text-green': stock.high > stock.previous, 'text-red': stock.high < stock.previous}">{{stock.displayHigh}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">52WkHigh</td>
                            <td style="font-weight: bold; padding: 5px;" class=""><strong ng-class="{'text-green': stock.weekYearHigh > stock.last, 'text-red': stock.weekYearHigh < stock.last}">{{stock.weekYearHigh}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Value</td>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase text-default" changediv="stock.value"><strong>{{stock.displayValue}}</strong></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; padding: 5px;" class="text-uppercase">Average</td>
                            <td style="font-weight: bold; padding: 5px;" changediv="stock.average"><strong ng-class="{'text-green': stock.average > stock.previous, 'text-red': stock.average < stock.previous}">{{stock.displayAverage}}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div class="arb_logo_placehldr">
        <h2><img src="/wp-content/themes/arbitrage-child/cd/img/Asset 4.png" style="width:53%;;vertical-align:baseline"></h2>
    </div>
</div>