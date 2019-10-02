<div class="button" style="float: right; margin-top: 3px;margin-left: -10px;">
    <a href="#" data-toggle="modal" data-target="#depositmods" class="arbitrage-button arbitrage-button--primary" style="padding: 5px 10px;font-weight: 400;">Fund</a>
    <div class="modal" id="depositmods" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-modelbox-margin" role="document" style="left: 0; width: 300px">
            <div class="modal-content modalfund">
                <div class="modal-header header-depo">

                    <span class="fundtabs" id="funds"> 
                        <ul class="nav panel-tabs">
                            <li class="active">
                                <a href="#tabdeposit" data-toggle="tab" class="active show">Deposit</a>
                            </li>
                            <?php if ($dbaseaccount > 0): ?>
                                <li>
                                    <a href="#tabwithdraw" data-toggle="tab" class="">Withdraw</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </span> 
                    <button type="button" class="close close-depo" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times modal-btn-close-deposit"></i>
                    </button>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tabdeposit">
                        <hr class="style14 style15">
                        <div class="button-funds groupinput select" style="z-index: 25; margin-bottom: 0; margin-left: 4px;">
                            <select class="rnd" name="" id="selectdepotype" style="z-index: 20;">
                                <option class="deposit-modal-btn show-button1" value="deposit">Deposit Funds</option>
                                <option class="deposit-modal-btn show-button2" value="dividend">Dividend Income</option>
                            </select>
                        </div>
                        <form action="/journal" method="post" class="add-funds-show depotincome">
                                <div class="dmainform">
                                    <div class="dinnerform">
                                        <div class="dinitem" style="margin: 10px;">
                                            <h5 class="modal-title title-depo-in" id="exampleModalLabel" style="font-weight: 300;font-size: 13px;">Enter Amount</h5>
                                            <div class="dninput"><input type="text" name="damount" class="depo-input-field number" style="background: #4e6a85; text-align: right;"></div>
                                        </div>
                                    </div>
                                </div>

                            <div class="modal-footer footer-depo">
                                <input type="hidden" name="ddate" value="<?php echo date('Y-m-d'); ?>">
                                <input type="hidden" name="istype" value="deposit">
                                <a href="#" class="depotbutton arbitrage-button arbitrage-button--primary" style="font-size: 12px;font-weight: 300; padding: 3px 14px;">Deposit</a>
                            </div>
                        </form>
                        <form action="/journal" method="post" class="add-funds-shows dividincome" style="display: none;">
                                <div class="modal-body depo-body">
                                    <div class="dmainform">
                                        <div class="dinnerform">
                                            <div class="dinitem">
                                                <h5 class="modal-title title-depo-in" id="exampleModalLabel">Dividend Income</h5>
                                                <div class="dninput modal-title-content-dev"><input type="text" name="damount" class="depo-input-field" style="text-align: right;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer footer-depo">
                                    <input type="hidden" name="ddate" value="<?php echo date('Y-m-d'); ?>">
                                    <input type="hidden" name="istype" value="dividend">
                                    <a href="#" class="divibutton arbitrage-button arbitrage-button--primary">Deposit</a>
                                </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tabwithdraw">                                                                                                        
                        <form action="/journal" method="post">
                            <div class="modal-header header-depo">
                                <h5 class="modal-title title-depo" id="exampleModalLabel"></h5>
                            </div>
                            <hr class="style14 style15">
                            <div class="modal-body depo-body">
                                <div class="dmainform-withraw" style="margin-top: 28px;">
                                    <div class="dinnerform">
                                        <div class="dinitem arb_wdrw">
                                            <div class="dnlabel arb_wdrw_left" style="font-size: 13px;font-weight: 300;">Enter Amount</div>
                                            <div class="dninput arb_wdrw_right"><input type="text" class="dwithdrawnum depo-input-field number" style="padding: 3px 11px 3px 11px !important;" data-dpower="<?php echo $dbaseaccount; ?>" name="damount" placeholder="<?php //echo number_format($dbaseaccount, 2, '.', ','); ?>"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer footer-depo">
                                <input type="hidden" name="ddate" value="<?php echo date('Y-m-d'); ?>">
                                <input type="hidden" name="istype" value="withraw">
                                <input type="submit" class="dwidfunds arbitrage-button arbitrage-button--primary" name="subs" value="Withdraw" style="margin-bottom: 3px; margin-top: 10px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>