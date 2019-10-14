// BOF Trending Stocks
    jQuery(function(){

        function getRandomInt(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        };
        var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
        var dcount = 0;
        jQuery('.top-stocks .to-content-part ul .even span, .top-stocks .to-content-part ul .odd span').each(function(index,el){
            if (dcount == '10') {dcount = 0; }
            jQuery(el).css('border-color',colors[dcount]);
            dcount++;
        });
    });
    
    jQuery(document).ready(function(){
        jQuery(".stocks-hidden-content").click(function () {
            jQuery(".trend-content-hidden").toggle('slow');
            if(jQuery(".stocks-hidden-content").hasClass('isopen')){
                jQuery(".stocks-hidden-content").html('<i class="fas fa-sort-down" id="fa-up" style="bottom: 0px;top: -2px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Show more</strong>').removeClass('isopen').slideDown( "slow" );
                jQuery(".trend-content-hidden").slideUp( "slow" );
            }else {
                jQuery(".stocks-hidden-content").html('<i class="fas fa-sort-up" id="fa-up" style="bottom: 0;top: 4px;position: relative;font-size: 16px;margin-right: 4px;vertical-align: initial;"></i><strong>Hide</strong>').addClass('isopen');
                jQuery(".trend-content-hidden").slideDown( "slow" );
            }
        });
    });
// EOF Trending Stocks


// BOF top players
    jQuery(".othersect").hide();
    jQuery(".viewmoreplayers").click(function(){
        jQuery(".othersect").toggle('1000');

        if( $(".viewmoreplayers").text() == "View more"){
                $(".viewmoreplayers").text("Hide");
            }
        else{
                $(".viewmoreplayers").text("View more");
        }	 							

    });
// EOF top players

// BOF Bullitins
    jQuery('.srr-tab-wrap').hide();
    jQuery('.to-top-dropdown').click(function(){
        event.stopPropagation();
        jQuery('.srr-tab-wrap').toggle();
    });
    
    jQuery(document).on("click", function () {
        jQuery(".srr-tab-wrap").hide();
    });
    jQuery(document).on("click", function () {
        jQuery(".closehideme").hide();
    });
// EOF Bullitins

// BOF Sidebar Calc
jQuery(document).ready(function() {
	jQuery(".arb_sellfees").click(function() {
		jQuery(".feedetails_sell").slideToggle("fast");
	});
	jQuery(".arb_buyfees").click(function() {
		jQuery(".feedetails_buy").slideToggle("fast");
	});

	jQuery("#buyprice, #sellprice").keyup(function() {
		execlc();
	});
	jQuery("#buyprice, #sellprice").click(function() {
		execlc();
	});

	function execlc() {

		var vrnumofshares = document.getElementById("numofshares").value.replace(/[^0-9\.]/g, '');

		/* Buy */
		var vrbuyprice = document.getElementById("buyprice").value.replace(/[^0-9\.]/g, '');
		var vrbuyvalue = Math.round(vrnumofshares * vrbuyprice);
        jQuery("#buyvalue").html(numeral(vrbuyvalue).format('0,0.00'));

		/* Buy Fees */
		var vrbuycommcheck = vrbuyvalue * 0.0025;
		var vrbuycommadjst;
		if (vrbuycommcheck <= 20) {
			vrbuycommadjst = 20;
		} else {
			vrbuycommadjst = vrbuyvalue * 0.0025;
		}
		jQuery("#buycommadjst").html(numeral(vrbuycommadjst).format('0,0.00'));
		var vrbuyvatfix = vrbuycommadjst * 0.12;
		jQuery("#buyvatfix").html(numeral(vrbuyvatfix).format('0,0.00'));
		var vrbuypsetffix = vrbuyvalue * 0.00005;
		jQuery("#buypsetffix").html(numeral(vrbuypsetffix).format('0,0.00'));
		var vrbuysccpfix = vrbuyvalue * 0.0001;
		jQuery("#buysccpfix").html(numeral(vrbuysccpfix).format('0,0.00'));

		/* Buy Totals */
		var vrbuyfees = vrbuycommadjst + vrbuyvatfix + vrbuypsetffix + vrbuysccpfix;
		jQuery("#buyfees").html(numeral(vrbuyfees).format('0,0.00'));
		var vrbuytotal = vrbuyfees + vrbuyvalue;
		jQuery("#buytotal").html(numeral(vrbuytotal).format('0,0.00'));

        /* Sell */
        // var vrsellprice = document.getElementById("sellprice").value.replace(/\D/g,'');
		var vrsellprice = document.getElementById("sellprice").value.replace(/[^0-9\.]/g, '');

		var vrsellvalue = Math.round(vrnumofshares * vrsellprice);
		jQuery("#sellvalue").html(numeral(vrsellvalue).format('0,0.00'));

		/*Sell Fees*/
		var vrsellcommcheck = vrsellvalue * 0.0025;
		var vrsellcommadjst;
		if (vrsellcommcheck <= 20) {
			vrsellcommadjst = 20;
		} else {
			vrsellcommadjst = vrsellvalue * 0.0025;
		}
		jQuery("#sellcommadjst").html(numeral(vrsellcommadjst).format('0,0.00'));
		var vrsellvatfix = vrsellcommadjst * 0.12;
		jQuery("#sellvatfix").html(numeral(vrsellvatfix).format('0,0.00'));
		var vrsellpsetffix = vrsellvalue * 0.00005;
		jQuery("#sellpsetffix").html(numeral(vrsellpsetffix).format('0,0.00'));
		var vrsellsccpfix = vrsellvalue * 0.0001;
		jQuery("#sellsccpfix").html(numeral(vrsellsccpfix).format('0,0.00'));
		var vrsellsaletxfix = vrsellvalue * 0.006;
		jQuery("#sellsaletxfix").html(numeral(vrsellsaletxfix).format('0,0.00'));

		/* Sell Totals */
		var vrsellfees = vrsellcommadjst + vrsellvatfix + vrsellpsetffix + vrsellsccpfix + vrsellsaletxfix;
		jQuery("#sellfees").html(numeral(vrsellfees).format('0,0.00'));
		var vrselltotal = vrsellvalue - vrsellfees;
		jQuery("#selltotal").html(numeral(vrselltotal).format('0,0.00'));

		var vrarbnetprofitf = vrselltotal - vrbuytotal;
		jQuery("#arbnetprofitf").html(numeral(vrarbnetprofitf).format('0,0.00'));

		var vrarbperctg = vrarbnetprofitf / vrbuytotal * 100;
		jQuery("#arbperctg").html(numeral(vrarbperctg).format('0,0.00'));

		if (vrbuytotal > vrselltotal) {
			jQuery(".textchangecolor").addClass("arbredtxt");
			jQuery(".textchangecolor").removeClass("arbgreentxt");
		} else {
			jQuery(".textchangecolor").addClass("arbgreentxt");
			jQuery(".textchangecolor").removeClass("arbredtxt");
		}

		/*Breakeven*/

		var vrbrkevnflat1 = vrbuyprice * 0.011;
		var vrbrkevnflat2 = Number(vrbuyprice) + Number(vrbrkevnflat1);
		jQuery("#brkevnflat").html(numeral(vrbrkevnflat2).format('0,0.00'));

		var vrbrkevn2001 = Number(vrbrkevnflat2) * 0.2;
		var vrbrkevn2002 = Number(vrbrkevnflat2) + Number(vrbrkevn2001);
		jQuery("#brkevn200").html(numeral(vrbrkevn2002).format('0,0.00'));

		var vrbrkevn1001 = Number(vrbrkevnflat2) * 0.1;
		var vrbrkevn1002 = Number(vrbrkevnflat2) + Number(vrbrkevn1001);
		jQuery("#brkevn100").html(numeral(vrbrkevn1002).format('0,0.00'));

		var vrbrkevn751 = Number(vrbrkevnflat2) * 0.075;
		var vrbrkevn752 = Number(vrbrkevnflat2) + Number(vrbrkevn751);
		jQuery("#brkevn75").html(numeral(vrbrkevn752).format('0,0.00'));

		var vrbrkevn501 = Number(vrbrkevnflat2) * 0.05;
		var vrbrkevn502 = Number(vrbrkevnflat2) + Number(vrbrkevn501);
		jQuery("#brkevn50").html(numeral(vrbrkevn502).format('0,0.00'));

		var vrbrkevn251 = Number(vrbrkevnflat2) * 0.025;
		var vrbrkevn252 = Number(vrbrkevnflat2) + Number(vrbrkevn251);
		jQuery("#brkevn25").html(numeral(vrbrkevn252).format('0,0.00'));

		var vrnegbrkevn251 = Number(vrbrkevnflat2) * 0.025;
		var vrnegbrkevn252 = Number(vrbrkevnflat2) - Number(vrnegbrkevn251);
		jQuery("#negbrkevn25").html(numeral(vrnegbrkevn252).format('0,0.00'));

		var vrnegbrkevn501 = Number(vrbrkevnflat2) * 0.05;
		var vrnegbrkevn502 = Number(vrbrkevnflat2) - Number(vrnegbrkevn501);
		jQuery("#negbrkevn50").html(numeral(vrnegbrkevn502).format('0,0.00'));

		var vrnegbrkevn751 = Number(vrbrkevnflat2) * 0.075;
		var vrnegbrkevn752 = Number(vrbrkevnflat2) - Number(vrnegbrkevn751);
		jQuery("#negbrkevn75").html(numeral(vrnegbrkevn752).format('0,0.00'));

		var vrnegbrkevn1001 = Number(vrbrkevnflat2) * 0.1;
		var vrnegbrkevn1002 = Number(vrbrkevnflat2) - Number(vrnegbrkevn1001);
		jQuery("#negbrkevn100").html(numeral(vrnegbrkevn1002).format('0,0.00'));

		var vrnegbrkevn2001 = Number(vrbrkevnflat2) * 0.2;
		var vrnegbrkevn2002 = Number(vrbrkevnflat2) - Number(vrnegbrkevn2001);
		jQuery("#negbrkevn200").html(numeral(vrnegbrkevn2002).format('0,0.00'));

	}

    jQuery('input.number').keyup(function (event) {
        // side bar calcsss
        // skip for arrow keys
        if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
        }

        var currentVal = jQuery(this).val();
        var testDecimal = testDecimals(currentVal);
        if (testDecimal.length > 1) {
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
// EOF Sidebar Calc

// BOF Var Calc
jQuery(document).ready(function(){

    $.ajax({
        url:'/wp-json/data-api/v1/stocks/history/latest?exchange=PSE',
        type: 'POST',
        dataType: 'json', // added data type
        success: function(data) {
            $.each(data.data, function(key, value){
                $(".varcalc #stockname").append('<option value="'+value.last+'">'+value.symbol+'</option>');
            });
            // $("#entertradelive input[name='input_buy_product'], .entertrade input[name='input_buy_product']").val((data.data).toFixed(2));
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
        }
    });


    jQuery("#stockname").on('change', function() {
        jQuery("#currentprice").val(this.value);
    });
    

    jQuery("#currentprice, #portalloc, #portsize, #risktoler, #targetprof, #idenentryprice, #targetprof, #noofshare").keyup(function(){exevarclc();});

    jQuery("#currentprice, #portalloc, #portsize, #risktoler, #targetprof, #idenentryprice, #targetprof, #noofshare").click(function(){exevarclc();});

    

    function exevarclc(){

        /* ENTER STOCK DETAILS */

        var vr_currentprice = jQuery('#currentprice').val().replace(/[^0-9\.]/g, ''); // 12.5


        /* PORTFOLIO PLANNING */

        var vr_portsize = jQuery('#portsize').val().replace(/[^0-9\.]/g, ''); // 100,000

        var vr_portalloc = jQuery('#portalloc').val().replace(/[^0-9\.]/g, ''); // 30

        var vr_portallocdeci = Number(vr_portalloc) / 100; 

        var vr_posisizemin = Math.round(Number(vr_portallocdeci) * Number(vr_portsize));

        jQuery('#posisize').val(numeral(vr_posisizemin).format('0,0.00'));

        

        /* TRADE PLANNING */

        var vr_idenentryprice = jQuery('#idenentryprice').val().replace(/[^0-9\.]/g, '');

        var vr_risktoler = jQuery('#risktoler').val().replace(/[^0-9\.]/g, '');

        var vr_targetprof = jQuery('#targetprof').val().replace(/[^0-9\.]/g, '');

        var vr_stoploss = jQuery('#stoploss').val(numeral(vr_risktoler).format('0,0.00'));

        

        var vr_takeprofitpricetot0 = Number(vr_targetprof) / 100;

        var vr_takeprofitpricetot1 = Number(vr_idenentryprice) * Number(vr_takeprofitpricetot0);

        var vr_takeprofitpricetot2 = Number(vr_idenentryprice) + Number(vr_takeprofitpricetot1);

        var vr_takeprofitprice = jQuery('#takeprofitprice').val(numeral(vr_takeprofitpricetot2).format('0,0.00'));

        

        var vr_stoplosspricetot1 = Number(vr_risktoler) / 100;

        var vr_stoplosspricetot2 = Number(vr_idenentryprice) - Number(vr_stoplosspricetot1);

        var vr_stoplossprice = jQuery('#stoplossprice').val(numeral(vr_stoplosspricetot2).format('0,0.00'));
        

        var vr_valueatrisk1 = Number(vr_risktoler) / 100;

        var vr_valueatrisk2 = Number(vr_posisizemin) * Number(vr_valueatrisk1)

        var vr_valueatrisk = jQuery('#valueatrisk').val(numeral(vr_valueatrisk2).format('0,0.00'));

        

        var vr_upsidetot = Number(vr_posisizemin) * Number(vr_takeprofitpricetot0);

        var vr_upside = jQuery('#upside').val(numeral(vr_upsidetot).format('0,0.00'));

        

        /* POSITION SIZING & RRR */

 //       var boardlotget_var = $("#idenentryprice").val();
       
           var boardlotget_var = $("#idenentryprice").val().replace(/[^0-9\.]/g, '');

           boardlotget_var = parseFloat(boardlotget_var);

        var boardlotget_val;

        if ( boardlotget_var >= 0.0001 && boardlotget_var <= 0.0099){

            boardlotget_val = 1000000

        } else if ( boardlotget_var >= 0.01 && boardlotget_var <= 0.049){

            boardlotget_val = 100000

        } else if ( boardlotget_var >= 0.05 && boardlotget_var <= 0.495){

            boardlotget_val = 10000

        } else if ( boardlotget_var >= 0.5 && boardlotget_var <= 4.99){

            boardlotget_val = 1000

        } else if ( boardlotget_var >= 5 && boardlotget_var <= 49.95){

            boardlotget_val = 100

        } else if ( boardlotget_var >= 50 && boardlotget_var <= 999.5){

            boardlotget_val = 10

        } else if ( boardlotget_var >= 1000){

            boardlotget_val = 5

        }			

//         var vr_boardlot = jQuery('#boardlot').val().replace(/[^0-9\.]/g, '');			


        var vr_boardlot_tmp = jQuery('#boardlot').val(numeral(boardlotget_val).format('0,0.00'));			

        var vr_boardlot = boardlotget_val;

        var vr_noofsharetot1 = Number(vr_posisizemin) / Number(boardlotget_val);

        var vr_noofsharetot2 = Math.round(Number(vr_noofsharetot1) / Number(vr_idenentryprice));

            vr_noofsharetot2 = Number.isNaN(vr_noofsharetot2) ? 0 : vr_noofsharetot2;


        // var numofshares = vr_posisizemin / 
        
        var blots = parseFloat(boardlotget_val);
        var sharestobuy = Math.floor(vr_posisizemin / vr_idenentryprice);
        
        var slotmultiplier = Math.floor(sharestobuy / blots);
        var finalstocks = blots * slotmultiplier;

        // var vr_noofshare = jQuery('#noofshare').val(numeral(vr_noofsharetot2).format('0,0.00'));
        var vr_noofshare = jQuery('#noofshare').val(numeral(finalstocks).format('0,0.00'));

        

        var vr_risktorewardtot1 = Number(vr_valueatrisk2) / Number(vr_valueatrisk2);

        var vr_risktorewardtot2 = Number(vr_upsidetot) / Number(vr_valueatrisk2);

        var vr_risktorewardfmt = vr_risktorewardtot1 + ":" + vr_risktorewardtot2;

            vr_risktorewardfmt = Number.isNaN(vr_risktorewardtot1) || Number.isNaN(vr_risktorewardtot2) ? 0 : vr_risktorewardfmt;

        var vr_risktoreward = jQuery('#risktoreward').val(vr_risktorewardfmt);	

        

    }
    

    jQuery('input.number').keyup(function (event) {
        // skip for arrow keys
             // var calcsss
        if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
        }

        var currentVal = jQuery(this).val();
        var testDecimal = testDecimals(currentVal);
        if (testDecimal.length > 1) {
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
// EOF Var Calc

// BOF average price 
(function($) {

    jQuery(document).ready(function() {

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
            e.preventDefault();
            var dcount = jQuery(".paramlist div .bodies").attr('data-numcount');
            var ditem = "";
            ditem += '<ul class="doneitem">';
            ditem += '<li style="margin-top: 5px;margin-right: 3px;"><input type="text" class="dpos number" placeholder="Enter Position" style="font-size: 13px;"></li>';
            ditem += '<li style="margin-top: 5px;"><input type="text" class="dpri number" placeholder="Enter Price" style="font-size: 13px;"></li>';
            ditem += "</ul>";
            jQuery(".paramlist div .bodies").append(ditem).attr('data-numcount', (parseInt(dcount) + 1));
        });

        jQuery('.clearbtn a').click(function(e) {
            jQuery("#totalcost, #totalposition, #averageprice").val(0);
            jQuery(".paramlist div .bodies").empty();

            var ditem = "";

            ditem += '<ul class="doneitem">';

            ditem += '<li style="margin-top: 5px;margin-right: 3px;"><input type="text" class="dpos number" placeholder="Enter Position" style="font-size: 13px;"></li>';

            ditem += '<li style="margin-top: 5px;"><input type="text" class="dpri number" placeholder="Enter Price" style="font-size: 13px;"></li>';

            ditem += "</ul>";

            jQuery(".paramlist div .bodies").append(ditem).attr('data-numcount', 1);

        });

        jQuery('.calculate a').click(function(e) {

            e.preventDefault();

            var dcount = jQuery(".paramlist div .bodies").attr('data-numcount');

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
                    }


                });

                // var finalcost = (totalcost + parseFloat(getfee(totalcost))) / totalvolume;
                var finalcost = costfee / totalvolume;

                jQuery("#totalcost").val(numeral(costfee).format('0,0.00'));

                jQuery("#totalposition").val(numeral(totalvolume).format('0,0.00'));

                jQuery("#averageprice").val(numeral(finalcost).format('0,0.00'));

                /*
                jQuery("#totalcost").val(parseFloat(costfee).toFixed(2));

                jQuery("#totalposition").val(totalvolume);

                jQuery("#averageprice").val((finalcost).toFixed(2));
                */


            }

        });

        jQuery(document).on('keyup', 'input.number', function (event) {
            // skip for arrow keyssss
            if (event.which >= 37 && event.which <= 40) {
                event.preventDefault();
            }

            var currentVal = jQuery(this).val();
            var testDecimal = testDecimals(currentVal);
            if (testDecimal.length > 1) {
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
// EOF average price 