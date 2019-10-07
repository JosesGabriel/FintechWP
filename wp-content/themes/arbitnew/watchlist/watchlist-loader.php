<script>
    var loadMiniCharts = function(userid){
		$.ajax({
			url: "/wp-json/watchlist-api/v1/stockcharts?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                console.log(data);
                // var app = angular.module('arbitrage_wl', ['nvd3']);
                $(".watchonlist").addClass("after-load");
                
                $.each(data.data, function(skey, svalue){
                    let candles = [];
                    let stock = svalue.stock;
                    $.each(svalue.chartdata.t, function(ckey, cvalue){
                        candles.push({"category": ckey,"column-1": svalue.chartdata.c[ckey]});
                    });
                    AmCharts.makeChart( "chartdiv"+stock, {
                        "type":"serial",
                        "categoryField":"category",
                        "autoMarginOffset":0,
                        "marginBottom":0,
                        "marginLeft":0,
                        "marginRight":0,
                        "backgroundColor":"#142C46",
                        "borderColor":"#FFFFFF",
                        "color":"#78909C",
                        "usePrefixes":!0,
                        "categoryAxis": {
                            "gridPosition": "start", "axisAlpha": 0, "axisColor": "#FFFFFF", "gridAlpha": 0.1, "gridThickness": 0, "gridColor": "#FFFFFF", "labelsEnabled": false
                        },
                        "trendLines":[],
                        "graphs":[ {
                            "balloonColor": "undefined", "balloonText": "[[category]]: [[value]]", "bullet": "round", "bulletAlpha": 0, "bulletBorderColor": "undefined", "bulletBorderThickness": 6, "bulletColor": "#ff1744", "bulletSize": 0, "columnWidth": 0, "fillAlphas": 0.05, "fillColors": "#ff1744", "gapPeriod": 3, "id": "AmGraph-1", "legendAlpha": 0, "legendColor": "undefined", "lineColor": "#ff1744", "lineThickness": 3, "minBulletSize": 18, "minDistance": 0, "negativeBase": 2, "negativeFillAlphas": 0, "negativeLineAlpha": 0, "title": "Expense Report", "topRadius": 0, "type": "smoothedLine", "valueField": "column-1", "visibleInLegend": !1
                        }

                        ],
                        "guides":[],
                        "valueAxes":[ {
                            "gridThickness": 0,
                            "axisAlpha": 0,
                            "gridAlpha": 0.1,
                            "labelsEnabled": false
                        }],
                        "allLabels":[],
                        "balloon": {}

                        ,
                        // "legend": {
                        //     "enabled": !0, "useGraphSettings": !0
                        // },
                        "titles":[],
                        "dataProvider": candles
                    } );
                });

                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
		});
    }
	var loadwatctlist = function(userid){
		$.ajax({
			url: "/wp-json/watchlist-api/v1/watchlists?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                console.log(data);
                $.each(data.data, function(key, value){
                    let watchtoadd = '';
                    let stockchange = '';
                    stockchange = '<div class="curchange_'+value.stockname+'" style="color:'+(value.change > 0 ? '#53b987' : '#eb4d5c')+';">';


                    watchtoadd += '<li class="watchonlist" data-dstock="'+value.stockname+'" data-dhisto="null">';
                    watchtoadd += '<div class="row">';
                    watchtoadd += '<div class="wlttlstockvals">';
                    watchtoadd += '<div class="stocknn">'+value.stockname+'</div>';
                    watchtoadd += '<div class="s_dropdown" style="display: inline-block;">';
                    watchtoadd += '<select class="editwatchlist" name="editstock" id="" data-space="'+value.stockname+'"><option value="select" hidden=""></option><option value="delete">Delete</option>';
                    watchtoadd += '<option value="edit" data-stock="'+value.stockname+'" data-entry="'+value.dconnumber_entry_price+'" data-tp="'+value.dconnumber_take_profit_point+'" data-sl="'+value.dconnumber_stop_loss_point+'">Edit</option></select>';
                    watchtoadd += '</div>';
                    watchtoadd += '<div class="dpricechange">';
                    watchtoadd += ' <div class="curprice_'+value.stockname+'">₱'+value.last+'</div>';
                    watchtoadd += stockchange + (value.change).toFixed(2)+'%</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '<div class="col-md-12" style="padding: 0;">';
                    watchtoadd += '<div class="chartarea">';
                    watchtoadd += '<div class="floatingdiv" id="chartdiv'+value.stockname+'"></div>';
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
                    $(".watcherlist > ul").append(watchtoadd);
                });
                
                
                
                

            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
		});
    }

   
    
    $( document ).ready(function() {
        jQuery('.watcherlist > ul').on('change', 'select.editwatchlist', function(e) {
            console.log($(this).val() );
            if($(this).val() == 'delete'){
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                            'Deleted!',
                            'Your Watchlist has been deleted.',
                            'success'
                        ).then((result) => {
                            var ditemtoremove = jQuery(this).attr('data-space');
                            window.location.href = "/watchlist/?remove="+ditemtoremove;
                        });
                    }
                });

                $("div.editwatchlist select").val("Select");
            }else if($(this).val() == 'edit'){
                // var ditemtoedit = jQuery(this).attr('data-space');
                // jQuery("#edit_" + ditemtoedit).click();

                let entry = $(this).find(':selected').data('entry');
                let tp = $(this).find(':selected').data('tp');
                let sl = $(this).find(':selected').data('sl');
                let stock = $(this).find(':selected').data('stock');
                
                $(".modal-title").text(stock);
                $("#editstockmodal input[name='dconnumber_entry_price']").val(entry);
                $("#editstockmodal input[name='dconnumber_take_profit_point']").val(tp);
                $("#editstockmodal input[name='dconnumber_stop_loss_point']").val(sl);
                $("#editstockmodal input[name='stockname']").val(stock);
                $("#editstockmodal").modal('toggle');
                
            }
        });


        
        new loadwatctlist(<?php echo $user->ID; ?>);
        new loadMiniCharts(<?php echo $user->ID; ?>);
    });


</script>