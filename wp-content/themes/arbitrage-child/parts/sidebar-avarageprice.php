<div class="add-postsis sdjalc" id="toghandlingers"  style="display: none;">

    <div class="arb_calcbox varcalc">

    <div class="bkcalcbox sccas xmakfb">

        <span><span class="toborderbot"><strong>Average Price</strong> Calculator</span><i class="fas fa-times toclasscloserss"></i></span>

    <div class="davrcalc">

        <div class="innercalc">

            <div class="topaddme">

                    <div class="tobottomsit">

                        <!-- <ul>

                            <li>Total Cost</br><span class="totalcost">612.56</span></li>

                            <li>Total Position</br><span class="totalposition">23</span></li>

                            <li>Average Price</br><span class="totalprice">26.63</span></li>

                        </ul> -->
                        <ul>
                        <div>
                            <div class="arb_calcbox_left" style="margin-bottom: 10px;">Total Cost</div>
                            <div class="arb_calcbox_right">
                                <input name="stockname" id="stockname" type="text" value="612.56" style="width:95%;">
                            </div>
                        </div>
                        <div>
                            <div class="arb_calcbox_left" style="margin-bottom: 10px;">Total Position</div>
                            <div class="arb_calcbox_right">
                                <input name="stockname" id="stockname" type="text" value="23" style="width:95%;">
                            </div>
                        </div>
                        <div>
                            <div class="arb_calcbox_left">Average Price</div>
                            <div class="arb_calcbox_right">
                                <input name="stockname" id="stockname" type="text" value="26.63" style="width:95%;">
                            </div>
                        </div>
                        
                        </ul>

                    </div>

                    <div class="midtop totopsit">

                        <div class="paramlist">
                            <div class="adprams">
                                <div style="margin-top: 20px; margin-right: 50px;">
                                    <div class="additems"><a>Add Item</a></div>
                                    <div class="calculate"><a>Calculate</a></div>
                                    <div class="clearbtn"><a>Clear</a></div>
                                </div>

                            </div>

                            <div class="jjaajs">

                                <span class="bodies" data-numcount="1">

                                    <ul class="doneitem">

                                        <li>

                                            <span>Position</span></br>

                                            <input type="text" class="dpos" placeholder="Enter Position">

                                        </li>

                                        <li>

                                            <span>Price</span></br>

                                            <input type="text" class="dpri" placeholder="Enter Price">

                                        </li>

                                    </ul>

                                </span>

                            </div>

                        </div>

                    </div>

                    

            </div>

        </div>

    </div>

</div>

</div>

</div>

<script type="text/javascript">

						    (function($) {

    jQuery(document).ready(function() {



        function getfee(marketvalue) {

            var totalfee = 0;



            var partcpms = marketvalue * 0.0025;

            var commission = (partcpms > 20 ? partcpms : 20);

            var tax = marketvalue * 0.12;

            var transfer = marketvalue * 0.00005;

            var sccp = marketvalue * 0.0001;



            totalfee = commission + tax + transfer + sccp;



            return totalfee;

        };



        jQuery(".additems a").click(function(e) {

            e.preventDefault();



            var dcount = jQuery(".paramlist div .bodies").attr('data-numcount');



            var ditem = "";

            ditem += '<ul class="doneitem">';

            ditem += '<li style="margin-top: 5px;margin-right: 3px;"><input type="text" class="dpos" placeholder="Enter Position"></li>';

            ditem += '<li style="margin-top: 5px;"><input type="text" class="dpri" placeholder="Enter Price"></li>';

            ditem += "</ul>";



            jQuery(".paramlist div .bodies").append(ditem).attr('data-numcount', (parseInt(dcount) + 1));

        });



        jQuery('.calculate a').click(function(e) {

            e.preventDefault();

            var dcount = jQuery(".paramlist div .bodies").attr('data-numcount');



            if (dcount > 0) {



                var totalcost = 0;

                var totalprice = 0;

                var totalvolume = 0;



                jQuery(".paramlist div .bodies ul").each(function(index) {



                    var dposition = (jQuery(this).find('.dpos').val() != "" ? jQuery(this).find('.dpos').val() : 0);

                    var dprice = (jQuery(this).find('.dpri').val() != "" ? jQuery(this).find('.dpri').val() : 0);

                    if (dposition > 0 && dprice > 0) {

                        totalvolume += parseFloat(dposition);

                        totalprice += parseFloat(dprice);

                        totalcost += parseFloat(dprice) * parseFloat(dposition);

                    }



                });



                var finalcost = (totalcost + parseFloat(getfee(totalcost))) / totalvolume;

                console.log(getfee(totalcost));



                jQuery(".totalcost").text((totalcost + parseFloat(getfee(totalcost))).toFixed(2));

                jQuery(".totalposition").text(totalvolume);

                jQuery(".totalprice").text((finalcost).toFixed(2));



            } else {

                console.log('cant calculate');

            }



        });

    });

})(jQuery);

</script>