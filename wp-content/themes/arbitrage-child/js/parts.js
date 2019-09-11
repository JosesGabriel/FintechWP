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