<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/wp-content/themes/arbitnew/watchlist/watchlist-scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-nvd3/1.0.9/angular-nvd3.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.css">

<?php
    include "watchlist-loader.php";
?>
<script>
//=================MINICHART================================

    if (typeof angular !== 'undefined') {
        var app = angular.module('arbitrage_wl', ['nvd3']);

        <?php

        if ($havemeta) {
    foreach ($havemeta as $key => $value) {

            $stock = $value['stockname'];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://arbitrage.ph/wp-json/data-api/v1/charts/history?symbol=' . $value['stockname'] . '&exchange=PSE&resolution=1D&from='. date('Y-m-d', strtotime("-20 days")) .'&to=' . date('Y-m-d'));
            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $dhistofronold = curl_exec($curl);
            curl_close($curl);

            $dhistoforchart = json_decode($dhistofronold);
            $dhistoforchart = $dhistoforchart->data;

            $dhistoflist = "";
            $counter = 0;


            if (isset($dhistoforchart->o) && is_array($dhistoforchart->o)) {
                for ($i=0; $i < (count($dhistoforchart->o)); $i++) {
                    $dhistoflist .= '{"date": '.($i + 1).', "open": '.$dhistoforchart->o[$i].', "high": '.$dhistoforchart->h[$i].', "low": '.$dhistoforchart->l[$i].', "close": '.$dhistoforchart->c[$i].'},';
                    $counter++;
                }
            }


    ?>
    //var $target = $(this).parent().find('input[name="row_id"]').val();
    
        app.controller('minichartarb<?php echo strtolower($value['stockname']); ?>', function($scope) {
                $scope.options = {
                        chart: {
                            type: 'candlestickBarChart',
                            height: 70,
                            width: 195,
                            margin : {
                                top: 0,
                                right: 0,
                                bottom: 0,
                                left: 0
                            },
                            interactiveLayer: {
                                tooltip: { enabled: false }
                            },
                            x: function(d){ return d['date']; },
                            y: function(d){ return d['close']; },
                            duration: 100,
                            zoom: {
                                enabled: true,
                                scaleExtent: [1, 10],
                                useFixedDomain: false,
                                useNiceScale: false,
                                horizontalOff: false,
                                verticalOff: true,
                                unzoomEventType: 'dblclick.zoom'
                            }
                        }
                    };

                $scope.data = [{values: [<?php echo $dhistoflist; ?>]}];
                //$scope.data = [{values: [datahistory]}];
            });

        <?php
            }
        }
        ?>
    }

</script>