<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<style type="text/css">
.number{
    font-size: 13px;
    text-align: right;
}
</style>

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
                                <input name="stockname" id="totalcost" type="text" value="0" style="width:95%;" readonly>
                            </div>
                        </div>
                        <div>
                            <div class="arb_calcbox_left" style="margin-bottom: 10px;">Total Position</div>
                            <div class="arb_calcbox_right">
                                <input name="stockname" id="totalposition" type="text" value="0" style="width:95%;" readonly>
                            </div>
                        </div>
                        <div>
                            <div class="arb_calcbox_left">Average Price</div>
                            <div class="arb_calcbox_right">
                                <input name="stockname" id="averageprice" type="text" value="0" style="width:95%;" readonly>
                            </div>
                        </div>
                        
                        </ul>

                    </div>

                    <div class="midtop totopsit">

                        <div class="paramlist">
                            <div class="adprams">
                                <div style="margin-top: 20px; padding-right: 10px; width: 100%; text-align: center;">
                                    <div class="additems"><a>Add Item</a></div>
                                    <div class="calculate" style="padding-left:10px; padding-right:10px;"><a>Calculate</a></div>
                                    <div class="clearbtn"><a>Clear</a></div>
                                </div>

                            </div>

                            <div class="jjaajs">

                                <span class="bodies" data-numcount="1">

                                    <ul class="doneitem">

                                        <li>

                                            <span>Position test</span></br>

                                            <input type="text" class="dpos number" placeholder="Enter Position" style="font-size: 13px;">

                                        </li>

                                        <li>

                                            <span>Price</span></br>

                                            <input type="text" class="dpri number" placeholder="Enter Price" style="font-size: 13px;">

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

        function turnToDecimal(event){
            console.log('show me baby');
            console.log(event)
        } 

        function getfee(marketvalue) {

            var totalfee = 0;
            var partcpms = marketvalue * 0.0025;
            var commission = (partcpms >= 20 ? partcpms : 20);
            var tax = commission * 0.12;
            var transfer = marketvalue * 0.00005;
            var sccp = marketvalue * 0.0001;
            // var sccp = 0;
            totalfee = commission + tax + transfer + sccp;
            return totalfee.toFixed(2);

        };

        jQuery(".additems a").click(function(e) {
            console.log("rhsdd");
            e.preventDefault();
            var dcount = jQuery(".paramlist div .bodies").attr('data-numcount');
            var ditem = "";
            ditem += '<ul class="doneitem">';
            ditem += '<li style="margin-top: 5px;margin-right: 3px;"><input type="text" class="dpos number" onkeyup="turnToDecimal(this)" placeholder="Enter Position" style="font-size: 13px;"></li>';
            ditem += '<li style="margin-top: 5px;"><input type="text" class="dpri number" onkeyup="turnToDecimal(this)" placeholder="Enter Price" style="font-size: 13px;"></li>';
            ditem += "</ul>";
            jQuery(".paramlist div .bodies").append(ditem).attr('data-numcount', (parseInt(dcount) + 1));

        });

        jQuery('.clearbtn a').click(function(e) {
            jQuery("#totalcost, #totalposition, #averageprice").val(0);
            jQuery(".paramlist div .bodies").empty();

            var ditem = "";

            ditem += '<ul class="doneitem">';

            ditem += '<li style="margin-top: 5px;margin-right: 3px;"><input type="text" class="dpos number" placeholder="Enter Position"></li>';

            ditem += '<li style="margin-top: 5px;"><input type="text" class="dpri number" placeholder="Enter Price"></li>';

            ditem += "</ul>";

            jQuery(".paramlist div .bodies").append(ditem).attr('data-numcount', 1);

        });

        jQuery('.calculate a').click(function(e) {

            e.preventDefault();

            var dcount = jQuery(".paramlist div .bodies").attr('data-numcount');

            console.log(dcount);


            if (dcount > 0) {



                var totalcost = 0;

                var totalprice = 0;

                var totalvolume = 0;

                var costfee = 0;


                jQuery(".paramlist div .bodies ul").each(function(index) {



                    var dposition = (jQuery(this).find('.dpos').val() != "" ? jQuery(this).find('.dpos').val().replace(/[^0-9\.]/g, '') : 0);
                    var dprice = (jQuery(this).find('.dpri').val() != "" ? jQuery(this).find('.dpri').val().replace(/[^0-9\.]/g, '') : 0);

                    if (dposition > 0 && dprice > 0) {

                        totalvolume += parseFloat(dposition);

                        totalprice += parseFloat(dprice);

                        var nscost = parseFloat(dprice) * parseFloat(dposition)
                        totalcost += nscost;

                        costfee += parseFloat(nscost) + parseFloat(getfee(nscost));
                        // console.log("fees: "+parseFloat(getfee(totalcost)));

                    }

                    



                });

                //console.log("totalvol: "+totalvolume);
                //console.log("totalprice: "+totalprice);
                //console.log("totalcost: "+totalcost);
                //console.log("costfee: "+costfee);

                // var finalcost = (totalcost + parseFloat(getfee(totalcost))) / totalvolume;
                var finalcost = costfee / totalvolume;

                // console.log("finalcost: "+finalcost);


                
                
                jQuery("#totalcost").val(numeral(costfee).format('0,0.00'));

                jQuery("#totalposition").val(numeral(totalvolume).format('0,0.00'));

                jQuery("#averageprice").val(numeral(finalcost).format('0,0.00'));

                /*
                jQuery("#totalcost").val(parseFloat(costfee).toFixed(2));

                jQuery("#totalposition").val(totalvolume);

                jQuery("#averageprice").val((finalcost).toFixed(2));
                */


            } else {

                console.log('cant calculate');

            }



        });

        jQuery('input.number').keyup(function (event) {
            // skip for arrow keyssss
            if (event.which >= 37 && event.which <= 40) {
                event.preventDefault();
            }

            var currentVal = jQuery(this).val();
            var testDecimal = testDecimals(currentVal);
            if (testDecimal.length > 1) {
                console.log("You cannot enter more than one decimal point");
                currentVal = currentVal.slice(0, -1);
            }
            jQuery(this).val(replaceCommas(currentVal));

        });

        function testDecimals(currentVal) {
            var count;
            currentVal.match(/\./g) === null ? count = 0 : count = currentVal.match(/\./g);
            return count;
        }

        function replaceCommas(yourNumber) {
            var components = yourNumber.toString().split(".");
            if (components.length === 1) 
                components[0] = yourNumber;
            components[0] = components[0].replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            if (components.length === 2)
                components[1] = components[1].replace(/\D/g, "");
            return components.join(".");
        }

    });

})(jQuery);

</script>