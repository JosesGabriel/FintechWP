
var today = new Date();
var currentDate = today.getFullYear()+'-'+ ('0' + (today.getMonth()+1)).slice(-2) +'-'+ ("0" + today.getDate()).slice(-2);	
jQuery(".buySell__date-picker").attr('max',currentDate);
function editEvent(event) {
    jQuery('#event-modal input[name="event-index"]').val(event ? event.id : '');
    jQuery('#event-modal input[name="event-name"]').val(event ? event.name : '');
    jQuery('#event-modal input[name="event-location"]').val(event ? event.location : '');
    jQuery('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
    jQuery('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
    jQuery('#event-modal').modal();
}

function getObject(event){
    jQuery(".dtopentertrade").find("#newdate").val(event.value);
}
function buydate(event){
    jQuery(".buyaddtrade").find("#addstockisdate").val(event.value);
}
function selldate(event){
    jQuery("#selldate").val(event.value);
}

jQuery(document).ready(function(){
    jQuery('.add-funds-show').show();
    jQuery('.add-funds-shows').hide();
    var x = 0;
    var y = 0;

    jQuery(".show-button2").click(function(e){
        e.preventDefault();
        jQuery('.add-funds-shows').hide();
        jQuery('.add-funds-show').show();
    });
    jQuery(".show-button1").click(function(e){
        e.preventDefault();
        jQuery('.add-funds-show').hide();
        jQuery('.add-funds-shows').show();
    });
    // jQuery('td[name=tcol1]')
    jQuery('.textfield-buyprice').keyup(function(){
        
        var inputVal = jQuery(this).val().length;													
        if(inputVal != 0){
            $('.confirmtrd').prop('disabled', false);
             x = 1;

        }else{
            $('.confirmtrd').prop('disabled', true);
        }
    });

    jQuery('.textfield-quantity').keyup(function(){
        var inputVal2 = jQuery(this).val().length;
        if(inputVal2 != 0){
            y = 1;
        }
    });

    $(".confirmtrd").click(function(e){

        console.log('==>');
        //if(x == 1 && y == 1) {
            $('.chart-loader').css("display","block");
            $(this).hide();
        //}
        
    });

    jQuery("#buy-order--submit").click(function(){

        console.log('...sell');
        if($('#sell_price--input').val().length > 0 && $('#qty_price--input').val().length > 0) {
            
             $('.chart-loader').css("display","block");
             $(this).hide();
        }

    });


    jQuery(".changeselldate").change(function() {
        var date = $(this).val();
    });
    
    jQuery(".editmenow").click(function(){

    //$(document).on("click", ".editmenow", function() {
        var ulogid = jQuery(this).attr('data-istl');

        var strat = jQuery('.strat_'+ ulogid).val();
        var tplan = jQuery('.tplan_'+ ulogid).val();
        var emot = jQuery('.emot_'+ ulogid).val();
        var tnotes = jQuery('.tnotes_'+ ulogid).val();
        jQuery(".edittlogs_" + ulogid).find("#strategy").val(strat);
        jQuery(".edittlogs_" + ulogid).find("#trade_plan").val(tplan);
        jQuery(".edittlogs_" + ulogid).find("#emotion").val(emot);
        jQuery(".edittlogs_" + ulogid).find("#tlnotes").val(tnotes);

        $('.chart-loader').css("display","block");
        $(this).hide();

        jQuery('.edittlogs_' + ulogid).submit();

    });

    $(".deletelive").on('click', function(e){
        e.preventDefault();

        /// journal/?todo=deletelivetrade&stock=

        let dstock = $(this).attr('data-stock');
        let dtotalprice = $(this).attr('data-totalprice');
        

        swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this entry!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                console.log('delete this');
                console.log(dstock);
                window.location.href = "/journal/?todo=deletelivetrade&stock="+dstock+"&totalbase="+dtotalprice;
            }
        });
    });

    $('.deletelog').on('click', function () {
        var dlogid = jQuery(this).attr('data-istl');

        swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this entry!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                console.log('delete this');
                jQuery(this).parents(".dloglist").addClass("housed");
                jQuery(".deleteformitem").find("#todelete").val(dlogid);
                jQuery(".deleteformitem").submit();
            }
        });
    });

    jQuery("#inpt_data_select_stock").on('change', function() {
        var datts = this.value;
        var dstocks = $.parseJSON(datts);

        jQuery("input[name='inpt_data_currprice']").val((dstocks.last).toFixed(2));
        jQuery("input[name='inpt_data_change']").val((dstocks.change).toFixed(2));
        jQuery("input[name='inpt_data_open']").val((dstocks.open).toFixed(2));
        jQuery("input[name='inpt_data_low']").val((dstocks.low).toFixed(2));
        jQuery("input[name='inpt_data_high']").val((dstocks.high).toFixed(2));
        var numseprvm = dstocks.volume.toFixed(2);
        var numseprve = dstocks.value.toFixed(2);
        jQuery("input[name='inpt_data_volume']").val(replaceCommas(numseprvm));
        jQuery("input[name='inpt_data_value']").val(replaceCommas(numseprve));
        
        // board lot
        var dboard = 0;
        if (dstocks.last >= 0.0001 && dstocks.last <= 0.0099) {
            dboard = '1,000,000';
        } else if (dstocks.last >= 0.01 && dstocks.last <= 0.049) {
            dboard = '100,000';
        } else if (dstocks.last >= 0.05 && dstocks.last <= 0.495) {
            dboard = '10,000';
        } else if (dstocks.last >= 0.5 && dstocks.last <= 4.99) {
            dboard = '1,000';
        } else if (dstocks.last >= 5 && dstocks.last <= 49.95) {
            dboard = 100;
        } else if (dstocks.last >= 50 && dstocks.last <= 999.5) {
            dboard = 10;
        } else if (dstocks.last >= 1000) {
            dboard = 5;
        } 

        jQuery("input[name='inpt_data_boardlot']").val(dboard);
        jQuery("input[name='inpt_data_stock']").val(dstocks.symbol);

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

    jQuery(".dloadform").click(function(e){
        e.preventDefault();
        var dstock = $(".dentertrade #inpt_data_select_stock").val().replace(/,/g, '');
        var dbuypower = parseFloat($(".dentertrade #input_buy_product").val().replace(/,/g, ''));
        var total_price = parseFloat(jQuery('input[name="inpt_data_total_price"]').val().replace(/,/g, ''));
        var buySell__date = jQuery('#journal__trade-btn--date-picker').val();

        if(dstock != "" && dbuypower > 0 && total_price < dbuypower && buySell__date != ""){
            jQuery(".dentertrade").submit();
        } else if (buySell__date == "") {
            swal('Date is required.');
            jQuery('.chart-loader').hide();
            jQuery('.confirmtrd').show();
        } else if (total_price < dbuypower) {
            swal('Not enough funds.');
            jQuery('.chart-loader').hide();
            jQuery('.confirmtrd').show();
        }
    });

    function thetradefees(totalfees, istype){
        // Commissions
        let dpartcommission = totalfees * 0.0025;
        let dcommission = (dpartcommission > 20 ? dpartcommission : 20);
        // TAX
        let dtax = dcommission * 0.12;
        // Transfer Fee
        let dtransferfee = totalfees * 0.00005;
        // SCCP
        let dsccp = totalfees * 0.0001;
        let dsell = totalfees * 0.006;
        let dall;
        if (istype == 'buy') {
            dall = dcommission + dtax + dtransferfee + dsccp;
        } else {
            dall = dcommission + dtax + dtransferfee + dsccp + dsell;
        }

        return dall;
    }


    jQuery(document).on('keyup', 'input[name="inpt_data_price_bought"], input[name="inpt_data_qty_bought"]', function (e) {
        let price = jQuery('input[name="inpt_data_price_bought"]').val().replace(/,/g, '');
        let quantity = jQuery('input[name="inpt_data_qty_bought"]').val().replace(/,/g, '');

        let totalmarket = parseFloat(price) * parseFloat(quantity);
        let finalcost = totalmarket + parseFloat(thetradefees(totalmarket, 'buy'));
        let wdecimal = finalcost.toFixed(2);
        if(!isNaN(finalcost)){
            jQuery('input[name="inpt_data_total_bought_price"]').val(replaceCommas(wdecimal));
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

    jQuery(document).on('keyup', 'input[name="inpt_data_price_sold"], input[name="inpt_data_qty_sold"]', function (e) {
        let boughtfinal = jQuery('input[name="inpt_data_total_bought_price"]').val().replace(/,/g, '');

        let price = jQuery('input[name="inpt_data_price_sold"]').val().replace(/,/g, '');
        let quantity = jQuery('input[name="inpt_data_qty_sold"]').val().replace(/,/g, '');

        let totalmarket = parseFloat(price) * parseFloat(quantity);
        let finalcost = totalmarket - parseFloat(thetradefees(totalmarket, 'sell'));
        let finalbought = finalcost.toFixed(2);
        let totalfinalsold = finalcost - boughtfinal;
        let finalsold = totalfinalsold.toFixed(2);
        if(!isNaN(finalcost)){
            jQuery('input[name="inpt_data_total_sold_price"]').val(replaceCommas(finalbought));
            jQuery('input[name="inpt_data_total_sold_profitloss"]').val(replaceCommas(finalsold));
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

    jQuery(document).on('change', '#inpt_data_stock_bought', function() {
        let dstock = this.value;
        jQuery("#inpt_data_stock_sold").val(dstock);

    });

    jQuery(document).on('change', '#inpt_data_stock_sold', function() {
        let dstock = this.value;
        jQuery("#inpt_data_stock_bought").val(dstock);

    });

    // calculate total price
    jQuery(document).on('keyup', '#entertopdataprice, #entertopdataquantity', function (e) {
        let price = jQuery('#entertopdataprice').val().replace(/,/g, '');
        let quantity = jQuery('#entertopdataquantity').val().replace(/,/g, '');
        // let quantity = jQuery('#entertopdataquantity').val();
        
        let total_price = parseFloat(price) * Math.trunc(quantity);
        total_price = isNaN(total_price) || total_price < 0 ? 0 : parseFloat(total_price).toFixed(2);

        let finaltotal = parseFloat(total_price) + parseFloat(thetradefees(total_price, 'buy'));
        let decnumbs = finaltotal.toFixed(2);
        jQuery('input[name="inpt_data_total_price"]').val(replaceCommas(decnumbs));

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
    
    jQuery('#selectdepotype').on('change', function() {
        // alert( this.value );
        jQuery("#tabdeposit").find('input[name="istype"]').val(this.value);

    });


    jQuery(".depotbutton").click(function(e){
        
        var dinputinfo = jQuery(this).parents(".depotincome").find(".depo-input-field").val();

        if(dinputinfo != ""){
            jQuery(".depotincome").submit();
        } else {
            swal("field should not be empty");
        }
    });

    jQuery(".divibutton").click(function(e){
        
        var dinputinfo = jQuery(this).parents(".dividincome").find(".depo-input-field").val();

        if(dinputinfo != ""){
            jQuery(".dividincome").submit();
        } else {
            swal("field should not be empty");
        }
    });

    jQuery("li.dspecitem").click(function(e){
        if (jQuery(this).hasClass("ledgeopened")) {
            jQuery(this).removeClass("ledgeopened");
            jQuery(this).find(".ddetailshere").hide('slow');
        } else {
            jQuery(this).addClass("ledgeopened");
            jQuery(this).find(".ddetailshere").show('slow');
        }

    });

    jQuery('.resetdata').click(function(e){
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover your Journal Data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            jQuery('.resetform').submit();
        } 
        });
    });
    jQuery('.dbuttonrecord').click(function(e){
        e.preventDefault();
        jQuery('.record_modal').show();
    });
    jQuery('.to_closethis_rec').click(function(e){
        e.preventDefault();
        jQuery('.record_modal').hide();
    });


    jQuery(".dwidfunds").click(function(e){
        if ($dwidraw > 0) {
            $dbuypower = jQuery(this).parents(".modal-content").find(".dwithdrawnum").attr('data-dpower');
            $dwidraw = jQuery(this).parents(".modal-content").find(".dwithdrawnum").val();
            if (parseFloat($dbuypower) <= parseFloat($dwidraw) ) {
                e.preventDefault();
                if (!jQuery(this).parents(".modal-content").find(".errormessage").length) {
                    jQuery(this).parents(".modal-content").find(".dinitem").append('<div class="errormessage">You cant exceed by ₱'+$dbuypower+'</div>');
                }
            }
        } else {
            e.preventDefault();
        }
    });
    
    jQuery(".dmoveto").click(function(e){
        e.preventDefault();
        // ptchangenum
        // jQuery("#ptchangenum").submit();
        var dnumsec = jQuery("#ptchangenum").find("#ptnum").val();
        if(parseInt(dnumsec) <= 0 || dnumsec.length === 0 ){

        } else {
            jQuery("#ptchangenum").submit();
        }
    });

    jQuery(".lddmoveto").click(function(e){
        e.preventDefault();
        // ptchangenum
        // jQuery("#ptchangenum").submit();
        var dnumsec = jQuery("#ldchangenum").find("#ldnum").val();
        if(parseInt(dnumsec) <= 0 || dnumsec.length === 0 ){

        } else {
            jQuery("#ldchangenum").submit();
        }
    });


    jQuery('.search-logs').on('keyup', function () {

        var totalrow = $('input[name="hsearchlogs"]').val();

        if($(this).val().length < 1) {
            jQuery('.dloglist').css("display","block");
            for(var x = 0; x < totalrow; x++){
                jQuery('.s-logs'+ x).remove();
            }
            $('.s-logs').remove();
                
        }else {
            jQuery('.dloglist').css("display","none");
            jQuery('.s-logs').css("display","block");
            var keyword = $(this).val();
                
            var tdate = $('.tdate').text();
            //var tdata = new Array($('.tdata').text());
            //var tdata = [];
            var td =  $(".tdata").text().length
            var tcolor;
            for(var i = 0; i < totalrow; i++){
                var tdata = $('#tdata' + i).text();
                var tdate = $('#tdate' + i).text();
                var tquantity = $('#tquantity' + i).text();
                var tavprice = $('#tavprice' + i).text();
                var tbvalue = $('#tbvalue' + i).text();
                var tsellprice = $('#tsellprice' + i).text();
                var tsellvalue = $('#tsellvalue' + i).text();
                var tploss = $('#tploss' + i).text();
                var tpercent = $('#tpercent' + i).text();
                var dprofit = $('#dprofit' + i).val();
                var deletelog = $('#deletelog' + i).val();

                //if(keyword == tdata){
                var rgxp = new RegExp(keyword, "gi");

                if (tdata.match(rgxp)) {

                        if(dprofit > 0 ){
                            tcolor = 'txtgreen';
                        }else{
                            tcolor = 'txtred';
                        }
                    
                    if($('#logrows-'+ i).hasClass('s-logs'+ i)){
                        $('.s-logs').remove();
                        return;

                    }else{

                        $('.dstatstrade1 ul').append(
                        $("<li class='s-logs"+ i +"' id='logrows-" + i+ "'><div style='width:99%;' class='tdatalogs"+ i +"'><div style='width:65px'>" + tdate + "</div><div style='width:45px; margin-left: 13px;'><a href='/chart/"+ tdata +"' class='stock-label'>"+ tdata +"</a></div><div style='width:55px; margin-left: -10px;margin-right: 10px;' class='table-cell-live'>" + tquantity + "</div><div style='width:65px' class='table-cell-live'>" + tavprice + "</div><div style='width:95px' class='table-cell-live'> "+ tbvalue +"</div><div style='width:65px' class='table-cell-live'>"+ tsellprice +"</div><div style='width:95px' class='table-cell-live'>"+ tsellvalue +"</div><div style='width:80px; margin-left: 10px;' class='"+tcolor+" table-cell-live' >" + tploss + "</div><div style='width:65px' class='"+tcolor+" table-cell-live'>" +tpercent + "</div><div style='width:35px; text-align:center;margin-left: 5px;'><a href='#tradelognotes_" + tdata + "' class='smlbtn blue fancybox-inline'><i class='fas fa-clipboard'></i></a></div><div style='width:25px'><a class='deletelog smlbtn-delete' data-istl='"+ deletelog +"' style='cursor:pointer;text-align:center'><i class='fas fa-eraser'></i></a></div></div><div class='hidethis'><div class='tradelogbox' id='tradelognotes_" + tdata + "'><div class='entr_ttle_bar'><strong>"+ tdata +"</strong> <span class='datestamp_header'></span><hr class='style14 style15' style='width: 93% !important;width: 93% !important;margin: 5px auto !important;'><div class='trdlgsbox'><div class='trdleft'><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Strategy:</strong></span> <span class='modal-notes-result modal-notes-result-toleft'></span></div><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Trade Plan:</strong></span> <span class='modal-notes-result modal-notes-result-toleft'></span></div><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Emotion:</strong></span> <span class='modal-notes-result modal-notes-result-toleft'></span></div><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Performance:</strong></span> <span class='modal-notes-result'>%</span></div><div class='onelnetrd'><span class='modal-notes-ftitle'><strong>Outcome:</strong></span> <span class='modal-notes-result'></span></div></div><div class='trdright darkbgpadd'><div><strong>Notes:</strong></div><div></div></div><div class='trdclr'></div></div> </div></li>"));
                            $('.s-logs').remove();
                    }
                            
                }else{
                    $('.s-logs' + i).remove();
                    if(!$('#norecords').hasClass('s-logs')){
                        $('.dstatstrade1 ul').append("<li class='s-logs' id='norecords'><div>No records found.</div></li>");
                    }
                }

            }
            

        }	
        
    });

    jQuery(document).on('keyup change', 'input.number', function (event) {
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
        
    //});

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
});


