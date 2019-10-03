
<script>
    var loadLivePortfolio = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/liveportfolio?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                $.each(data.data, function(i, value){
                    let addliveme = '';
                    addliveme += '<li>';
                    addliveme += '<div style="width:99%;">';
                    addliveme += '<div style="width:7%;color: #fffffe;"><a target="_blank" class="stock-label" href="/chart/'+value.stock+'">'+value.stock+'</a></div>';
                    addliveme += '<div style="width:8%" class="table-cell-live">'+value.position+'</div>';
                    addliveme += '<div style="width:10%" class="table-cell-live">₱'+(value.aveprice).toFixed(3)+'</div>';
                    addliveme += '<div style="width:14%" class="table-cell-live">₱'+(value.totalcost).toFixed(2)+'</div>';
                    addliveme += '<div style="width:14%" class="table-cell-live">₱'+(value.marketvalue).toFixed(2)+'</div>';
                    addliveme += '<div style="width:14%" class="dredpart table-cell-live">₱'+(value.profit).toFixed(2)+'</div>';
                    addliveme += '<div style="width:7%" class="dredpart table-cell-live">'+(value.profitperc).toFixed(2)+'%</div>';
                    addliveme += '<div style="width:77px;text-align:center;">';
                    addliveme += '<a class="smlbtn fancybox-inline green buymystocks"';
                    addliveme += "data-stockdetails='"+JSON.stringify(value.livedetails)+"'>BUY</a>";
                    addliveme += '<a class="smlbtn fancybox-inline red sellmystocks"';
                    addliveme += "data-stockdetails='"+JSON.stringify(value.livedetails)+"' data-position='"+value.position+"' data-stock='"+value.stock+"' data-averprice='"+value.aveprice+"' >SELL</a>";
                    addliveme += '</div>';
                    addliveme += '<div style="width:27px; text-align:center"><a data-emotion="'+value.emotion+'" data-strategy="'+value.strategy+'" data-tradeplan="'+value.tradeplan+'" data-tradingnotes="'+value.tradingnotes+'" data-outcome="'+value.outcome+'" class="livetrbut smlbtn blue fancybox-inline"><i class="fas fa-clipboard"></i></a></div>';
                    addliveme += '<div style="width:25px"><a data-stock="'+value.stock+'" data-totalprice="'+value.totalcost+'" class="deletelive smlbtn-delete" style="cursor:pointer;text-align:center"><i class="fas fa-eraser"></i></a></div>';
                    addliveme += '<div style="width:25px; margin-left: 2px;">';
                    addliveme += '</div>';
                    addliveme += '</div>';
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
                    let addliveme = '';
                    addliveme += '<li class="dloglist">';
                    addliveme += '<div style="width:99%;">';
                    addliveme += '<div style="width:45px" class="tdata"><a href="/chart/'+value.isstock+'" class="stock-label">'+value.isstock+'</a></div>';
                    addliveme += '<div style="width:65px" class="tdate">'+value.tldate+'</div>';
                    addliveme += '<div style="width:55px" class="table-cell-live" >'+value.tlvolume+'</div>';
                    addliveme += '<div style="width:65px" class="table-cell-live" >₱'+(parseFloat(value.tlaverageprice)).toFixed(2)+'</div>';
                    addliveme += '<div style="width:95px" class="table-cell-live" >₱'+(parseFloat(value.buyvalue)).toFixed(2)+'</div>';
                    addliveme += '<div style="width:65px" class="table-cell-live" >₱'+(parseFloat(value.tlsellprice)).toFixed(2)+'</div>';
                    addliveme += '<div style="width:88px" class="table-cell-live" >₱'+(value.sellvalue).toFixed(2)+'</div>';
                    addliveme += '<div style="width:80px" class="table-cell-live" id="tploss1">₱'+(value.profit).toFixed(2)+'</div>';
                    addliveme += '<div style="width:56px" class="table-cell-live" id="tpercent1">'+(value.perc).toFixed(2)+'%</div>';
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
                    addliveme += '<div style="width:19%">'+value.nicedate+'</div>';
                    addliveme += '<div style="width:15%">'+value.showtext+'</div>';
                    addliveme += '<div style="width:18%" class="to-left-align">'+(value.trantype == 'withraw' ? "₱"+(parseFloat(value.tranamount)).toFixed(2) : "&nbsp;")+'</div>';
                    addliveme += '<div style="width:19%" class="to-left-align">'+(value.trantype == 'deposit' || value.trantype == 'dividend' ? "₱"+(parseFloat(value.tranamount)).toFixed(2) : "&nbsp;")+'</div>';
                    addliveme += '<div style="width:18%" class="to-left-align">₱ '+(parseFloat(value.tranamount)).toFixed(2)+'</div>';
                    addliveme += '</div>';
                    addliveme += '</li>';
                    
                });
                $(".ledgerlist ul li.toplistpart").after(addliveme);
                $(".adddebithere").text("₱"+(parseFloat(data.debit)).toFixed(2));
                $(".addcredithere").text("₱"+(parseFloat(data.creadit)).toFixed(2));
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
            console.log(sdata);
            
            $("#openboxmode").click();
        });

        $("#live_portfolio ul").on("click", ".sellmystocks", function(e){
            e.preventDefault();
            
            $("#opensellbox").click();
        });

        $(".opentradelogtab").click(function(e){
            new loadTradeLogs(<?php echo $user->ID; ?>);
        });

        $(".openledger").click(function(e){
            new loadLedger(<?php echo $user->ID; ?>);
        });



        // load 
        new loadLivePortfolio(<?php echo $user->ID; ?>);
    });
</script>