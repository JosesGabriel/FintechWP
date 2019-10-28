<!-- Transactions -->
<div
    ng-controller="transactions"
    class="vertical-box tab-pane fade" id="tab-transaxtions">
    <table class="table table-condensed m-b-0 text-default" style="font-size: 10px;">
        <col width="20%">
        <col width="20%">
        <col width="20%">
        <col width="20%">
        <col width="20%">
        <thead>
            <tr>
                <th class="border-default text-default" style="padding: 3px !important;">TIME</th>
                <th class="border-default text-default text-right" style="padding: 3px !important;">VOLUME</th>
                <th class="border-default text-default text-right" style="padding: 3px !important;">PRICE</th>
                <th class="border-default text-default text-right" style="padding: 3px !important;">BUYER</th>
                <th class="border-default text-default text-right" style="padding: 3px !important;">SELLER</th>
            </tr>
        </thead>
    </table>

    <div class="vertical-box-row">
        <div class="vertical-box-cell">
            <div class="vertical-box-inner-cell">
                <div
                    ng-if="!isLoading">
                    <div data-scrollbar="true" data-height="100%" class="">
                        <div class="table-responsive">
                            <table class="table table-condensed m-b-0 text-default border-bottom-1 border-default" style="font-size: 10px;">
                                <col width="20%">
                                <col width="20%">
                                <col width="20%">
                                <col width="20%">
                                <col width="20%">
                                <tbody>
                                    <tr ng-repeat="transaction in transactions">
                                    <td class="text-default text-left" nowrap="nowrap">{{::transaction.time}}</td>
                                    <td style="font-weight: bold;" class="text-default text-right text-uppercase" nowrap="nowrap">{{::transaction.shares | abbr}}</td>
                                    <td style="font-weight: bold;" class="text-default text-right" nowrap="nowrap"><strong ng-class="{'text-green': transaction.price > stock.previous, 'text-red': transaction.price < stock.previous}" style="font-weight: bold;">{{::transaction.price}}</strong></td>
                                    <td class="text-default text-right" nowrap="nowrap">{{::transaction.buyer | trim: 4}}</td>
                                    <td style="padding-right: 10px;" class="text-default text-right" nowrap="nowrap">{{::transaction.seller | trim: 4}}</td>
                                    </tr>
                                    <tr ng-show="transactions.length == 0"><td colspan="5" align="center"><br />No recent transactions</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div ng-if="isLoading"
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