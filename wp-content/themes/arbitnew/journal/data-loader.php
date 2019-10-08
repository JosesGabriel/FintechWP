
<script>
    var loadLivePortfolio = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/liveportfolio?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                $(".adddashequity").text("₱"+(data.equity).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                $.each(data.data, function(i, value){
                    if(value.profitperc > 0){
                        perfstats = 'dgreenpart';
                    }else{
                        perfstats = 'dredpart';
                    }
                    let addliveme = '';
                    addliveme += '<li>';
                    addliveme += '<table style="width:100%;"><tbody><tr>';
                    addliveme += '<td style="width:7%;color: #fffffe;"><a target="_blank" class="stock-label" href="/chart/'+value.stock+'">'+value.stock+'</a></td>';
                    addliveme += '<td style="width:9%" class="table-cell-live" style="padding-right: 2px;">'+(value.position).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:12%" class="table-cell-live" style="padding-right: 3px;">₱'+(value.aveprice).toFixed(3).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:14%" class="table-cell-live">₱'+(value.totalcost).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:15%" class="table-cell-live">₱'+(value.marketvalue).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:15%" class="'+ perfstats +' table-cell-live">₱'+(value.profit).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
                    addliveme += '<td style="width:8%" class="'+ perfstats +' table-cell-live">'+(value.profitperc).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'%</td>';
                    addliveme += '<td style="width:77px;text-align:center;">';
                    addliveme += '<a class="smlbtn fancybox-inline green buymystocks"';
                    addliveme += "data-stockdetails='"+JSON.stringify(value.livedetails)+"' data-boardlot='"+value.boardlot+"'>BUY</a>";
                    addliveme += '<a class="smlbtn fancybox-inline red sellmystocks"';
                    addliveme += "data-stockdetails='"+JSON.stringify(value.livedetails)+"' data-position='"+value.position+"' data-stock='"+value.stock+"' data-averprice='"+value.aveprice+"' >SELL</a>";
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

                let totalprofit = (parseFloat(data.totalprofit)).toFixed(2);
                $(".totalplscore").text("₱"+totalprofit);
                
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
                $("#entertradelive input[name='input_buy_product'], .entertrade input[name='input_buy_product']").val((data.data).toFixed(2));
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

    $( document ).ready(function() {

        // initialize fancy box
        $("#openboxmode, #opentradedetails, #opensellbox").fancybox({
            'zoomSpeedIn': 300,
            'zoomSpeedOut': 300,
            'overlayShow': true
        }); 

        $("#live_portfolio ul").on("click", ".livetrbut", function(e){
            e.preventDefault();
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
            let dstatobj = jQuery.parseJSON(sdata);
            console.log(dstatobj);

            $("#entertradelive #inpt_data_stock").val(dstatobj.symbol);
            $("#entertradelive input[name='inpt_data_currprice']").val(dstatobj.last);
            $("#entertradelive input[name='inpt_data_change']").val((dstatobj.changepercentage).toFixed(2));
            $("#entertradelive input[name='inpt_data_open']").val(dstatobj.open);
            $("#entertradelive input[name='inpt_data_low']").val(dstatobj.low);
            $("#entertradelive input[name='inpt_data_high']").val(dstatobj.high);
            $("#entertradelive input[name='inpt_data_volume']").val(dstatobj.volume);
            $("#entertradelive input[name='inpt_data_value']").val(dstatobj.value);
            $("#entertradelive input[name='inpt_data_boardlot']").val($(this).attr("data-boardlot"));
            $("#openboxmode").click();
        });

        $("#live_portfolio ul").on("click", ".sellmystocks", function(e){
            e.preventDefault();
            let sdata = $(this).attr("data-stockdetails");
            let dstatobj = jQuery.parseJSON(sdata);
            $("#selllivetrade input[name='inpt_data_stock']").val($(this).attr("data-stock"));
            $("#selllivetrade input[name='inpt_data_position']").val($(this).attr("data-position"));
            $("#selllivetrade input[name='inpt_data_price']").val(dstatobj.last);
            $("#selllivetrade input[name='inpt_avr_price_b']").val((parseFloat($(this).attr("data-averprice"))).toFixed(2));
            $("#selllivetrade input[name='inpt_avr_price']").val($(this).attr("data-averprice"));
            $("#opensellbox").click();
        });

        $(".opentradelogtab").click(function(e){
            new loadTradeLogs(<?php echo $user->ID; ?>);
        });

        $(".openledger").click(function(e){
            new loadLedger(<?php echo $user->ID; ?>);
        });



        // load 
        new loadStocks();
        new loadBuyPower(<?php echo $user->ID; ?>);
        new loadLivePortfolio(<?php echo $user->ID; ?>);
        new loadPortfolioSnapshot(<?php echo $user->ID; ?>);
    });
</script>