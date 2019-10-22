
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
    var getTradeStats = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/tradestatistics?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                AmCharts.makeChart("chartdiv4a",{
                    "type":"pie","startDuration":0,"sequencedAnimation":!1,"theme":"none","marginBottom":0,"marginTop":0,"marginLeft":0,"marginRight":0,"labelsEnabled":!1,"addClassNames":!0,"fontFamily":"Roboto","fontSize":11,"color":"#d8d8d8","innerRadius":"50%","colors":["#00E676","#ff1744"],"defs":{"filter":[{"id":"shadow","width":"200%","height":"200%","feOffset":{"result":"offOut","in":"SourceAlpha","dx":0,"dy":0},"feGaussianBlur":{"result":"blurOut","in":"offOut","stdDeviation":5},"feBlend":{"in":"SourceGraphic","in2":"blurOut","mode":"normal"}}]},"valueField":"vals","titleField":"stats","export":{"enabled":!1},
                    "dataProvider":[{"stats":"Win","vals":data.data.win},{"stats":"Losses","vals":data.data.loss}],
                });
                $(".iswins").text(data.data.win);
                $(".islosses").text(data.data.loss);
                $(".istotaltrades").text(data.data.totaltrades);
                $(".iswinrate").text((parseFloat(data.data.winperc).toFixed(2))+"%");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var getMonthlyPerformance = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/monthlyperformance?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                let ismonths = [];
                $.each(data.data, function(key, value){
                    ismonths.push({"category" : key, "column-1" : (value).toString()});
                });
                AmCharts.makeChart("chartdiv2",
                {
                    "type":"serial","categoryField":"category","sequencedAnimation":!1,"startDuration":0,"columnWidth":0,"minSelectedTime":5,"mouseWheelScrollEnabled":!0,"addClassNames":!0,"autoMarginOffset":0,"marginTop":10,"plotAreaBorderColor":"#FFFFFF","zoomOutText":"Reset","backgroundColor":"#0D1F33","color":"#78909C","fontFamily":"Roboto","handDrawThickness":4,"usePrefixes":!0,"categoryAxis":{"axisAlpha":0.09,"axisColor":"#FFFFFF","boldPeriodBeginning":!1,"color":"#78909C","firstDayOfWeek":6,"gridAlpha":0.09,"gridThickness":0,"markPeriodChange":!1,"minorGridAlpha":0,"minorGridEnabled":!0,"titleFontSize":0},"trendLines":[],"graphs":[{"columnWidth":1,"cornerRadiusTop":3,"fillAlphas":1,"fillColors":"#00E676","fixedColumnWidth":12,"gapPeriod":0,"id":"AmGraph-2","lineColor":"undefined","lineColorField":"color","lineThickness":0,"negativeFillAlphas":1,"negativeFillColors":"#ff1744","title":"","topRadius":0,"type":"column","valueField":"column-1"}],"guides":[],"valueAxes":[{"id":"ValueAxis-2","autoRotateAngle":90,"axisAlpha":0.09,"axisColor":"#FFFFFF","color":"#78909C","dashLength":3,"gridAlpha":0.09,"gridColor":"#FFFFFF","labelRotation":48.6,"title":"","titleBold":!1,"titleColor":"#FFFFFF","titleFontSize":0}],"allLabels":[],"balloon":{"fixedPosition":!1,"fontSize":10,"showBullet":!0},"titles":[],
                    "dataProvider": ismonths
                }
            );

            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var getstrats = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/strategystatistics?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                let strattable = [];
                let stratspie = [];
                let listofbase = '';
                $.each(data.data, function(key, value){
                    listofbase += '<li>';
                    listofbase += '<div style="width:99%">';
                    listofbase += '<div style="width:150px;">'+key+'</div>';
                    listofbase += '<div style="text-align: center;">'+value.total_trades+'</div>';
                    listofbase += '<div style="text-align: center;">'+value.trwin+'</div>';
                    listofbase += '<div style="text-align: center;">'+value.trloss+'</div>';
                    listofbase += '<div style="text-align: center;">'+(value.trwin > 0 ? ((value.trwin/value.total_trades) * 100).toFixed(2) : '0.00')+'%</div>';
                    listofbase += '</div>';
                    listofbase += '</li>';
                    strattable.push({"category": key,"column-2": (value.trloss).toString(),"Trades": (value.trwin).toString(),"colors": "#06af68","colorsred": "#b7193f"});
                    stratspie.push({"strategy": key,"winvals": (value.trwin).toString()});
                });
                $(".stratstables ul").append(listofbase);
                AmCharts.makeChart("chartdiv5",{
                    "type":"serial","categoryField":"category","rotate":!0,"autoMargins": false,"marginLeft":70,"marginTop":0,"marginBottom":99,"marginLeft":10,"marginRight":10,"startDuration":0,"sequencedAnimation":!1,"backgroundColor":"#0D1F33","color":"#78909C","fontFamily":"Roboto","usePrefixes":!0,"categoryAxis":{"axisAlpha":0,"axisColor":"#FFFFFF","gridColor":"#FFFFFF","gridThickness":0,"title":"WINS & LOSSES","titleBold":!1,"titleColor":"#d8d8d8","titleFontSize":14},"trendLines":[],"graphs":[{"alphaField":"color","balloonText":"[[title]]: [[value]]","bulletField":"color","bulletSizeField":"color","closeField":"color","colorField":"colors","columnIndexField":"color","customBulletField":"color","dashLengthField":"color","descriptionField":"color","errorField":"color","fillAlphas":1,"fillColors":"#00E676","fillColorsField":"color","fixedColumnWidth":15,"gapField":"color","highField":"color","id":"AmGraph-1","labelColorField":"color","lineAlpha":0,"lineColorField":"color","lowField":"color","openField":"color","patternField":"color","title":"Wins","type":"column","valueField":"Trades","xField":"color","yField":"color","cornerRadiusTop":3,},{"alphaField":"color","balloonText":"[[title]]: [[value]]","bulletField":"color","bulletSizeField":"color","closeField":"color","colorField":"colorsred","columnIndexField":"color","customBulletField":"color","dashLengthField":"color","descriptionField":"color","errorField":"color","fillAlphas":1,"fillColors":"#ff1744","fillColorsField":"color","fixedColumnWidth":15,"gapField":"color","highField":"color","id":"AmGraph-2","labelColorField":"color","lineColorField":"color","lineThickness":0,"lowField":"color","openField":"color","patternField":"color","title":"Losses","type":"column","valueField":"column-2","xField":"color","yField":"color","cornerRadiusTop":3,}],"guides":[],"valueAxes":[{"id":"ValueAxis-1","stackType":"regular","axisAlpha":0.19,"axisColor":"#FFFFFF","dashLength":3,"gridAlpha":0.22,"gridColor":"#FFFFFF","title":""}],"allLabels":[],"balloon":{},"titles":[],
                    "dataProvider": strattable
                });
                AmCharts.makeChart("chartdiv4b", {
                    "type":"pie","startDuration":0,"sequencedAnimation":!1,"theme":"none","marginBottom":0,"marginTop":0,"marginLeft":0,"marginRight":0,"labelsEnabled":!1,"addClassNames":!0,"fontFamily":"Roboto","fontSize":11,"legend":{"enabled":!1,"position":"bottom","autoMargins":!1,"color":"#d8d8d8","align":"center","valueWidth":35},"color":"#d8d8d8","innerRadius":"50%","radius":75,"autoMargins":!1,"colors":["#E91E63","#FF9800","#FFEB3B","#06af68"],"defs":{"filter":[{"id":"shadow","width":"200%","height":"200%","feOffset":{"result":"offOut","in":"SourceAlpha","dx":0,"dy":0},"feGaussianBlur":{"result":"blurOut","in":"offOut","stdDeviation":5},"feBlend":{"in":"SourceGraphic","in2":"blurOut","mode":"normal"}}]},"valueField":"winvals","titleField":"strategy","export":{"enabled":!1},
                    "dataProvider": stratspie
                });
                $(".stratwinning").text(data.wins);
                $(".stratlossing").text(data.loss);

            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var getTopStocks = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/topstocks?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                let buttomparts = [];
                let vsortingbottom = data.data.buttom.reverse();
                $.each(vsortingbottom, function(key, value){
                    let dprofit = (value.profit).toFixed(2);
                    let dinss = '<li class="sbuttom'+key+'" style="color: #b1e8ce;border: none;">';
                    dinss += '<div class="width60">'+value.isstock+'</div>';
                    dinss += '<div class="width35">&#8369; '+dprofit+'</div>';
                    dinss += '</li>';
                    $(".listoftopstocks .bottomstocks").append(dinss);

                    buttomparts.push({ "category": value.isstock, "column-1": dprofit });
                });

                let topparts = [];
                let vsortingtop = data.data.top.reverse();
                $.each(vsortingtop, function(key, value){
                    let dprofit = (value.profit).toFixed(2);
                    let dinss = '<li class="stop'+key+'" style="color: #b1e8ce;border: none;">';
                    dinss += '<div class="width60">'+value.isstock+'</div>';
                    dinss += '<div class="width35">&#8369; '+dprofit+'</div>';
                    dinss += '</li>';
                    $(".listoftopstocks .topstocks").prepend(dinss);
                    topparts.push({ "category": value.isstock, "column-1": dprofit });
                });

                AmCharts.makeChart("topstocksLosers", {
                    "type":"serial","categoryField":"category","columnSpacing":0,"columnWidth":0.17,"rotate":!0,"autoMargins": false,"marginRight":70,"marginTop":0,"marginBottom":89,"startDuration":1,"color":"#ffffff","fontFamily":"Roboto","fontSize":12,"handDrawScatter":0,"handDrawThickness":0,"prefixesOfBigNumbers":[{"number":1000,"prefix":"k"},{"number":1000000,"prefix":"M"},{"number":1000000000,"prefix":"B"},{"number":1000000000000,"prefix":"T"},{"number":1000000000000000,"prefix":"P"},{"number":1000000000000000000,"prefix":"E"},{"number":1e+21,"prefix":"Z"},{"number":1e+24,"prefix":"Y"}],"categoryAxis":{"autoRotateCount":0,"gridPosition":"start","axisThickness":0,"gridThickness":0,"position":"top","minorGridAlpha":0,"titleBold":!1,"titleFontSize":0},"trendLines":[],"graphs":[{"balloonColor":"#ff1744","columnWidth":0,"cornerRadiusTop":3,"fillAlphas":1,"fillColors":"#ff1744","fixedColumnWidth":20,"fontSize":0,"gapPeriod":10,"id":"AmGraph-1","lineAlpha":0,"lineColor":"undefined","lineThickness":0,"minDistance":0,"showHandOnHover":!0,"stackable":!1,"tabIndex":0,"topRadius":0,"type":"column","valueField":"column-1","visibleInLegend":!1}],"guides":[],"valueAxes":[{"axisTitleOffset":0,"baseValue":524,"id":"ValueAxis-1","position":"bottom","autoRotateAngle":0,"autoRotateCount":0,"axisThickness":0,"color":"#000000","fontSize":0,"gridCount":0,"gridThickness":0,"labelsEnabled":!1,"offset":172}],"allLabels":[],"balloon":{},"titles":[],
                    "dataProvider": buttomparts
                });
                
                AmCharts.makeChart("topstockswinners", {
                    "type":"serial","categoryField":"category","columnSpacing":0,"columnWidth":0.17,"rotate":!0,"autoMargins": false,"marginLeft":70,"marginTop":0,"marginBottom":89,"startDuration":1,"color":"#ffffff","fontFamily":"Roboto","fontSize":12,"handDrawScatter":0,"handDrawThickness":0,"prefixesOfBigNumbers":[{"number":1000,"prefix":"k"},{"number":1000000,"prefix":"M"},{"number":1000000000,"prefix":"B"},{"number":1000000000000,"prefix":"T"},{"number":1000000000000000,"prefix":"P"},{"number":1000000000000000000,"prefix":"E"},{"number":1e+21,"prefix":"Z"},{"number":1e+24,"prefix":"Y"}],"categoryAxis":{"autoRotateCount":0,"gridPosition":"start","axisThickness":0,"gridThickness":0,"minorGridAlpha":0,"titleBold":!1,"titleFontSize":0},"trendLines":[],"graphs":[{"balloonColor":"#00E676","columnWidth":0,"cornerRadiusTop":3,"fillAlphas":1,"fillColors":"#00E676","fixedColumnWidth":20,"fontSize":0,"gapPeriod":10,"id":"AmGraph-1","lineAlpha":0,"lineColor":"undefined","lineThickness":0,"minDistance":0,"showHandOnHover":!0,"stackable":!1,"tabIndex":0,"topRadius":0,"type":"column","valueField":"column-1","visibleInLegend":!1}],"guides":[],"valueAxes":[{"axisTitleOffset":0,"baseValue":524,"id":"ValueAxis-1","position":"bottom","autoRotateAngle":0,"autoRotateCount":0,"axisThickness":0,"color":"#000000","fontSize":0,"gridCount":0,"gridThickness":0,"labelsEnabled":!1,"offset":172}],"allLabels":[],"balloon":{},"titles":[],
                    "dataProvider": topparts
                });
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var getEmotionStatistics = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/emotionalreport?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                let demotions = [];
                let emotionlist = '';
                $.each(data.data, function(key, value){
                    emotionlist += '<li>';
                    emotionlist += '<div style="text-align: center;">'+key+'</div>';
                    emotionlist += '<div style="text-align: center;width: 19.4% !important;">'+value.total_trades+'</div>';
                    emotionlist += '<div style="text-align: center;width: 19.4% !important;">'+value.trwin+'</div>';
                    emotionlist += '<div style="text-align: center;width: 19.4% !important;">'+value.trloss+'</div>';
                    emotionlist += '<div style="text-align: center;width: 20% !important;">'+(value.trwin > 0 ? ((value.trwin / value.total_trades) * 100).toFixed(2) : '0.00')+'%</div>';
                    emotionlist += '</li>';
                    demotions.push({"category": key,"column-2": (value.trloss).toString(),"Trades": (value.trwin).toString()});
                });
                $(".emotioonmlistbase ul").append(emotionlist);

                AmCharts.makeChart("chartdiv11",{
                    "type":"serial","categoryField":"category","rotate":!0,"marginTop":5,"sequencedAnimation":!1,"startDuration":0,"backgroundColor":"#0D1F33","color":"#78909C","usePrefixes":!0,"categoryAxis":{"axisAlpha":0,"axisColor":"#FFFFFF","gridColor":"#FFFFFF","gridThickness":0},"trendLines":[],"graphs":[{"balloonText":"[[title]]: [[value]]","fillAlphas":1,"fillColors":"#00E676","fixedColumnWidth":15,"id":"AmGraph-1","lineAlpha":0,"title":"Wins","type":"column","valueField":"Trades","cornerRadiusTop":3,},{"balloonText":"[[title]]: [[value]]","fillAlphas":1,"fillColors":"#ff1744","fixedColumnWidth":15,"id":"AmGraph-2","lineThickness":0,"title":"Losses","type":"column","valueField":"column-2","cornerRadiusTop":3,}],"guides":[],"valueAxes":[{"id":"ValueAxis-1","stackType":"regular","axisAlpha":0.19,"axisColor":"#FFFFFF","dashLength":3,"gridAlpha":0.22,"gridColor":"#FFFFFF","title":""}],"allLabels":[],"balloon":{},"titles":[],
                    "dataProvider": demotions
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var getExpenseReport = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/expensereport?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                let spermonths = [];
                $(".dxcommission").text("₱"+(data.data.bycoms.commissions).toFixed(2));
                $(".dxvat").text("₱"+(data.data.bycoms.vat).toFixed(2));
                $(".dxtransfer").text("₱"+(data.data.bycoms.transferfee).toFixed(2));
                $(".dxsccp").text("₱"+(data.data.bycoms.sccp).toFixed(2));
                $(".dxsalestax").text("₱"+(data.data.bycoms.salestax).toFixed(2));
                $.each(data.data.months, function(key, value){
                    spermonths.push({"category": key,"column-1": (value).toString()});
                });
                AmCharts.makeChart("chartdiv6",{
                    "type":"serial","categoryField":"category","autoMarginOffset":0,"marginBottom":0,"marginLeft":0,"marginRight":0,"backgroundColor":"#142C46","borderColor":"#FFFFFF","color":"#78909C","usePrefixes":!0,"categoryAxis":{"gridPosition":"start","axisAlpha":0.19,"axisColor":"#FFFFFF","gridAlpha":0,"gridColor":"#FFFFFF"},"trendLines":[],"graphs":[{"balloonColor":"undefined","balloonText":"[[category]]: [[value]]","bullet":"round","bulletAlpha":0,"bulletBorderColor":"undefined","bulletBorderThickness":6,"bulletColor":"#ff1744","bulletSize":0,"columnWidth":0,"fillAlphas":0.05,"fillColors":"#ff1744","gapPeriod":3,"id":"AmGraph-1","legendAlpha":0,"legendColor":"undefined","lineColor":"#ff1744","lineThickness":3,"minBulletSize":18,"minDistance":0,"negativeBase":2,"negativeFillAlphas":0,"negativeLineAlpha":0,"title":"Expense Report","topRadius":0,"type":"smoothedLine","valueField":"column-1","visibleInLegend":!1}],"guides":[],"valueAxes":[{"id":"ValueAxis-1","axisAlpha":0.18,"axisColor":"#FFFFFF","dashLength":3,"gridAlpha":0.09,"gridColor":"#FFFFFF","minorTickLength":-2,"title":""}],"allLabels":[],"balloon":{},"legend":{"enabled":!0,"useGraphSettings":!0},"titles":[],
                    "dataProvider": spermonths
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var getVolumeValue = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/buystatus?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                let volumes = [];
                let values = [];
                $.each(data.data.volume, function(key, value){
                    volumes.push({"category": key,"column-1": value.toFixed(2)});
                });
                $.each(data.data.value, function(key, value){
                    values.push({"category": key,"column-1": value.toFixed(2)});
                });
                AmCharts.makeChart("chartdiv7",{
                    "type":"serial","categoryField":"category","columnWidth":0,"minSelectedTime":5,"mouseWheelScrollEnabled":!0,"autoMarginOffset":0,"marginTop":10,"plotAreaBorderColor":"#FFFFFF","zoomOutText":"Reset","sequencedAnimation":!1,"startDuration":0,"backgroundColor":"#0D1F33","color":"#78909C","fontFamily":"Roboto","handDrawThickness":4,"usePrefixes":!0,"categoryAxis":{"axisAlpha":0.09,"axisColor":"#FFFFFF","boldPeriodBeginning":!1,"color":"#78909C","firstDayOfWeek":6,"gridAlpha":0.09,"gridThickness":0,"markPeriodChange":!1,"minorGridAlpha":0,"minorGridEnabled":!0},"trendLines":[],"graphs":[{"columnWidth":1,"cornerRadiusTop":3,"fillAlphas":1,"fillColors":"#00E676","fixedColumnWidth":8,"gapPeriod":0,"id":"AmGraph-2","lineColor":"undefined","lineColorField":"color","lineThickness":0,"negativeFillAlphas":1,"negativeFillColors":"#E91E63","negativeLineAlpha":0,"negativeLineColor":"undefined","tabIndex":-3,"title":"graph 1","topRadius":0,"type":"column","valueField":"column-1"}],"guides":[],"valueAxes":[{"id":"ValueAxis-2","autoRotateAngle":90,"axisAlpha":0.09,"axisColor":"#FFFFFF","color":"#78909C","dashLength":3,"gridAlpha":0.09,"gridColor":"#FFFFFF","labelRotation":48.6,"title":"","titleBold":!1,"titleColor":"#FFFFFF","titleFontSize":0}],"allLabels":[],"titles":[],
                    "dataProvider": volumes
                });
                AmCharts.makeChart("chartdiv8",{
                    "type":"serial","categoryField":"category","columnWidth":0,"minSelectedTime":5,"mouseWheelScrollEnabled":!0,"autoMarginOffset":0,"marginTop":10,"zoomOutText":"Reset","sequencedAnimation":!1,"startDuration":0,"backgroundColor":"#0D1F33","color":"#78909C","fontFamily":"Roboto","handDrawThickness":4,"usePrefixes":!0,"categoryAxis":{"axisAlpha":0.09,"axisColor":"#FFFFFF","boldPeriodBeginning":!1,"color":"#78909C","firstDayOfWeek":6,"gridAlpha":0.09,"gridThickness":0,"markPeriodChange":!1,"minorGridAlpha":0,"minorGridEnabled":!0},"trendLines":[],"graphs":[{"columnWidth":1,"cornerRadiusTop":3,"fillAlphas":1,"fillColors":"#00E676","fixedColumnWidth":8,"gapPeriod":0,"id":"AmGraph-2","lineColor":"undefined","lineColorField":"color","lineThickness":0,"negativeFillAlphas":1,"negativeFillColors":"#E91E63","negativeLineAlpha":0,"negativeLineColor":"undefined","tabIndex":-3,"title":"graph 1","topRadius":0,"type":"column","valueField":"column-1"}],"guides":[],"valueAxes":[{"id":"ValueAxis-2","autoRotateAngle":90,"axisAlpha":0.09,"axisColor":"#FFFFFF","color":"#78909C","dashLength":3,"gridAlpha":0.09,"gridColor":"#FFFFFF","labelRotation":48.6,"title":"","titleBold":!1,"titleColor":"#FFFFFF","titleFontSize":0}],"allLabels":[],"balloon":{"fixedPosition":!1,"fontSize":10,"showBullet":!0},"titles":[],
                    "dataProvider": values
                });

            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var getPerformance = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/weekperformance?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                let weekperf = [];
                $.each(data.data, function(key, value){
                    weekperf.push({"category":key,"column-1": (value).toString(),"column-2": "#673ab7"});
                });
                AmCharts.makeChart("chartdiv9",{
                    "type":"serial","categoryField":"category","columnWidth":0,"minSelectedTime":5,"mouseWheelScrollEnabled":!0,"autoMarginOffset":0,"marginTop":10,"plotAreaBorderColor":"#FFFFFF","zoomOutText":"Reset","sequencedAnimation":!1,"startDuration":0,"backgroundColor":"#0D1F33","color":"#78909C","fontFamily":"Roboto","handDrawThickness":4,"usePrefixes":!0,"categoryAxis":{"axisAlpha":0.09,"axisColor":"#FFFFFF","boldPeriodBeginning":!1,"color":"#78909C","firstDayOfWeek":6,"gridAlpha":0.09,"gridThickness":0,"markPeriodChange":!1,"minorGridAlpha":0,"minorGridEnabled":!0,"titleFontSize":0},"trendLines":[],"graphs":[{"columnWidth":1,"cornerRadiusTop":3,"fillAlphas":1,"fillColors":"#00E676","fixedColumnWidth":15,"gapPeriod":0,"id":"AmGraph-2","lineColor":"undefined","lineColorField":"color","lineThickness":0,"negativeFillAlphas":1,"negativeFillColors":"#ff1744","negativeLineAlpha":0,"negativeLineColor":"undefined","tabIndex":-3,"title":"graph 1","topRadius":0,"type":"column","valueField":"column-1"}],"guides":[],"valueAxes":[{"id":"ValueAxis-2","autoRotateAngle":90,"axisAlpha":0.09,"axisColor":"#FFFFFF","color":"#78909C","dashLength":3,"gridAlpha":0.09,"gridColor":"#FFFFFF","labelRotation":48.6,"title":"","titleBold":!1,"titleColor":"#FFFFFF","titleFontSize":0}],"allLabels":[],"balloon":{"fixedPosition":!1,"fontSize":10,"showBullet":!0},"titles":[],
                    "dataProvider": weekperf
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    var getGrossLoss = function(userid){
        $.ajax({
            url: "/wp-json/journal-api/v1/grosproffloss?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                let weekperf = [];
                $.each(data.data, function(key, value){
                    weekperf.push({"category":key,"column-1": (value).toString(),"column-2": "#673ab7"});
                }); 

                AmCharts.makeChart("chartdiv10",{
                    "type":"serial","categoryField":"category","columnWidth":0,"minSelectedTime":5,"mouseWheelScrollEnabled":!0,"autoMarginOffset":0,"marginTop":10,"plotAreaBorderColor":"#FFFFFF","zoomOutText":"Reset","sequencedAnimation":!1,"startDuration":0,"backgroundColor":"#0D1F33","color":"#78909C","fontFamily":"Roboto","handDrawThickness":4,"usePrefixes":!0,"categoryAxis":{"gridPosition":"start","tickPosition":"start","axisAlpha":0.09,"axisColor":"#FFFFFF","boldPeriodBeginning":!1,"color":"#78909C","firstDayOfWeek":6,"gridAlpha":0.09,"gridThickness":0,"markPeriodChange":!1,"minorGridAlpha":0,"minorGridEnabled":!0},"trendLines":[],"graphs":[{"columnWidth":1,"cornerRadiusTop":3,"fillAlphas":1,"fillColors":"#00E676","fixedColumnWidth":10,"gapPeriod":0,"id":"AmGraph-2","lineColor":"undefined","lineColorField":"color","lineThickness":0,"negativeFillAlphas":1,"negativeFillColors":"#ff1744","negativeLineAlpha":0,"negativeLineColor":"undefined","tabIndex":-3,"title":"graph 1","topRadius":0,"type":"column","valueField":"column-1"}],"guides":[],"valueAxes":[{"id":"ValueAxis-2","autoRotateAngle":90,"axisAlpha":0.09,"axisColor":"#FFFFFF","color":"#78909C","dashLength":3,"gridAlpha":0.09,"gridColor":"#FFFFFF","labelRotation":48.6,"title":"","titleBold":!1,"titleColor":"#FFFFFF","titleFontSize":0}],"allLabels":[],"balloon":{"fixedPosition":!1,"fontSize":10,"showBullet":!0},"titles":[],
                    "dataProvider": weekperf
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
        });
    }

    $.fn.isOnScreen = function(){
        var win = $(window);
        var viewport = {
            top : win.scrollTop(),
            left : win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();
        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();
        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
    };


    $( document ).ready(function() {
        $(window).scroll(function(){
            
            if($('#stratstatspge').isOnScreen() && $("#stratstatspge").hasClass('dviewd') == false) {
                $("#stratstatspge").addClass('dviewd');
                new getstrats(<?php echo $user->ID; ?>);
                new getTopStocks(<?php echo $user->ID; ?>);
            }

            if($('#emotionalstats').isOnScreen() && $("#emotionalstats").hasClass('dviewd') == false) {
                $("#emotionalstats").addClass('dviewd');
                new getEmotionStatistics(<?php echo $user->ID; ?>);
            }

            if($('#expensereports').isOnScreen() && $("#expensereports").hasClass('dviewd') == false) {
                $("#expensereports").addClass('dviewd');
                new getExpenseReport(<?php echo $user->ID; ?>);
            }

            if($('#buyvolval').isOnScreen() && $("#buyvolval").hasClass('dviewd') == false) {
                $("#buyvolval").addClass('dviewd');
                new getVolumeValue(<?php echo $user->ID; ?>);
            }

            if($('#perogross').isOnScreen() && $("#perogross").hasClass('dviewd') == false) {
                $("#perogross").addClass('dviewd');
                new getPerformance(<?php echo $user->ID; ?>);
                new getGrossLoss(<?php echo $user->ID; ?>);
            }

        });
        new getCurrentAllocation(<?php echo $user->ID; ?>);
        new getTradeStats(<?php echo $user->ID; ?>);
        new getMonthlyPerformance(<?php echo $user->ID; ?>);
        
    });
</script>