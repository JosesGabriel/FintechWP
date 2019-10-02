
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
                    addliveme += '<a href="#entertrade_'+value.stock+'" class="smlbtn fancybox-inline green" data-stockdetails="'+JSON.stringify(value.livedetails, null, 0)+'">BUY</a>';
                    addliveme += '<a href="#selltrade_'+value.stock+'" class="smlbtn fancybox-inline red">SELL</a>';
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

    $( document ).ready(function() {

        // initialize fancy box
        $("#openboxmode, #opentradedetails").fancybox({
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



        new loadLivePortfolio(<?php echo $user->ID; ?>);
    });
</script>