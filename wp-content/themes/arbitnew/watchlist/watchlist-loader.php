<script>
	var loadwatctlist = function(userid){
		$.ajax({
			url: "/wp-json/watchlist-api/v1/watchlists?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                console.log(data);
                
                let watchtoadd = '';

                $.each(data.data, function(key, value){

                    let stockchange = '';
                    if(value.change > 0 ){
                        stockchange = '<div class="curchange_'+value.stockname+'" style="color:#53b987;">';
                    }else if(value.change < 0){
                        stockchange = '<div class="curchange_'+value.stockname+'" style="color:#eb4d5c;">';
                    }


                    watchtoadd += '<li class="watchonlist" data-dstock="'+value.stockname+'" data-dhisto="null">';
                    watchtoadd += '<div class="row">';
                    watchtoadd += '<div class="wlttlstockvals">';
                    watchtoadd += '<div class="stocknn">'+value.stockname+'</div>';
                    watchtoadd += '<div class="s_dropdown" style="display: inline-block;">';
                    watchtoadd += '<select class="editwatchlist" name="editstock" id="" data-space="'+value.stockname+'"><option value="select" hidden=""></option><option value="delete">Delete</option><option value="edit">Edit</option></select>';
                    watchtoadd += '</div>';
                    watchtoadd += '<div class="dpricechange">';
                    watchtoadd += ' <div class="curprice_'+value.stockname+'">₱'+value.last+'</div>';
                    watchtoadd += stockchange + (value.change).toFixed(2)+'%</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '<div class="col-md-12">';
                    watchtoadd += '<div class="dchart">';
                    watchtoadd += '<div class="chartjs">';
                    watchtoadd += '<div id="chart_div_'+value.stockname+'" class="chart"></div>';
                    watchtoadd += '<div class="minichartt">';
                    watchtoadd += '<a href="/chart/'+value.stockname+'" target="_blank" class="stocklnk"></a>';
                    watchtoadd += '<div ng-controller="minichartarb'+value.stockname+'" class="ng-scope">';
                    watchtoadd += '<nvd3 options="options" data="data" class="with-3d-shadow with-transitions ng-isolate-scope"></nvd3>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '<input type="hidden" class="minchart_'+value.stockname+'" id="minchart_'+value.stockname+'" name="minchart_'+value.stockname+'" autocomplete="off">';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '<div class="dparams">';
                    watchtoadd += '<ul>';
                    if(value.dconnumber_entry_price != ""){
                        watchtoadd += '<li>';
                        watchtoadd += '<div class="dcondition">Entry Price</div>';
                        watchtoadd += '<div class="dvalue"><span class="ontoleft">'+value.dconnumber_entry_price+'</span></div>';
                        watchtoadd += '</li>';
                    }
                    if(value.dconnumber_take_profit_point != ""){
                        watchtoadd += '<li>';
                        watchtoadd += '<div class="dcondition">Take Profit</div>';
                        watchtoadd += '<div class="dvalue"><span class="ontoleft">'+value.dconnumber_take_profit_point+'</span></div>';
                        watchtoadd += '</li>';
                    }
                    if(value.dconnumber_stop_loss_point != ""){
                        watchtoadd += '<li>';
                        watchtoadd += '<div class="dcondition">Stop Loss</div>';
                        watchtoadd += '<div class="dvalue"><span class="ontoleft">'+value.dconnumber_stop_loss_point+'</span></div>';
                        watchtoadd += '</li>';
                    }
                    watchtoadd += '</ul>';
                    watchtoadd += '</div>';
                    watchtoadd += '</li>';
                });
                $(".watcherlist > ul").append(watchtoadd);
                

            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
		});
    }
    
    $( document ).ready(function() {
        new loadwatctlist(<?php echo $user->ID; ?>);
    });


</script>