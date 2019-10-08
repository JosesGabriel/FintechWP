        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script type="text/javascript" src="https://www.amcharts.com/lib/3/pie.js"></script>
        <script type="text/javascript" src="https://www.amcharts.com/lib/3/gauge.js"></script>

        <script language="javascript">

            /* Top Stocks: Winners */
            var gaugeChart = AmCharts.makeChart("topstockswinners", {
            // "type": "gauge",
            // "theme": "none",
            // "sequencedAnimation": false,
            // "startDuration": 0,
            // "axes": [{
            //     "axisAlpha": 0,
            //     "tickAlpha": 0,
            //     "labelsEnabled": false,
            //     "startValue": 0,
            //     "endValue": 100,
            //     "startAngle": 0,
            //     "endAngle": 270,    
            //     "bands": [<?php echo $intowinchartbands;?>]
            // }],
            // "allLabels": [<?php echo $intowinchartlabels;?>]

                "type": "serial",
                "categoryField": "category",
                "columnSpacing": 0,
                "columnWidth": 0.17,
                "rotate": true,
                "autoMargins": false,
                "marginLeft": 70,
                "marginTop": 20,
                "marginBottom": 79,
                "startDuration": 1,
                "color": "#ffffff",
                "fontFamily": "Roboto",
                "fontSize": 12,
                "handDrawScatter": 0,
                "handDrawThickness": 0,
                "prefixesOfBigNumbers": [
                    {
                        "number": 1000,
                        "prefix": "k"
                    },
                    {
                        "number": 1000000,
                        "prefix": "M"
                    },
                    {
                        "number": 1000000000,
                        "prefix": "B"
                    },
                    {
                        "number": 1000000000000,
                        "prefix": "T"
                    },
                    {
                        "number": 1000000000000000,
                        "prefix": "P"
                    },
                    {
                        "number": 1000000000000000000,
                        "prefix": "E"
                    },
                    {
                        "number": 1e+21,
                        "prefix": "Z"
                    },
                    {
                        "number": 1e+24,
                        "prefix": "Y"
                    }
                ],
                "categoryAxis": {
                    "autoRotateCount": 0,
                    "gridPosition": "start",
                    "axisThickness": 0,
                    "gridThickness": 0,
                    "minorGridAlpha": 0,
                    "titleBold": false,
                    "titleFontSize": 0
                },
                "trendLines": [],
                "graphs": [
                    {
                        "balloonColor": "#00E676",
                        "columnWidth": 0,
                        "cornerRadiusTop": 3,
                        "fillAlphas": 1,
                        "fillColors": "#00E676",
                        "fixedColumnWidth": 20,
                        "fontSize": 0,
                        "gapPeriod": 10,
                        "id": "AmGraph-1",
                        "lineAlpha": 0,
                        "lineColor": "undefined",
                        "lineThickness": 0,
                        "minDistance": 0,
                        "showHandOnHover": true,
                        "stackable": false,
                        "tabIndex": 0,
                        "topRadius": 0,
                        "type": "column",
                        "valueField": "column-1",
                        "visibleInLegend": false
                    }
                ],
                "guides": [],
                "valueAxes": [
                    {
                        "axisTitleOffset": 0,
                        "baseValue": 524,
                        "id": "ValueAxis-1",
                        "position": "bottom",
                        "autoRotateAngle": 0,
                        "autoRotateCount": 0,
                        "axisThickness": 0,
                        "color": "#000000",
                        "fontSize": 0,
                        "gridCount": 0,
                        "gridThickness": 0,
                        "labelsEnabled": false,
                        "offset": 172
                    }
                ],
                "allLabels": [],
                "balloon": {},
                "titles": [],
                "dataProvider": [
                    {
                        "category": "HLCM",
                        "column-1": 1000000
                    },
                    {
                        "category": "DMCI",
                        "column-1": 999999
                    },
                    {
                        "category": "NOW",
                        "column-1": 999998
                    },
                    {
                        "category": "2GO",
                        "column-1": 999997
                    }
                ]

            });

            /* Top Stocks: Losers */
            var gaugeChart = AmCharts.makeChart("topstocksLosers", {
            // "type": "gauge",
            // "theme": "none",
            // "sequencedAnimation": false,
            // "startDuration": 0,
            // "axes": [{
            //     "axisAlpha": 0,
            //     "tickAlpha": 0,
            //     "labelsEnabled": false,
            //     "startValue": 0,
            //     "endValue": 100,
            //     "startAngle": 0,
            //     "endAngle": 270,
            //     "bands": [<?php echo $intolosschartbands; ?>]
            // }],
            // "allLabels": [<?php echo $intolosschartlabels; ?>],

            "type": "serial",
                "categoryField": "category",
                "columnSpacing": 0,
                "columnWidth": 0.17,
                "rotate": true,
                "autoMargins": false,
                "marginRight": 70,
                "marginTop": 20,
                "marginBottom": 79,
                "startDuration": 1,
                "color": "#ffffff",
                "fontFamily": "Roboto",
                "fontSize": 12,
                "handDrawScatter": 0,
                "handDrawThickness": 0,
                "prefixesOfBigNumbers": [
                    {
                        "number": 1000,
                        "prefix": "k"
                    },
                    {
                        "number": 1000000,
                        "prefix": "M"
                    },
                    {
                        "number": 1000000000,
                        "prefix": "B"
                    },
                    {
                        "number": 1000000000000,
                        "prefix": "T"
                    },
                    {
                        "number": 1000000000000000,
                        "prefix": "P"
                    },
                    {
                        "number": 1000000000000000000,
                        "prefix": "E"
                    },
                    {
                        "number": 1e+21,
                        "prefix": "Z"
                    },
                    {
                        "number": 1e+24,
                        "prefix": "Y"
                    }
                ],
                "categoryAxis": {
                    "autoRotateCount": 0,
                    "gridPosition": "start",
                    "axisThickness": 0,
                    "gridThickness": 0,
                    "position": "top",
                    "minorGridAlpha": 0,
                    "titleBold": false,
                    "titleFontSize": 0
                },
                "trendLines": [],
                "graphs": [
                    {
                        "balloonColor": "#ff1744",
                        "columnWidth": 0,
                        "cornerRadiusTop": 3,
                        "fillAlphas": 1,
                        "fillColors": "#ff1744",
                        "fixedColumnWidth": 20,
                        "fontSize": 0,
                        "gapPeriod": 10,
                        "id": "AmGraph-1",
                        "lineAlpha": 0,
                        "lineColor": "undefined",
                        "lineThickness": 0,
                        "minDistance": 0,
                        "showHandOnHover": true,
                        "stackable": false,
                        "tabIndex": 0,
                        "topRadius": 0,
                        "type": "column",
                        "valueField": "column-1",
                        "visibleInLegend": false
                    }
                ],
                "guides": [],
                "valueAxes": [
                    {
                        "axisTitleOffset": 0,
                        "baseValue": 524,
                        "id": "ValueAxis-1",
                        "position": "bottom",
                        "reversed": true,
                        "autoRotateAngle": 0,
                        "autoRotateCount": 0,
                        "axisThickness": 0,
                        "color": "#000000",
                        "fontSize": 0,
                        "gridCount": 0,
                        "gridThickness": 0,
                        "labelsEnabled": false,
                        "offset": 172
                    }
                ],
                "allLabels": [],
                "balloon": {},
                "titles": [],
                "dataProvider": [
                    {
                        "category": "HLCM",
                        "column-1": 1000000
                    },
                    {
                        "category": "DMCI",
                        "column-1": 999999
                    },
                    {
                        "category": "NOW",
                        "column-1": 999998
                    },
                    {
                        "category": "2GO",
                        "column-1": 999997
                    }
                ]
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

