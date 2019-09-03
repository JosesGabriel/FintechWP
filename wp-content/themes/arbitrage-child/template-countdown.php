<?php /* Template Name: Launching */ ?>
<!doctype html>
<html>
<head>	
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Pragmatic Mates s.r.o. - http://pragmaticmates.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/cd/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/cd/css/demo.css">
    <?php /* Responsive 2 */ get_template_part('parts/global', 'responsivetwo'); ?>

	<title>Arbitrage.ph</title>
</head>

<body>
<div class="header">
    <center><img class="header-image" src="/cd/img/Asset 4.png"></center>
</div>
<div class="title-header">
       <center> COMING SOON</center>
</div>
<div class="countdown countdown-container container">
    
    <div class="clock row">
        <div class="clock-item clock-days countdown-time-value col-sm-6 col-md-3">
            <div class="wrap">
                <div class="inner">
                    <div id="canvas-days" class="clock-canvas"></div>

                    <div class="text">
                        <p class="val">0</p>
                        <p class="type-days type-time">DAYS</p>
                    </div><!-- /.text -->
                </div><!-- /.inner -->
            </div><!-- /.wrap -->
        </div><!-- /.clock-item -->

        <div class="clock-item clock-hours countdown-time-value col-sm-6 col-md-3">
            <div class="wrap">
                <div class="inner">
                    <div id="canvas-hours" class="clock-canvas"></div>

                    <div class="text">
                        <p class="val">0</p>
                        <p class="type-hours type-time">HOURS</p>
                    </div><!-- /.text -->
                </div><!-- /.inner -->
            </div><!-- /.wrap -->
        </div><!-- /.clock-item -->

        <div class="clock-item clock-minutes countdown-time-value col-sm-6 col-md-3">
            <div class="wrap">
                <div class="inner">
                    <div id="canvas-minutes" class="clock-canvas"></div>

                    <div class="text">
                        <p class="val">0</p>
                        <p class="type-minutes type-time">MINUTES</p>
                    </div><!-- /.text -->
                </div><!-- /.inner -->
            </div><!-- /.wrap -->
        </div><!-- /.clock-item -->

        <div class="clock-item clock-seconds countdown-time-value col-sm-6 col-md-3">
            <div class="wrap">
                <div class="inner">
                    <div id="canvas-seconds" class="clock-canvas"></div>

                    <div class="text">
                        <p class="val">0</p>
                        <p class="type-seconds type-time">SECONDS</p>
                    </div><!-- /.text -->
                </div><!-- /.inner -->
            </div><!-- /.wrap -->
        </div><!-- /.clock-item -->
    </div><!-- /.clock -->
</div><!-- /.countdown-wrapper -->


<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/cd/js/kinetic.js"></script>
<script type="text/javascript" src="jquery.final-countdown.js"></script>
<script type="text/javascript">  
    $('document').ready(function() {
        'use strict';
        
       
        const timestamp = parseInt(Date.now()/1000);

    	$('.countdown').final_countdown({
            'start': 1565338684,
            'end': 1568595600,
            'now': timestamp     
        });
    });
</script>

</body>
</html>