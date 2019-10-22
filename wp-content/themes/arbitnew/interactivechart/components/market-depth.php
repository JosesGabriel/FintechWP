<!--Market Depth-->
<div
    ng-controller="marketDepth"
    class="vertical-box tab-pane fade in active" id="tab-marketepth">
    <table class="table table-condensed m-b-0 text-default" style="font-size: 10px; width:97%">
        <col width="8">
        <col width="17%">
        <col width="16.67%">
        <col width="16.67%">
        <col width="16.67%">
        <col width="16.67%">
        <thead>
            <tr>
                <th class="border-default text-default text-center" style="padding: 3px 9px 3px 0 !important;">#</th>
                <th class="border-default text-default text-left" style="padding: 3px !important;">VOL</th>
                <th class="border-default text-default text-left" style="padding: 3px !important;">BID</th>
                <th class="border-default text-default text-right" style="padding: 3px !important;">ASK</th>
                <th class="border-default text-default text-right" style="padding: 3px !important;">VOL</th>
                <th class="border-default text-default text-right" style="padding: 3px 12px 3px 3px !important;">#</th>
            </tr>
        </thead>
    </table>
    <div class="vertical-box-row">
        <div class="vertical-box-cell">
            <div class="vertical-box-inner-cell">
                <div ng-if="!enableBidsAndAsks"
                    style="height: calc(100% - 35px); position: relative">
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center">
                        <?php if ( ! WP_PROD_ENV): ?>
                            <button
                                class="btn btn-success btn-xs"
                                type="button"
                                ng-click="enableBidsAndAsks = true">Enable</button>
                        <?php else: ?>
                            <div>Coming soon</div>
                        <?php endif ?>
                    </div>
                </div>
                <div data-scrollbar="true" data-height="90%" class="" ng-if="enableBidsAndAsks">
                    <div ng-if="!isLoading">
                        <div class="table-responsive" style="display: inline-block; width: 48.5%; vertical-align: top">
                            <table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
                                <col width="8.335%">
                                <col width="8.335%">
                                <col width="8.335%">
                                <tbody>
                                    <tr ng-repeat="bid in bids | orderBy: '-price'">
                                        <td class="text-center" change="bid.count"><span>{{bid.count > 0 ? bid.count : ''}}</span></td>
                                        <td class="text-left text-uppercase" change="bid.volume"><span>{{bid.volume > 0 ? (bid.volume | abbr) : ''}}</span></td>
                                        <td class="text-left" ng-class="{'text-green': bid.price > stock.previous, 'text-red': bid.price < stock.previous}" change="bid.price"><strong>{{bid.price > 0 ? (bid.price | price) : ''}}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!--
                        --><div class="table-responsive" style="display: inline-block; width: 48.5%; vertical-align: top">
                            <table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
                                <col width="8.335%">
                                <col width="8.335%">
                                <col width="8.335%">
                                <tbody>
                                    <tr ng-repeat="ask in asks">
                                        <td class="text-right" ng-class="{'text-green': ask.price > stock.previous, 'text-red': ask.price < stock.previous}" change="ask.volume"><strong>{{ask.price > 0 ? (ask.price | price) : ''}}</strong></td>
                                        <td class="text-right text-uppercase" change="ask.volume"><span>{{ask.volume > 0 ? (ask.volume | abbr) : ''}}</span></td>
                                        <td class="text-right" style="padding-right: 12px !important;" change="ask.count"><span>{{ask.count > 0 ? ask.count : ''}}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div ng-else
                        style="display: flex;
                            align-items: center;
                            justify-content: center;
                            height: 100%;">
                        <img src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" alt="loading" style="width: 35px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>