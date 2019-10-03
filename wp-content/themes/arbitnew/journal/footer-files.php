        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
        <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script> -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script> 

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script type="text/javascript" src="https://www.amcharts.com/lib/3/pie.js"></script>
        <script type="text/javascript" src="https://www.amcharts.com/lib/3/gauge.js"></script>

        <script language="javascript">
            // Chart 1 - Current Allocation
            AmCharts.makeChart("chartdiv1",
                {
                    "type": "pie",
                    "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                    "innerRadius": "40%",
                    "pieX": "45%",
                    "pieY": "50%",
                    "radius": 50,
                    "pullOutRadius": "0%",
                    "startRadius": "0%",
                    "pullOutDuration": 0,
                    "sequencedAnimation": false,
                    "startDuration": 0,
                    "colors": [
                        <?php echo $currentaloccolor; ?>
                    ],
                    "labelColorField": "#FFFFFF",
                    "labelsEnabled": false,
                    "labelTickAlpha": 1,
                    "labelTickColor": "#FFFFFF",
                    "titleField": "category",
                    "valueField": "column-1",
                    "backgroundColor": "#000000",
                    "borderColor": "#FFFFFF",
                    "color": "#78909C",
                    "fontFamily": "Roboto",
                    "allLabels": [],
                    "balloon": {},
                    "legend": {
                        "enabled": true,
                        "align": "center",
                        "autoMargins": false,
                        "color": "#78909C",
                        "left": 0,
                        "markerSize": 14,
                        "markerType": "circle",
                        "position": "left",
                        "valueWidth": 80
                    },
                    "titles": [],
                    "dataProvider": [<?php echo $currentalocinfo; ?>]
                }
            );
            <?php
                if($isjounalempty){
                    $formonthperc = '{"category": "Jan","column-1": "80"},{"category": "Feb","column-1": "60"},{"category": "Mar","column-1": "30"},{"category": "Apr","column-1": "20"},{"category": "May","column-1": "10"},{"category": "Jun","column-1": "-5"},{"category": "Jul","column-1": "-15"},{"category": "Aug","column-1": "-20"},{"category": "Sep","column-1": "-10"},{"category": "Oct","column-1": "5"},{"category": "Nov","column-1": "10"},{"category": "Dec","column-1": "15"}';
                }
            ?>
            // Chart 2 - Monthly Performance (Bar)
            AmCharts.makeChart("chartdiv2",
                {
                    "type": "serial",
                    "categoryField": "category",
                    "sequencedAnimation": false,
                    "startDuration": 0,
                    "columnWidth": 0,
                    "minSelectedTime": 5,
                    "mouseWheelScrollEnabled": true,
                    "addClassNames": true,
                    "autoMarginOffset": 0,
                    "marginTop": 10,
                    "plotAreaBorderColor": "#FFFFFF",
                    "zoomOutText": "Reset",
                    "backgroundColor": "#0D1F33",
                    "color": "#78909C",
                    "fontFamily": "Roboto",
                    "handDrawThickness": 4,
                    "usePrefixes": true,
                    "categoryAxis": {
                        "axisAlpha": 0.09,
                        "axisColor": "#FFFFFF",
                        "boldPeriodBeginning": false,
                        "color": "#78909C",
                        "firstDayOfWeek": 6,
                        "gridAlpha": 0.09,
                        "gridThickness": 0,
                        "markPeriodChange": false,
                        "minorGridAlpha": 0,
                        "minorGridEnabled": true,
                        "titleFontSize": 0
                    },
                    "trendLines": [],
                    "graphs": [
                        {
                            "columnWidth": 1,
                            "cornerRadiusTop": 3,
                            "fillAlphas": 1,
                            "fillColors": "#00E676",
                            "fixedColumnWidth": 12,
                            "gapPeriod": 0,
                            "id": "AmGraph-2",
                            "lineColor": "undefined",
                            "lineColorField": "color",
                            "lineThickness": 0,
                            "negativeFillAlphas": 1,
                            "negativeFillColors": "#ff1744",
                            "title": "",
                            "topRadius": 0,
                            "type": "column",
                            "valueField": "column-1"
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "ValueAxis-2",
                            "autoRotateAngle": 90,
                            "axisAlpha": 0.09,
                            "axisColor": "#FFFFFF",
                            "color": "#78909C",
                            "dashLength": 3,
                            "gridAlpha": 0.09,
                            "gridColor": "#FFFFFF",
                            "labelRotation": 48.6,
                            "title": "",
                            "titleBold": false,
                            "titleColor": "#FFFFFF",
                            "titleFontSize": 0
                        }
                    ],
                    "allLabels": [],
                    "balloon": {
                        "fixedPosition": false,
                        "fontSize": 10,
                        "showBullet": true
                    },
                    "titles": [],
                    "dataProvider": [
                        <?php echo $formonthperc; ?>
                    ]
                }
            );

            // Chart 3 - Monthly Performance (Pie) - Removed requested by Ai
            <?php
                if($isjounalempty){
                    $iswin = 100;
                    $isloss = 60;
                }
            ?>
            // Chart 4a - Trade Statistics (chartdiv4a)
            // var chart = 
            <?php
                if($isjounalempty){
                    $wincharts = '{"strategy": "Bottom Picking","winvals": 15},{"strategy": "Breakout Play","winvals": 9},{"strategy": "Trend Following","winvals": 2}';
                }
            ?>
            // Chart 4b - Win Allocations (chartdiv4b)
            var chart = AmCharts.makeChart("chartdiv4b", {
            "type": "pie",
            "startDuration": 0,
            "sequencedAnimation": false,
            "theme": "none",
            "marginBottom": 0,
            "marginTop": 0,
            "marginLeft": 0,
            "marginRight": 0,
            "labelsEnabled": false,
            "addClassNames": true,
            "fontFamily": "Roboto",
            "fontSize": 11,
            "legend":{
                "enabled": false,
                "position":"bottom",
                "autoMargins":false,
                "color": "#d8d8d8",
                "align": "center",
                "valueWidth": 35
            },
            "color": "#d8d8d8",
            "innerRadius": "50%",
            "radius": 75,
            "autoMargins": false,
            "colors": [
                "#f44336",
                "#FFC107",
                "#06af68"
                // "#4CAF50",
                // "#00BCD4",
                // "#2196F3",
                // "#673AB7",
                // "#E91E63",
                // "#FF9800",
                // "#FFEB3B",
                // "#8BC34A"
            ],
            "defs": {
                "filter": [{
                "id": "shadow",
                "width": "200%",
                "height": "200%",
                "feOffset": {
                    "result": "offOut",
                    "in": "SourceAlpha",
                    "dx": 0,
                    "dy": 0
                },
                "feGaussianBlur": {
                    "result": "blurOut",
                    "in": "offOut",
                    "stdDeviation": 5
                },
                "feBlend": {
                    "in": "SourceGraphic",
                    "in2": "blurOut",
                    "mode": "normal"
                }
                }]
            },
            "dataProvider": [<?php echo $wincharts; ?>],
            "valueField": "winvals",
            "titleField": "strategy",
            "export": {
                "enabled": false
            }
            });

            chart.addListener("init", handleInit);

            chart.addListener("rollOverSlice", function(e) {
            handleRollOver(e);
            });

            function handleInit(){
            chart.legend.addListener("rollOverItem", handleRollOver);
            /*jQuery("#chartdiv2 svg").prepend('<defs><linearGradient id="myGradient" gradientTransform="rotate(90)">
            <stop offset="5%" stop-color="#00e676" /><stop offset="95%" stop-color="#000000" /></linearGradient></defs>');*/
            }

            function handleRollOver(e){
            var wedge = e.dataItem.wedge.node;
            wedge.parentNode.appendChild(wedge);
            }

            <?php
                if($isjounalempty){
                    $stratstrg = '{"category": "Bottom Picking","column-2": "4","Trades": "15","colors": "#06af68","colorsred": "#b7193f"},{"category": "Breakout Play","column-2": "1","Trades": "9","colors": "#06af68","colorsred": "#b7193f"},{"category": "Trend Following","column-2": "8","Trades": "2","colors": "#06af68","colorsred": "#b7193f"}';
                }
            ?>
            // Chart 5 - Strategy Statistics
            AmCharts.makeChart("chartdiv5",
        {
            "type": "serial",
            "categoryField": "category",
            "rotate": true,
            "marginLeft": 10,
            "marginRight": 10,
            "autoMarginOffset": 0,
            "marginBottom": 20,
            "marginTop": 85,
            "startDuration": 0,
            "sequencedAnimation": false,
            "backgroundColor": "#0D1F33",
            "color": "#78909C",
            "fontFamily": "Roboto",
            "usePrefixes": true,
            "categoryAxis": {
                "axisAlpha": 0,
                "axisColor": "#FFFFFF",
                "gridColor": "#FFFFFF",
                "gridThickness": 0,
                "title": "WINS & LOSSES",
                "titleBold": false,
                "titleColor": "#d8d8d8",
                "titleFontSize": 14
            },
            "trendLines": [],
            "graphs": [
                {
                    "alphaField": "color",
                    "balloonText": "[[title]]: [[value]]",
                    "bulletField": "color",
                    "bulletSizeField": "color",
                    "closeField": "color",
                    "colorField": "colors",
                    "columnIndexField": "color",
                    "customBulletField": "color",
                    "dashLengthField": "color",
                    "descriptionField": "color",
                    "errorField": "color",
                    "fillAlphas": 1,
                    "fillColors": "#00E676",
                    "fillColorsField": "color",
                    "fixedColumnWidth": 15,
                    "gapField": "color",
                    "highField": "color",
                    "id": "AmGraph-1",
                    "labelColorField": "color",
                    "lineAlpha": 0,
                    "lineColorField": "color",
                    "lowField": "color",
                    "openField": "color",
                    "patternField": "color",
                    "title": "Wins",
                    "type": "column",
                    "valueField": "Trades",
                    "xField": "color",
                    "yField": "color",
                    "cornerRadiusTop": 3,
                },
                {
                    "alphaField": "color",
                    "balloonText": "[[title]]: [[value]]",
                    "bulletField": "color",
                    "bulletSizeField": "color",
                    "closeField": "color",
                    "colorField": "colorsred",
                    "columnIndexField": "color",
                    "customBulletField": "color",
                    "dashLengthField": "color",
                    "descriptionField": "color",
                    "errorField": "color",
                    "fillAlphas": 1,
                    "fillColors": "#ff1744",
                    "fillColorsField": "color",
                    "fixedColumnWidth": 15,
                    "gapField": "color",
                    "highField": "color",
                    "id": "AmGraph-2",
                    "labelColorField": "color",
                    "lineColorField": "color",
                    "lineThickness": 0,
                    "lowField": "color",
                    "openField": "color",
                    "patternField": "color",
                    "title": "Losses",
                    "type": "column",
                    "valueField": "column-2",
                    "xField": "color",
                    "yField": "color",
                    "cornerRadiusTop": 3,
                }
            ],
            "guides": [],
            "valueAxes": [
                {
                    "id": "ValueAxis-1",
                    "stackType": "regular",
                    "axisAlpha": 0.19,
                    "axisColor": "#FFFFFF",
                    "dashLength": 3,
                    "gridAlpha": 0.22,
                    "gridColor": "#FFFFFF",
                    "title": ""
                }
            ],
            "allLabels": [],
            "balloon": {},
            "titles": [],
            "dataProvider": [
                <?php echo $stratstrg; ?>
            ]
        }
            );
            <?php 
                if($isjounalempty){
                    $feeschart = '
                    {"category": "Jan","column-1": "123"},
                    {"category": "Feb","column-1": "345"},
                    {"category": "Mar","column-1": "456"},
                    {"category": "Apr","column-1": "345"},
                    {"category": "May","column-1": "123"},
                    {"category": "Jun","column-1": "23"},
                    {"category": "Jul","column-1": "6"},
                    {"category": "Aug","column-1": "36"},
                    {"category": "Sep","column-1": "403"},
                    {"category": "Oct","column-1": "50"},
                    {"category": "Nov","column-1": "30"},
                    {"category": "Dec","column-1": "60"}';
                }
            ?>
            // Chart 6 - Expense Report
            AmCharts.makeChart("chartdiv6",
                {
                    "type": "serial",
                    "categoryField": "category",
                    "autoMarginOffset": 0,
                    "marginBottom": 0,
                    "marginLeft": 0,
                    "marginRight": 0,
                    "backgroundColor": "#142C46",
                    "borderColor": "#FFFFFF",
                    "color": "#78909C",
                    "usePrefixes": true,
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 0.19,
                        "axisColor": "#FFFFFF",
                        "gridAlpha": 0,
                        "gridColor": "#FFFFFF"
                    },
                    "trendLines": [],
                    "graphs": [
                        {
                            "balloonColor": "undefined",
                            "balloonText": "[[category]]: [[value]]",
                            "bullet": "round",
                            "bulletAlpha": 0,
                            "bulletBorderColor": "undefined",
                            "bulletBorderThickness": 6,
                            "bulletColor": "#ff1744",
                            "bulletSize": 0,
                            "columnWidth": 0,
                            "fillAlphas": 0.05,
                            "fillColors": "#ff1744",
                            "gapPeriod": 3,
                            "id": "AmGraph-1",
                            "legendAlpha": 0,
                            "legendColor": "undefined",
                            "lineColor": "#ff1744",
                            "lineThickness": 3,
                            "minBulletSize": 18,
                            "minDistance": 0,
                            "negativeBase": 2,
                            "negativeFillAlphas": 0,
                            "negativeLineAlpha": 0,
                            "title": "Expense Report",
                            "topRadius": 0,
                            "type": "smoothedLine",
                            "valueField": "column-1",
                            "visibleInLegend": false
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "ValueAxis-1",
                            "axisAlpha": 0.18,
                            "axisColor": "#FFFFFF",
                            "dashLength": 3,
                            "gridAlpha": 0.09,
                            "gridColor": "#FFFFFF",
                            "minorTickLength": -2,
                            "title": ""
                        }
                    ],
                    "allLabels": [],
                    "balloon": {},
                    "legend": {
                        "enabled": true,
                        "useGraphSettings": true
                    },
                    "titles": [],
                    "dataProvider": [<?php echo $feeschart; ?>]
                }
            );
            <?php
                if($isjounalempty){
                    $dailyvolumes = '
                    {"category": "0","column-1": 53},
                    {"category": "1","column-1": 22},
                    {"category": "2","column-1": 40},
                    {"category": "3","column-1": 22},
                    {"category": "4","column-1": 53},
                    {"category": "5","column-1": 54},
                    {"category": "6","column-1": 200},
                    {"category": "7","column-1": 200},
                    {"category": "8","column-1": 123},
                    {"category": "9","column-1": 234},
                    {"category": "10","column-1": 232},
                    {"category": "11","column-1": 200},
                    {"category": "12","column-1": 180},
                    {"category": "13","column-1": 190},
                    {"category": "14","column-1": 170},
                    {"category": "15","column-1": 150},
                    {"category": "16","column-1": 120},
                    {"category": "17","column-1": 110},
                    {"category": "18","column-1": 100},
                    {"category": "19","column-1": 90},
                    {"category": "20","column-1": 80}';
                }
            ?>
            // Chart 7 - Daily Buy Volume
            AmCharts.makeChart("chartdiv7",
                {
                    "type": "serial",
                    "categoryField": "category",
                    "columnWidth": 0,
                    "minSelectedTime": 5,
                    "mouseWheelScrollEnabled": true,
                    "autoMarginOffset": 0,
                    "marginTop": 10,
                    "plotAreaBorderColor": "#FFFFFF",
                    "zoomOutText": "Reset",
                    "sequencedAnimation": false,
                    "startDuration": 0,
                    "backgroundColor": "#0D1F33",
                    "color": "#78909C",
                    "fontFamily": "Roboto",
                    "handDrawThickness": 4,
                    "usePrefixes": true,
                    "categoryAxis": {
                        "axisAlpha": 0.09,
                        "axisColor": "#FFFFFF",
                        "boldPeriodBeginning": false,
                        "color": "#78909C",
                        "firstDayOfWeek": 6,
                        "gridAlpha": 0.09,
                        "gridThickness": 0,
                        "markPeriodChange": false,
                        "minorGridAlpha": 0,
                        "minorGridEnabled": true
                    },
                    "trendLines": [],
                    "graphs": [
                        {
                            "columnWidth": 1,
                            "cornerRadiusTop": 3,
                            "fillAlphas": 1,
                            "fillColors": "#00E676",
                            "fixedColumnWidth": 8,
                            "gapPeriod": 0,
                            "id": "AmGraph-2",
                            "lineColor": "undefined",
                            "lineColorField": "color",
                            "lineThickness": 0,
                            "negativeFillAlphas": 1,
                            "negativeFillColors": "#E91E63",
                            "negativeLineAlpha": 0,
                            "negativeLineColor": "undefined",
                            "tabIndex": -3,
                            "title": "graph 1",
                            "topRadius": 0,
                            "type": "column",
                            "valueField": "column-1"
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "ValueAxis-2",
                            "autoRotateAngle": 90,
                            "axisAlpha": 0.09,
                            "axisColor": "#FFFFFF",
                            "color": "#78909C",
                            "dashLength": 3,
                            "gridAlpha": 0.09,
                            "gridColor": "#FFFFFF",
                            "labelRotation": 48.6,
                            "title": "",
                            "titleBold": false,
                            "titleColor": "#FFFFFF",
                            "titleFontSize": 0
                        }
                    ],
                    "allLabels": [],
                    "titles": [],
                    "dataProvider": [<?php echo $dailyvolumes; ?>]
                }
            );
            <?php
                if($isjounalempty){
                    $dailyvalues = '
                    {"category": "0","column-1": 53},
                    {"category": "1","column-1": 22},
                    {"category": "2","column-1": 40},
                    {"category": "3","column-1": 22},
                    {"category": "4","column-1": 53},
                    {"category": "5","column-1": 54},
                    {"category": "6","column-1": 200},
                    {"category": "7","column-1": 200},
                    {"category": "8","column-1": 123},
                    {"category": "9","column-1": 234},
                    {"category": "10","column-1": 232},
                    {"category": "11","column-1": 200},
                    {"category": "12","column-1": 180},
                    {"category": "13","column-1": 190},
                    {"category": "14","column-1": 170},
                    {"category": "15","column-1": 150},
                    {"category": "16","column-1": 120},
                    {"category": "17","column-1": 110},
                    {"category": "18","column-1": 100},
                    {"category": "19","column-1": 90},
                    {"category": "20","column-1": 80}';
                }
            ?>
            // Chart 8 - Daily Buy Value
            AmCharts.makeChart("chartdiv8",
                {
                    "type": "serial",
                    "categoryField": "category",
                    "columnWidth": 0,
                    "minSelectedTime": 5,
                    "mouseWheelScrollEnabled": true,
                    "autoMarginOffset": 0,
                    "marginTop": 10,
                    "zoomOutText": "Reset",
                    "sequencedAnimation": false,
                    "startDuration": 0,
                    "backgroundColor": "#0D1F33",
                    "color": "#78909C",
                    "fontFamily": "Roboto",
                    "handDrawThickness": 4,
                    "usePrefixes": true,
                    "categoryAxis": {
                        "axisAlpha": 0.09,
                        "axisColor": "#FFFFFF",
                        "boldPeriodBeginning": false,
                        "color": "#78909C",
                        "firstDayOfWeek": 6,
                        "gridAlpha": 0.09,
                        "gridThickness": 0,
                        "markPeriodChange": false,
                        "minorGridAlpha": 0,
                        "minorGridEnabled": true
                    },
                    "trendLines": [],
                    "graphs": [
                        {
                            "columnWidth": 1,
                            "cornerRadiusTop": 3,
                            "fillAlphas": 1,
                            "fillColors": "#00E676",
                            "fixedColumnWidth": 8,
                            "gapPeriod": 0,
                            "id": "AmGraph-2",
                            "lineColor": "undefined",
                            "lineColorField": "color",
                            "lineThickness": 0,
                            "negativeFillAlphas": 1,
                            "negativeFillColors": "#E91E63",
                            "negativeLineAlpha": 0,
                            "negativeLineColor": "undefined",
                            "tabIndex": -3,
                            "title": "graph 1",
                            "topRadius": 0,
                            "type": "column",
                            "valueField": "column-1"
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "ValueAxis-2",
                            "autoRotateAngle": 90,
                            "axisAlpha": 0.09,
                            "axisColor": "#FFFFFF",
                            "color": "#78909C",
                            "dashLength": 3,
                            "gridAlpha": 0.09,
                            "gridColor": "#FFFFFF",
                            "labelRotation": 48.6,
                            "title": "",
                            "titleBold": false,
                            "titleColor": "#FFFFFF",
                            "titleFontSize": 0
                        }
                    ],
                    "allLabels": [],
                    "balloon": {
                        "fixedPosition": false,
                        "fontSize": 10,
                        "showBullet": true
                    },
                    "titles": [],
                    "dataProvider": [<?php echo $dailyvalues; ?>]
                }
            );
            <?php
                if($isjounalempty){
                    $dpercschart = '
                        {"category": "Mon","column-1": "8892.790805434","column-2": "#673ab7"},
                        {"category": "Tue","column-1": "9023","column-2": "#673ab7"},
                        {"category": "Wed","column-1": "10312.43075","column-2": "#673ab7"},
                        {"category": "Thu","column-1": "8020","column-2": "#673ab7"},
                        {"category": "Fri","column-1": "6000","column-2": "#673ab7"}
                    ';
                }
            ?>
            // Chart 9 - Performance by Day of the Week
            AmCharts.makeChart("chartdiv9",
                {
                    "type": "serial",
                    "categoryField": "category",
                    "columnWidth": 0,
                    "minSelectedTime": 5,
                    "mouseWheelScrollEnabled": true,
                    "autoMarginOffset": 0,
                    "marginTop": 10,
                    "plotAreaBorderColor": "#FFFFFF",
                    "zoomOutText": "Reset",
                    "sequencedAnimation": false,
                    "startDuration": 0,
                    "backgroundColor": "#0D1F33",
                    "color": "#78909C",
                    "fontFamily": "Roboto",
                    "handDrawThickness": 4,
                    "usePrefixes": true,
                    "categoryAxis": {
                        "axisAlpha": 0.09,
                        "axisColor": "#FFFFFF",
                        "boldPeriodBeginning": false,
                        "color": "#78909C",
                        "firstDayOfWeek": 6,
                        "gridAlpha": 0.09,
                        "gridThickness": 0,
                        "markPeriodChange": false,
                        "minorGridAlpha": 0,
                        "minorGridEnabled": true,
                        "titleFontSize": 0
                    },
                    "trendLines": [],
                    "graphs": [
                        {
                            "columnWidth": 1,
                            "cornerRadiusTop": 3,
                            "fillAlphas": 1,
                            "fillColors": "#00E676",
                            "fixedColumnWidth": 15,
                            "gapPeriod": 0,
                            "id": "AmGraph-2",
                            "lineColor": "undefined",
                            "lineColorField": "color",
                            "lineThickness": 0,
                            "negativeFillAlphas": 1,
                            "negativeFillColors": "#ff1744",
                            "negativeLineAlpha": 0,
                            "negativeLineColor": "undefined",
                            "tabIndex": -3,
                            "title": "graph 1",
                            "topRadius": 0,
                            "type": "column",
                            "valueField": "column-1"
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "ValueAxis-2",
                            "autoRotateAngle": 90,
                            "axisAlpha": 0.09,
                            "axisColor": "#FFFFFF",
                            "color": "#78909C",
                            "dashLength": 3,
                            "gridAlpha": 0.09,
                            "gridColor": "#FFFFFF",
                            "labelRotation": 48.6,
                            "title": "",
                            "titleBold": false,
                            "titleColor": "#FFFFFF",
                            "titleFontSize": 0
                        }
                    ],
                    "allLabels": [],
                    "balloon": {
                        "fixedPosition": false,
                        "fontSize": 10,
                        "showBullet": true
                    },
                    "titles": [],
                    "dataProvider": [<?php echo $dpercschart; ?>]
                }
            );
            <?php
                if($isjounalempty){
                    $gplchart = '
                        {"category": "0","column-1": "67592.53","column-2": "#673ab7"},
                        {"category": "0","column-1": "151527.98","column-2": "#673ab7"},
                        {"category": "0","column-1": "100312.43","column-2": "#673ab7"},
                        {"category": "0","column-1": "8892.79","column-2": "#673ab7"},
                        {"category": "4","column-1": "8892","column-2": "#673ab7"},
                        {"category": "5","column-1": "100312","column-2": "#673ab7"},
                        {"category": "6","column-1": "151527","column-2": "#673ab7"},
                        {"category": "7","column-1": "67592","column-2": "#673ab7"},
                        {"category": "8","column-1": "67592","column-2": "#673ab7"},
                        {"category": "9","column-1": "151527","column-2": "#673ab7"},
                        {"category": "10","column-1": "100312","column-2": "#673ab7"},
                        {"category": "11","column-1": "8892","column-2": "#673ab7"},
                        {"category": "12","column-1": "8892","column-2": "#673ab7"},
                        {"category": "13","column-1": "100312","column-2": "#673ab7"},
                        {"category": "14","column-1": "151527","column-2": "#673ab7"},
                        {"category": "15","column-1": "67592","column-2": "#673ab7"},
                        {"category": "16","column-1": "67592","column-2": "#673ab7"},
                        {"category": "17","column-1": "151527","column-2": "#673ab7"},
                        {"category": "18","column-1": "100312","column-2": "#673ab7"},
                        {"category": "19","column-1": "8892","column-2": "#673ab7"},
                        {"category": "20","column-1": "151527","column-2": "#673ab7"}
                    ';
                }
            ?>
            // Chart 10 - Gross P&L (last 30 traiding days)
            AmCharts.makeChart("chartdiv10",
                {
                    "type": "serial",
                    "categoryField": "category",
                    "columnWidth": 0,
                    "minSelectedTime": 5,
                    "mouseWheelScrollEnabled": true,
                    "autoMarginOffset": 0,
                    "marginTop": 10,
                    "plotAreaBorderColor": "#FFFFFF",
                    "zoomOutText": "Reset",
                    "sequencedAnimation": false,
                    "startDuration": 0,
                    "backgroundColor": "#0D1F33",
                    "color": "#78909C",
                    "fontFamily": "Roboto",
                    "handDrawThickness": 4,
                    "usePrefixes": true,
                    "categoryAxis": {
                        "gridPosition": "start",
                        "tickPosition": "start",
                        "axisAlpha": 0.09,
                        "axisColor": "#FFFFFF",
                        "boldPeriodBeginning": false,
                        "color": "#78909C",
                        "firstDayOfWeek": 6,
                        "gridAlpha": 0.09,
                        "gridThickness": 0,
                        "markPeriodChange": false,
                        "minorGridAlpha": 0,
                        "minorGridEnabled": true
                    },
                    "trendLines": [],
                    "graphs": [
                        {
                            "columnWidth": 1,
                            "cornerRadiusTop": 3,
                            "fillAlphas": 1,
                            "fillColors": "#00E676",
                            "fixedColumnWidth": 10,
                            "gapPeriod": 0,
                            "id": "AmGraph-2",
                            "lineColor": "undefined",
                            "lineColorField": "color",
                            "lineThickness": 0,
                            "negativeFillAlphas": 1,
                            "negativeFillColors": "#ff1744",
                            "negativeLineAlpha": 0,
                            "negativeLineColor": "undefined",
                            "tabIndex": -3,
                            "title": "graph 1",
                            "topRadius": 0,
                            "type": "column",
                            "valueField": "column-1"
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "ValueAxis-2",
                            "autoRotateAngle": 90,
                            "axisAlpha": 0.09,
                            "axisColor": "#FFFFFF",
                            "color": "#78909C",
                            "dashLength": 3,
                            "gridAlpha": 0.09,
                            "gridColor": "#FFFFFF",
                            "labelRotation": 48.6,
                            "title": "",
                            "titleBold": false,
                            "titleColor": "#FFFFFF",
                            "titleFontSize": 0
                        }
                    ],
                    "allLabels": [],
                    "balloon": {
                        "fixedPosition": false,
                        "fontSize": 10,
                        "showBullet": true
                    },
                    "titles": [],
                    "dataProvider": [<?php echo $gplchart; ?>]
                }
            );
            <?php
                if($isjounalempty){
                    $demotsonchart = '{"category": "Neutral","column-2": "4","Trades": "3"},{"category": "Greedy","column-2": "3","Trades": "2"},{"category": "Fearful","column-2": "1","Trades": "6"},';
                }
            ?>
            // Chart 11 - Emotional Statistics
            AmCharts.makeChart("chartdiv11",
                {
                    "type": "serial",
                    "categoryField": "category",
                    "rotate": true,
                    "marginTop": 5,
                    "sequencedAnimation": false,
                    "startDuration": 0,
                    "backgroundColor": "#0D1F33",
                    "color": "#78909C",
                    "usePrefixes": true,
                    "categoryAxis": {
                        "axisAlpha": 0,
                        "axisColor": "#FFFFFF",
                        "gridColor": "#FFFFFF",
                        "gridThickness": 0
                    },
                    "trendLines": [],
                    "graphs": [
                        {
                            "balloonText": "[[title]]: [[value]]",
                            "fillAlphas": 1,
                            "fillColors": "#00E676",
                            "fixedColumnWidth": 15,
                            "id": "AmGraph-1",
                            "lineAlpha": 0,
                            "title": "Wins",
                            "type": "column",
                            "valueField": "Trades",
                            "cornerRadiusTop": 3,
                        },
                        {
                            "balloonText": "[[title]]: [[value]]",
                            "fillAlphas": 1,
                            "fillColors": "#ff1744",
                            "fixedColumnWidth": 15,
                            "id": "AmGraph-2",
                            "lineThickness": 0,
                            "title": "Losses",
                            "type": "column",
                            "valueField": "column-2",
                            "cornerRadiusTop": 3,
                        }
                    ],
                    "guides": [],
                    "valueAxes": [
                        {
                            "id": "ValueAxis-1",
                            "stackType": "regular",
                            "axisAlpha": 0.19,
                            "axisColor": "#FFFFFF",
                            "dashLength": 3,
                            "gridAlpha": 0.22,
                            "gridColor": "#FFFFFF",
                            "title": ""
                        }
                    ],
                    "allLabels": [],
                    "balloon": {},
                    "titles": [],
                    "dataProvider": [<?php echo $demotsonchart; ?>]
                }
            );

            <?php
                if($isjounalempty){
                    $intowinchartbands = '
                    {"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "55%","alpha": 0.05},
                    { "color": "#0d785a", "startValue": 0, "endValue": 45, "radius": "100%", "innerRadius": "55%", "balloonText": "45%"},

                    {"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "70%","alpha": 0.05},
                    { "color": "#06af68", "startValue": 0, "endValue": 65, "radius": "100%", "innerRadius": "70%", "balloonText": "65%"},

                    {"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "85%","alpha": 0.05},
                    { "color": "#00e676", "startValue": 0, "endValue": 90, "radius": "100%", "innerRadius": "85%", "balloonText": "90%"},';

                    $intowinchartlabels = '
                    {"text": "Stock 1","x": "49%","y": "7%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",},
                    {"text": "Stock 2","x": "49%","y": "13%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",},
                    {"text": "Stock 3","x": "49%","y": "19%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",}';
                }
            ?>
            /* Top Stocks: Winners */
            var gaugeChart = AmCharts.makeChart("topstockswinners", {
            "type": "gauge",
            "theme": "none",
            "sequencedAnimation": false,
            "startDuration": 0,
            "axes": [{
                "axisAlpha": 0,
                "tickAlpha": 0,
                "labelsEnabled": false,
                "startValue": 0,
                "endValue": 100,
                "startAngle": 0,
                "endAngle": 270,
                "bands": [<?php echo $intowinchartbands; ?>]
            }],
            "allLabels": [<?php echo $intowinchartlabels; ?>],
            });

            <?php
                if($isjounalempty){
                    $intolosschartbands = '
                    {"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "55%","alpha": 0.05},
                    { "color": "#442946", "startValue": 0, "endValue": 20, "radius": "100%", "innerRadius": "55%", "balloonText": "20%"},

                    {"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "70%","alpha": 0.05},
                    { "color": "#732546", "startValue": 0, "endValue": 60, "radius": "100%", "innerRadius": "70%", "balloonText": "60%"},

                    {"color": "#ffffff","startValue": 0,"endValue": 100,"radius": "100%","innerRadius": "85%","alpha": 0.05},
                    { "color": "#b91e45", "startValue": 0, "endValue": 80, "radius": "100%", "innerRadius": "85%", "balloonText": "80%"},
                    ';

                    $intolosschartlabels = '
                    {"text": "Stock 1","x": "49%","y": "7%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",},
                    {"text": "Stock 2","x": "49%","y": "13%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",},
                    {"text": "Stock 3","x": "49%","y": "19%","size": 11,"bold": false,"color": "#d8d8d8","align": "right",}';
                }
            ?>

            /* Top Stocks: Losers */
            var gaugeChart = AmCharts.makeChart("topstocksLosers", {
            "type": "gauge",
            "theme": "none",
            "sequencedAnimation": false,
            "startDuration": 0,
            "axes": [{
                "axisAlpha": 0,
                "tickAlpha": 0,
                "labelsEnabled": false,
                "startValue": 0,
                "endValue": 100,
                "startAngle": 0,
                "endAngle": 270,
                "bands": [<?php echo $intolosschartbands; ?>]
            }],
            "allLabels": [<?php echo $intolosschartlabels; ?>],
            });

            

        </script>

        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/parts.js?<?php echo time(); ?>"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/pages.js?<?php echo time(); ?>"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/journal/journalscripts.js?<?php echo time(); ?>"></script>
        <?php wp_footer(); ?>
        <?php
            include "data-loader.php";
            include "charts-creator.php";
        ?>
    </body>
</html>

