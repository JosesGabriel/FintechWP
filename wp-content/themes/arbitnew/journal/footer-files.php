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

