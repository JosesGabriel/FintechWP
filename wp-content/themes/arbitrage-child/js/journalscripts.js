
var getCurrentAllocation = function(userid){
    $.ajax({
        url: "/wp-json/journal-api/v1/tradestats?userid="+userid,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(data) {
            // console.log(data);
            $(".dclwin").text(data.data.win);
            $(".dclloss").text(data.data.loss);
            $(".dcltotals").text(data.data.totaltrades);
            $(".dclwinrate").text((data.data.totalperc).toFixed(2)+"%");

            AmCharts.makeChart("chartdiv4a", {
                "type": "pie","startDuration": 0,"sequencedAnimation": false,"theme": "none","marginBottom": 0,"marginTop": 0,"marginLeft": 0,"marginRight": 0,"labelsEnabled": false,"addClassNames": true,"fontFamily": "Roboto","fontSize": 11,"color": "#d8d8d8","innerRadius": "50%","colors": ["#00E676","#ff1744"],
                "defs": {
                  "filter": [{"id": "shadow","width": "200%","height": "200%","feOffset": {"result": "offOut","in": "SourceAlpha","dx": 0,"dy": 0},"feGaussianBlur": {"result": "blurOut","in": "offOut","stdDeviation": 5},"feBlend": {"in": "SourceGraphic","in2": "blurOut","mode": "normal"}}]
                },
                "dataProvider": [{"stats": "Win","vals": data.data.win}, {"stats": "Losses","vals": data.data.loss}],
                "valueField": "vals","titleField": "stats",
                "export": {"enabled": false}
              });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
}


var getMonthlyPerformance = function(userid){
    $.ajax({
        url: "/wp-json/journal-api/v1/monthperformance?userid="+userid,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(data) {
            let chartbuilder = [];
            $.each(data.data, function(i, value){
                chartbuilder.push({"category": i, "column-1" : value});
            });
            AmCharts.makeChart("chartdiv2",
            {
                "type": "serial","categoryField": "category","sequencedAnimation": false,"startDuration": 0,"columnWidth": 0,"minSelectedTime": 5,"mouseWheelScrollEnabled": true,"addClassNames": true,"autoMarginOffset": 0,"marginTop": 10,"plotAreaBorderColor": "#FFFFFF","zoomOutText": "Reset","backgroundColor": "#0D1F33","color": "#78909C","fontFamily": "Roboto","handDrawThickness": 4,"usePrefixes": true,
                "categoryAxis": {"axisAlpha": 0.09,"axisColor": "#FFFFFF","boldPeriodBeginning": false,"color": "#78909C","firstDayOfWeek": 6, "gridAlpha": 0.09,"gridThickness": 0,"markPeriodChange": false,"minorGridAlpha": 0,"minorGridEnabled": true,"titleFontSize": 0},
                "trendLines": [],
                "graphs": [{"columnWidth": 1,"cornerRadiusTop": 3,"fillAlphas": 1,"fillColors": "#00E676","fixedColumnWidth": 12,"gapPeriod": 0,"id": "AmGraph-2","lineColor": "undefined", "lineColorField": "color","lineThickness": 0,"negativeFillAlphas": 1,"negativeFillColors": "#ff1744","title": "","topRadius": 0,"type": "column","valueField": "column-1"}],
                "guides": [],
                "valueAxes": [{"id": "ValueAxis-2","autoRotateAngle": 90,"axisAlpha": 0.09,"axisColor": "#FFFFFF","color": "#78909C","dashLength": 3,"gridAlpha": 0.09,"gridColor": "#FFFFFF","labelRotation": 48.6,"title": "","titleBold": false,"titleColor": "#FFFFFF","titleFontSize": 0}],
                "allLabels": [],
                "balloon": {"fixedPosition": false,"fontSize": 10,"showBullet": true},
                "titles": [],
                "dataProvider": chartbuilder
            }
        );
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(ajaxOptions);
            console.log(thrownError);
        }
    });
}
