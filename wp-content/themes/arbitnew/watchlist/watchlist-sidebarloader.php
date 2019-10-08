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
                    let ischange = 0;
                    let changetext = "";
                    $.each(svalue.chartdata.t, function(ckey, cvalue){

                        console.log(svalue.chartdata.c);

                        if(svalue.chartdata.c[ckey] > ischange){
                            ischange = svalue.chartdata.c[ckey];
                            changetext = 'up';
                        } else {
                            changetext = 'down';
                        }
                        candles.push({"category": ckey,"column-1": svalue.chartdata.c[ckey]});
                        
                    });
                    let dcolor = (changetext == "up" ? '#53b987' : '#eb4d5c');
                    AmCharts.makeChart( "chartdiv"+stock, {
                        "type":"serial",
                        "categoryField":"category",
                        "autoMarginOffset":0,
                        "marginBottom":0,
                        "marginLeft":0,
                        "marginRight":0,
                        "backgroundColor":"#142C46",
                        "borderColor":"#FFFFFF",
                        "color":'#78909C',
                        "usePrefixes":!0,
                        "categoryAxis": {
                            "gridPosition": "start", "axisAlpha": 0, "axisColor": "#FFFFFF", "gridAlpha": 0.1, "gridThickness": 0, "gridColor": "#FFFFFF", "labelsEnabled": false
                        },
                        "trendLines":[],
                        "graphs":[ {
                            "balloonColor": "undefined", "balloonText": "[[category]]: [[value]]", "bullet": "round", "bulletAlpha": 0, "bulletBorderColor": "undefined", "bulletBorderThickness": 6, "bulletColor": "#ff1744", "bulletSize": 0, "columnWidth": 0, "fillAlphas": 0.05, "fillColors": dcolor, "gapPeriod": 3, "id": "AmGraph-1", "legendAlpha": 0, "legendColor": "undefined", "lineColor": dcolor, "lineThickness": 3, "minBulletSize": 18, "minDistance": 0, "negativeBase": 2, "negativeFillAlphas": 0, "negativeLineAlpha": 0, "title": "Expense Report", "topRadius": 0, "type": "smoothedLine", "valueField": "column-1", "visibleInLegend": !1
                        }],
                        "guides":[],
                        "valueAxes":[ {
                            "gridThickness": 0,
                            "axisAlpha": 0,
                            "gridAlpha": 0.1,
                            "labelsEnabled": false
                        }],
                        "allLabels":[],
                        "balloon": {},
                        "titles":[],
                        "dataProvider": candles
                    } );
                });

                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
		});
    }

        var loadwatctlistsidebar = function(userid){
        $.ajax({
            url: "/wp-json/watchlist-api/v1/watchlists?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                 var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
                $.each(data.data, function(key, value){
                    let watchtoadd = '';
                    let stockchange = '';
                    stockchange = '<div class="stockper" style="color:'+(value.change > 0 ? '#53b987' : '#eb4d5c')+';">';

                    watchtoadd += '<div class="to-watch-data" data-dstock='+value.stockname+'>';
                    watchtoadd += '<div class="to-left-watch" style="position: relative;float: left;display: table-cell;vertical-align: middle;top: 3px;">';
                    watchtoadd += '<div class="to-stock" style="display: inline-block;position: relative;bottom: 11px;padding: 0 5px;">';
                    watchtoadd += '<a style="color: #fff;" href="/chart/'+value.stockname+'" target="_blank">';
                    watchtoadd += '<span style="height: 40px;width: 40px;line-height: 40px;font-size: 11px !important;text-align: center;display: block;border-radius: 25px;border:2px solid; border-color:'+ colors[key] +';height: 43px;width: 43px;">'+value.stockname+'</span>';
                    watchtoadd += '</a></div>';
                              
                    watchtoadd += '<div class="minichartt" style="display: inline-block !important;top: 8px;position: relative;">';
                    watchtoadd += '<div class="floatingdiv" id="chartdiv'+value.stockname+'"></div>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                  
                    watchtoadd += '<div class="dbox-cont" style="float:right;display: inline-block !important;position: relative;top: 23px;padding: 0px 7px 1px 0px;text-align: right;">';
                    watchtoadd += '<div class="stocknum" style="font-family: Lato, sans-serif;text-align: right;margin-bottom: 2px;font-size: 17px;">₱'+value.last+'</div>';
                    watchtoadd += '<div class="dbox red">';
                    watchtoadd += stockchange +(value.change).toFixed(2)+'%</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';                    
                    watchtoadd += '</div>';


                    $(".even").append(watchtoadd);
                });               

            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }
  
    
    $( document ).ready(function() {
        console.log('loader....');
        new loadwatctlistsidebar(<?php echo $user->ID; ?>);
        new loadMiniCharts(<?php echo $user->ID; ?>);
    });


</script>