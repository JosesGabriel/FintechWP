
<script>
    var getCurrentAllocation = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/currentallocation?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                                
                let colors = [];
                let items = [];
                $.each(data.data, function(key, value){
                    colors.push(value.color);
                    items.push({"category" : value.stock, "column-1" : ((value.value).toFixed(2)).toString()});
                });
                AmCharts.makeChart("chartdiv1",
                {
                    "type": "pie","balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>","innerRadius": "40%","pieX": "45%","pieY": "50%","radius": 50,"pullOutRadius": "0%","startRadius": "0%","pullOutDuration": 0,"sequencedAnimation": false,"startDuration": 0,
                    "colors": colors,
                    "labelColorField": "#FFFFFF","labelsEnabled": false,"labelTickAlpha": 1,"labelTickColor": "#FFFFFF","titleField": "category","valueField": "column-1","backgroundColor": "#000000","borderColor": "#FFFFFF","color": "#78909C","fontFamily": "Roboto","allLabels": [],"balloon": {},
                    "legend": {"enabled": true,"align": "center","autoMargins": false,"color": "#78909C","left": 0,"markerSize": 14,"markerType": "circle","position": "left","valueWidth": 80},"titles": [],
                    "dataProvider": items
                }
            );
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }
    var loadLivePortfolio = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/liveportfolio?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                // $(".adddashequity").text("₱"+(data.equity).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $.each(data.data, function(i, value){
                    if(value.profitperc > 0){
                        perfstats = 'dgreenpart';
                    }else{
                        perfstats = 'dredpart';
                    }
                    let addliveme = '';
                    addliveme += '<li class="liveitems">';
                    addliveme += '<table style="width:100%;"><tbody><tr>';
                    addliveme += '<td style="width:7%;color: #fffffe;"><a target="_blank" class="stock-label" href="/chart/'+value.stock+'">'+value.stock+'</a></td>';
                    addliveme += '<td style="width:9%" class="table-cell-live" style="padding-right: 2px;">'+(value.position.toString()).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:12%" class="table-cell-live" style="padding-right: 3px;">₱'+(value.aveprice).toFixed(3).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:14%" class="table-cell-live">₱'+(value.totalcost).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:15%" class="table-cell-live">₱'+(value.marketvalue).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:15%" class="'+ perfstats +' table-cell-live">₱'+(value.profit).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:8%" class="'+ perfstats +' table-cell-live">'+(value.profitperc).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'%</td>';
                    addliveme += '<td style="width:77px;text-align:center;">';
                    addliveme += '<a title=" " class="smlbtn fancybox-inline green buymystocks"';
                    addliveme += "data-stockdetails='"+JSON.stringify(value.livedetails)+"' data-boardlot='"+value.boardlot+"'>BUY</a>";
                    addliveme += '<a title=" " class="smlbtn fancybox-inline red sellmystocks"';
                    addliveme += "data-stockdetails='"+JSON.stringify(value.livedetails)+"' data-trades='"+JSON.stringify(value)+"'  data-position='"+value.position+"' data-stock='"+value.stock+"' data-averprice='"+value.aveprice+"' >SELL</a>";
                    addliveme += '</td>';
                    addliveme += '<td style="width:27px; text-align:center"><a data-emotion="'+value.emotion+'" data-strategy="'+value.strategy+'" data-tradeplan="'+value.tradeplan+'" data-tradingnotes="'+value.tradingnotes+'" data-outcome="'+value.outcome+'" class="livetrbut smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a></td>';
                    addliveme += '<td style="width:25px"><a data-stock="'+value.stock+'" data-totalprice="'+value.totalcost+'" class="deletelive smlbtn-delete" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></td>';
                    addliveme += '</tr></tbody></table>';
                    addliveme += '</li>';
                    $("#live_portfolio ul").append(addliveme).show('slow');
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var LoadEquity = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/equity?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                $(".adddashequity").text("₱"+(data.data.total).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var loadTradeLogs = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/tradelogs?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                $(".showtradelogs ul li.dloglist").remove();
                $.each(data.data, function(i, value){
                    if(value.perc > 0){
                        perfstats = 'dgreenpart';
                    }else{
                        perfstats = 'dredpart';
                    }
                    let addliveme = '';
                    addliveme += '<li class="dloglist">';
                    addliveme += '<div style="width:99%;">';
                    addliveme += '<div style="width:48px" class="tdata"><a href="/chart/'+value.isstock+'" class="stock-label">'+value.isstock+'</a></div>';
                    addliveme += '<div style="width:68px" class="tdate">'+value.tldate+'</div>';
                    addliveme += '<div style="width:58px" class="table-cell-live" >'+value.tlvolume+'</div>';
                    addliveme += '<div style="width:68px" class="table-cell-live" >₱'+(parseFloat(value.tlaverageprice)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</div>';
                    addliveme += '<div style="width:98px" class="table-cell-live" >₱'+(parseFloat(value.buyvalue)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</div>';
                    addliveme += '<div style="width:68px" class="table-cell-live" >₱'+(parseFloat(value.tlsellprice)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</div>';
                    addliveme += '<div style="width:91px" class="table-cell-live" >₱'+(value.sellvalue).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</div>';
                    addliveme += '<div style="width:80px" class="'+ perfstats +' table-cell-live" id="tploss1">₱'+(value.profit).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</div>';
                    addliveme += '<div style="width:76px" class="'+ perfstats +' table-cell-live" id="tpercent1">'+(value.perc).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'%</div>';
                    addliveme += '<div style="width:27px; text-align:center"><a class="smlbtn blue tldetails" data-tlstrats="'+value.tlstrats+'" data-tltradeplans="'+value.tltradeplans+'" data-tlemotions="'+value.tlemotions+'" data-tlnotes="'+value.tlnotes+'" data-outcome="'+value.outcome+'" class="smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a></div>';
                    addliveme += '<div style="width:25px"><a class="deletelog smlbtn-delete" data-istl="'+value.tlid+'" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></div>';
                    addliveme += '</div>';
                    addliveme += '</li>';
                    $(".showtradelogs ul").append(addliveme);
                });

                let totalprofit = (parseFloat(data.totalprofit)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                if (totalprofit > 0){
                    $(".totalplscore").text("₱"+totalprofit).css({"color": "#e44c3c"});
                }else{
                    $(".totalplscore").text("₱"+totalprofit).css({"color": "#27ae60"});
                }
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var loadLedger = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/ledger?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                $(".ledgerlist ul li.ledgeritems").remove();
                let addliveme = '';
                $.each(data.data, function(i, value){
                    addliveme += '<li class="ledgeritems">';
                    addliveme += '<div style="width:99%;">';
                    addliveme += '<div style="width:7.9%">'+(i + 1)+'</div>';
                    addliveme += '<div style="width:19.8%">'+value.nicedate+'</div>';
                    addliveme += '<div style="width:15%">'+value.showtext+'</div>';
                    addliveme += '<div style="width:19%" class="to-left-align">'+(value.trantype == 'withraw' ? "₱"+(parseFloat(value.tranamount)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") : "&nbsp;")+'</div>';
                    addliveme += '<div style="width:19%" class="to-left-align">'+(value.trantype == 'deposit' || value.trantype == 'dividend' ? "₱"+(parseFloat(value.tranamount)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") : "&nbsp;")+'</div>';
                    addliveme += '<div style="width:18.2%" class="to-left-align">₱ '+(parseFloat(value.tranamount)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</div>';
                    addliveme += '</div>';
                    addliveme += '</li>';
                    
                });
                $(".ledgerlist ul li.toplistpart").after(addliveme);
                $(".adddebithere").text("₱"+(parseFloat(data.debit)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $(".addcredithere").text("₱"+(parseFloat(data.creadit)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var loadPortfolioSnapshot = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/portfoliosnap?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                $(".addcapital").text("₱"+(parseFloat(data.data.capital)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $(".addyearpl").text("₱"+(data.data.profit).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $(".addyearplperc").text((data.data.profperc).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"%");
                $(".adddeposit").text("₱"+(data.data.deposit).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $(".addwidthraw").text("₱"+(data.data.withraw).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var loadBuyPower = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/buypower?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                // console.log(data);
                $("#entertradelive input[name='input_buy_product'], .entertrade input[name='input_buy_product']").val((data.data).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $("#enter_trade .av_funds").text((data.data).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $("#enter_trade #dbuypower").val(data.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var loadStocks = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/allstocks?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                $.each(data.data, function(key, value){
                    $("#inpt_data_select_stock").append("<option value='"+JSON.stringify(value)+"'>"+value.symbol+"</option>");
                    $("#inpt_data_stock_bought").append("<option value='"+value.symbol+"'>"+value.symbol+"</option>");
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var buytrade = function(userid){

    }

    $( document ).ready(function() {

        $("#enter_trade .prev").text(0);
        $("#enter_trade .trade").text(0);
        $("#enter_trade .cprice").text(0);
        $("#enter_trade .pdetails.low").text(0);
        $("#enter_trade .pdetails.open").text(0);
        $("#enter_trade .pdetails.high").text(0);
        $("#enter_trade .pdetails.klow").text(0);
        $("#enter_trade .pdetails.khigh").text(0);
        $("#enter_trade .pdetails.vol").text(0);
        $("#enter_trade .pdetails.val").text(0);
        $("#enter_trade .pdetails.av").text(0);

        // initialize fancy box
        $("#openboxmode, #opentradedetails, #opensellbox").fancybox({
            'zoomSpeedIn': 300,
            'zoomSpeedOut': 300,
            'overlayShow': true
        }); 

        $("#live_portfolio ul").on("click", ".livetrbut", function(e){
            e.preventDefault();
            console.log("libsddd");
            $("#livetradenotes .addstrats").text($(this).attr("data-strategy"));
            $("#livetradenotes .addtplan").text($(this).attr("data-tradeplan"));
            $("#livetradenotes .addemotion").text($(this).attr("data-emotion"));
            $("#livetradenotes .addoutcome").text($(this).attr("data-outcome"));
            $("#livetradenotes .addnotes").text($(this).attr("data-tradingnotes"));
            $("#opentradedetails").click();
        });

        $(".showtradelogs ul").on("click", ".tldetails", function(e){
            e.preventDefault();
            $("#livetradenotes .addstrats").text($(this).attr("data-tlstrats"));
            $("#livetradenotes .addtplan").text($(this).attr("data-tltradeplans"));
            $("#livetradenotes .addemotion").text($(this).attr("data-tlemotions"));
            $("#livetradenotes .addoutcome").text($(this).attr("data-outcome"));
            $("#livetradenotes .addnotes").text($(this).attr("data-tlnotes"));
            $("#opentradedetails").click();
        });

        $("#live_portfolio ul").on("click", ".buymystocks", function(e){
            e.preventDefault();
            let sdata = $(this).attr("data-stockdetails");
            let dstatobj = jQuery.parseJSON(sdata);``
            console.log(dstatobj);

            $("#enter_trade .cprice").text(dstatobj.last);
            $("#enter_trade .pdetails.low").text(dstatobj.low);
            $("#enter_trade .pdetails.open").text(dstatobj.open);
            $("#enter_trade .pdetails.high").text(dstatobj.high);
            $("#enter_trade .pdetails.klow").text(dstatobj.weekyearlow);
            $("#enter_trade .pdetails.khigh").text(dstatobj.weekyearhigh);
            $("#enter_trade .pdetails.vol").text(dstatobj.volume);
            $("#enter_trade .pdetails.val").text(dstatobj.value);
            $("#enter_trade .pdetails.av").text(dstatobj.average);
            $("#enter_trade .sdesc").text(dstatobj.description);

            // $("a.fancy").fancybox({
            //     'zoomSpeedIn': 300,
            //     'zoomSpeedOut': 300,
            //     'overlayShow': false
            // }); 

            // $("#entertradelive #inpt_data_stock").val(dstatobj.symbol);
            // $("#entertradelive input[name='inpt_data_currprice']").val(dstatobj.last);
            // $("#entertradelive input[name='inpt_data_change']").val((dstatobj.changepercentage).toFixed(2));
            // $("#entertradelive input[name='inpt_data_open']").val(dstatobj.open);
            // $("#entertradelive input[name='inpt_data_low']").val(dstatobj.low);
            // $("#entertradelive input[name='inpt_data_high']").val(dstatobj.high);
            // $("#entertradelive input[name='inpt_data_volume']").val(dstatobj.volume);
            // $("#entertradelive input[name='inpt_data_value']").val(dstatobj.value);
            // $("#entertradelive input[name='inpt_data_boardlot']").val($(this).attr("data-boardlot"));
            $(".opentradeitem").click();

            
            $("#enter_trade #entertopdataquantity").addClass('buymode');
            $("#enter_trade #entertopdataprice").addClass('buymodecash');
            $("#enter_trade #entertopdataquantity").val('');
            $(".footer_details2").show();
            $(".buyprice .labelprice").text("Buy Price");
            $(".modeofaction").val("buystock");
            $.ajax({
                url: "/wp-json/journal-api/v1/allstocks?userid=",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(data) {
                    // console.log(data);
                    $("select[name='inpt_data_stock_y']").attr("id","inpt_data_select_stock").removeClass("tosell");
                    $("#inpt_data_select_stock option").each(function() { $(this).remove(); });
                    $("#inpt_data_select_stock").append('<option value="">Select a Stock</option>');
                    
                    $.each(data.data, function(key, value){
                        $("#inpt_data_select_stock").append("<option value='"+JSON.stringify(value)+"' "+(value.symbol == dstatobj.symbol ? "selected='selected'" : '')+">"+value.symbol+"</option>");
                        $("#inpt_data_stock_bought").append("<option value='"+value.symbol+"'>"+value.symbol+"</option>");
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                }
            });

            
        });

        $("#live_portfolio ul").on("click", ".sellmystocks", function(e){
            e.preventDefault();
            let sdata = $(this).attr("data-stockdetails");
            let dstatobj = jQuery.parseJSON(sdata);
            console.log(dstatobj);
            // $("#selllivetrade input[name='inpt_data_stock']").val($(this).attr("data-stock"));
            // $("#selllivetrade input[name='inpt_data_position']").val($(this).attr("data-position"));
            // $("#selllivetrade input[name='inpt_data_price']").val(dstatobj.last);
            // $("#selllivetrade input[name='inpt_avr_price_b']").val((parseFloat($(this).attr("data-averprice"))).toFixed(2));
            // $("#selllivetrade input[name='inpt_avr_price']").val($(this).attr("data-averprice"));
            // $("#selllivetrade input[name='dtradelogs']").val($(this).attr("data-trades"));

            $("#enter_trade .cprice").text(dstatobj.last);
            $("#enter_trade .pdetails.low").text(dstatobj.low);
            $("#enter_trade .pdetails.open").text(dstatobj.open);
            $("#enter_trade .pdetails.high").text(dstatobj.high);
            $("#enter_trade .pdetails.klow").text(dstatobj.weekyearlow);
            $("#enter_trade .pdetails.khigh").text(dstatobj.weekyearhigh);
            $("#enter_trade .pdetails.vol").text(dstatobj.volume);
            $("#enter_trade .pdetails.val").text(dstatobj.value);
            $("#enter_trade .pdetails.av").text(dstatobj.average);
            $("#enter_trade .sdesc").text(dstatobj.description);

            $("#enter_trade #entertopdataquantity").removeClass('buymode');
            $("#enter_trade #entertopdataprice").removeClass('buymodecash');
            $("#enter_trade #entertopdataprice").val('');
            $(".footer_details2").hide();
            $(".buyprice .labelprice").text("Sell Price");
            $(".modeofaction").val("sellstock");

            
            $.ajax({
                url: "/wp-json/journal-api/v1/sellstock",
                type: 'GET',
                data: {
                    "stock": dstatobj.symbol,
	                "userid": <?php echo $user->ID; ?>
                },
                dataType: 'json', // added data type
                success: function(data) {
                    // console.log(data);
                    $("#enter_trade #entertopdataquantity").val(parseFloat(data.data.totalstock));
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                }
            });

            $.ajax({
                url: "/wp-json/journal-api/v1/stockstosell",
                type: 'GET',
                data: {
                    "userid" : <?php echo $user->ID; ?>
                },
                dataType: 'json', // added data type
                success: function(data) { 
                    // console.log(data);
                    $("select[name='inpt_data_stock_y']").attr("id","inpt_data_sell_stock").addClass("tosell");
                    $("#inpt_data_sell_stock option").each(function() { $(this).remove(); });
                    $("#inpt_data_sell_stock").append('<option value="">Select a Stock</option>');
                    $.each(data.data, function(i, event){
                        $("#inpt_data_sell_stock").append("<option value='"+JSON.stringify(event)+"' "+(event.symbol == dstatobj.symbol ? "selected='selected'" : '')+">"+event.symbol+"</option>");
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                }
            });

            $(".opentradeitem").click();


            
        });

        $( ".buymode" ).keyup(function(e) {
            let buypower = parseFloat($("#dbuypower").val());
            let buyprice = parseFloat($("#entertopdataprice").val());
            let vals = $(this).val();

            let totals = vals * buyprice;
            totals = (isNaN(totals) ? 0 : totals);
            // console.log(totals);

            if(totals > buypower){
                $(this).val(vals.substr(0, vals.length - 1))
                swal("not enough buy power");
                return false;
            } else {
                $(".tlcost").text((totals).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            }
        });

        $(".buymodecash").keyup(function(e) {
            let price = $(this).val();
            let quantity = parseFloat($("#entertopdataquantity").val());
            let buypower = parseFloat($("#dbuypower").val());

            let totals = price * quantity;
            totals = (isNaN(totals) ? 0 : totals);

            if(totals > buypower){
                $(this).val(vals.substr(0, vals.length - 1))
                swal("not enough buy power");
                return false;
            } else {
                $(".tlcost").text((totals).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
            }

        });


        $(".opentradelogtab").click(function(e){
            new loadTradeLogs(<?php echo $user->ID; ?>);
        });

        $(".openledger").click(function(e){
            new loadLedger(<?php echo $user->ID; ?>);
        });

        $(".confirm_order").click(function(e){
            e.preventDefault();
            $actiontype = $("#enter_trade .modeofaction").val();
            if($actiontype == "buystock"){
                let stocks = $(".buytrades #inpt_data_select_stock option:selected").val();
                if(stocks != ""){
                    let volume = $(".buytrades #entertopdataquantity").val();
                    let buyprice = $(".buytrades #entertopdataprice").val();
                    if(volume != "" && buyprice != ""){
                        let notes = $(".buytrades .tnotes").val();
                        let strategy = $(".buytrades .inpt_data_strategy option:selected").val();
                        let tradeplan = $(".buytrades .inpt_data_tradeplan option:selected").val();
                        let emotion = $(".buytrades .inpt_data_emotion option:selected").val();
                        let ddate = $.datepicker.formatDate('yy-mm-dd', new Date());

                        let newstocks = $.parseJSON(stocks);
                        let dstockname = newstocks.symbol;
                        console.log(dstockname);


                        $.ajax({
                            url: "/wp-json/journal-api/v1/buystocks",
                            type: 'GET',
                            data: {
                                "qty": volume,
                                "price": buyprice,
                                "buymonth": ddate,
                                "strategy": strategy,
                                "tradeplan": tradeplan,
                                "emotion": emotion,
                                "stock": dstockname,
                                "userid" : <?php echo $user->ID; ?>
                            },
                            dataType: 'json', // added data type
                            success: function(data) { 
                                $("#live_portfolio ul li.liveitems").remove();
                                $(".addcapital, .addyearpl, .addyearplperc, .adddeposit, .addwidthraw, .adddashequity").text();
                                new loadStocks();
                                new loadLivePortfolio(<?php echo $user->ID; ?>);
                                new loadBuyPower(<?php echo $user->ID; ?>);
                                new LoadEquity(<?php echo $user->ID; ?>);
                                new loadPortfolioSnapshot(<?php echo $user->ID; ?>);

                                new getCurrentAllocation(<?php echo $user->ID; ?>);
                                $("#enter_trade").modal("hide");
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                
                            }
                        });
                    } else {
                        swal("please Add Quantity and Price");
                    }
                } else {
                    swal("please select a stock");
                }
            } else {
                console.log("sell the stock");
                
                let stockinfo = $.parseJSON($("#inpt_data_sell_stock option:selected").val());
                let stock = stockinfo.symbol;
                let volume = $("#entertopdataquantity").val();
                let sellprice = $("#entertopdataprice").val();

                $.ajax({
                    url: "/wp-json/journal-api/v1/dosell",
                    type: 'GET',
                    data: {
                        "sellprice" : sellprice,
                        "volume" : volume,
                        "stock": stock,
                        "userid" : <?php echo $user->ID; ?>
                    },
                    dataType: 'json', // added data type
                    success: function(data) { 
                        // console.log(data);
                        $("#live_portfolio ul li.liveitems").remove();
                        $(".addcapital, .addyearpl, .addyearplperc, .adddeposit, .addwidthraw, .adddashequity").text();
                        new loadStocks();
                        new loadLivePortfolio(<?php echo $user->ID; ?>);
                        new loadBuyPower(<?php echo $user->ID; ?>);
                        new LoadEquity(<?php echo $user->ID; ?>);
                        new loadPortfolioSnapshot(<?php echo $user->ID; ?>);

                        new getCurrentAllocation(<?php echo $user->ID; ?>);
                        $("#enter_trade").modal("hide");

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        
                    }
                });
                

            }
            // console.log(strategy);
        });

        $("#enter_trade .btnsell").click(function(e){
            e.preventDefault(); 

            $("#enter_trade .prev").text(0);
            $("#enter_trade .trade").text(0);
            $("#enter_trade .cprice").text(0);
            $("#enter_trade .pdetails.low").text(0);
            $("#enter_trade .pdetails.open").text(0);
            $("#enter_trade .pdetails.high").text(0);
            $("#enter_trade .pdetails.klow").text(0);
            $("#enter_trade .pdetails.khigh").text(0);
            $("#enter_trade .pdetails.vol").text(0);
            $("#enter_trade .pdetails.val").text(0);
            $("#enter_trade .pdetails.av").text(0);

            $("#enter_trade #entertopdataquantity").removeClass('buymode');
            $("#enter_trade #entertopdataprice").removeClass('buymodecash');
            $(".footer_details2").hide();
            $(".buyprice .labelprice").text("Sell Price");
            $(".modeofaction").val("sellstock");
            $.ajax({
                url: "/wp-json/journal-api/v1/stockstosell",
                type: 'GET',
                data: {
                    "userid" : <?php echo $user->ID; ?>
                },
                dataType: 'json', // added data type
                success: function(data) { 
                    // console.log(data);
                    $("select[name='inpt_data_stock_y']").attr("id","inpt_data_sell_stock").addClass("tosell");
                    $("#inpt_data_sell_stock option").each(function() { $(this).remove(); });
                    $("#inpt_data_sell_stock").append('<option value="">Select a Stock</option>');
                    
                    $.each(data.data, function(i, event){
                        $("#inpt_data_sell_stock").append("<option value='"+JSON.stringify(event)+"'>"+event.symbol+"</option>");
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                }
            });
        });

        $("#enter_trade .btnbuy").click(function(e){
            // new loadStocks();
            e.preventDefault(); 

            $("#enter_trade .prev").text(0);
            $("#enter_trade .trade").text(0);
            $("#enter_trade .cprice").text(0);
            $("#enter_trade .pdetails.low").text(0);
            $("#enter_trade .pdetails.open").text(0);
            $("#enter_trade .pdetails.high").text(0);
            $("#enter_trade .pdetails.klow").text(0);
            $("#enter_trade .pdetails.khigh").text(0);
            $("#enter_trade .pdetails.vol").text(0);
            $("#enter_trade .pdetails.val").text(0);
            $("#enter_trade .pdetails.av").text(0);

            $("#enter_trade #entertopdataquantity").addClass('buymode');
            $("#enter_trade #entertopdataprice").addClass('buymodecash');

            $(".footer_details2").show();
            $(".buyprice .labelprice").text("Buy Price");
            $(".modeofaction").val("buystock");
            $.ajax({
                url: "/wp-json/journal-api/v1/allstocks?userid=",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(data) {
                    // console.log(data);
                    $("select[name='inpt_data_stock_y']").attr("id","inpt_data_select_stock").removeClass("tosell");
                    $("#inpt_data_select_stock option").each(function() { $(this).remove(); });
                    $("#inpt_data_select_stock").append('<option value="">Select a Stock</option>');
                    
                    $.each(data.data, function(key, value){
                        $("#inpt_data_select_stock").append("<option value='"+JSON.stringify(value)+"'>"+value.symbol+"</option>");
                        $("#inpt_data_stock_bought").append("<option value='"+value.symbol+"'>"+value.symbol+"</option>");
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                }
            });
        });

        $('#enter_trade').on('change', "select.tosell", function() {
            let stockinformation = $.parseJSON(this.value);
            $("#enter_trade .cprice").text(stockinformation.last);
            $("#enter_trade .pdetails.low").text(stockinformation.low);
            $("#enter_trade .pdetails.open").text(stockinformation.open);
            $("#enter_trade .pdetails.high").text(stockinformation.high);
            $("#enter_trade .pdetails.klow").text(stockinformation.weekyearlow);
            $("#enter_trade .pdetails.khigh").text(stockinformation.weekyearhigh);
            $("#enter_trade .pdetails.vol").text(stockinformation.volume);
            $("#enter_trade .pdetails.val").text(stockinformation.value);
            $("#enter_trade .pdetails.av").text(stockinformation.average);
            $.ajax({
                url: "/wp-json/journal-api/v1/sellstock",
                type: 'GET',
                data: {
                    "stock": stockinformation.symbol,
	                "userid": <?php echo $user->ID; ?>
                },
                dataType: 'json', // added data type
                success: function(data) {
                    // console.log(data);
                    $("#enter_trade #entertopdataquantity").val(parseFloat(data.data.totalstock));
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                }
            });

        });

        $('#enter_trade').on('change', "select#inpt_data_select_stock", function() {
            let stockinformation = $.parseJSON(this.value);
            $("#enter_trade .cprice").text(stockinformation.last);
            $("#enter_trade .pdetails.low").text(stockinformation.low);
            $("#enter_trade .pdetails.open").text(stockinformation.open);
            $("#enter_trade .pdetails.high").text(stockinformation.high);
            $("#enter_trade .pdetails.klow").text(stockinformation.weekyearlow);
            $("#enter_trade .pdetails.khigh").text(stockinformation.weekyearhigh);
            $("#enter_trade .pdetails.vol").text(stockinformation.volume);
            $("#enter_trade .pdetails.val").text(stockinformation.value);
            $("#enter_trade .pdetails.av").text(stockinformation.average);

            console.log(stockinformation);
            // $.ajax({
            //     url: "/wp-json/journal-api/v1/sellstock",
            //     type: 'GET',
            //     data: {
            //         "stock": stockinformation.symbol,
	        //         "userid": <?php echo $user->ID; ?>
            //     },
            //     dataType: 'json', // added data type
            //     success: function(data) {
            //         // console.log(data);
            //         $("#enter_trade #entertopdataquantity").val(parseFloat(data.data.totalstock));
            //     },
            //     error: function (xhr, ajaxOptions, thrownError) {
                    
            //     }
            // });

        });





        // load 
        new loadStocks();
        new loadBuyPower(<?php echo $user->ID; ?>);
        new loadLivePortfolio(<?php echo $user->ID; ?>);
        new LoadEquity(<?php echo $user->ID; ?>);
        new loadPortfolioSnapshot(<?php echo $user->ID; ?>);

        //
        new getCurrentAllocation(<?php echo $user->ID; ?>);
    });
</script>