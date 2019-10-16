<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>




        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

        <script src="/wp-content/plugins/um-friends/assets/js/um-friends.js"></script>

        <script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script> 
		<script src="<?php echo get_stylesheet_directory_uri(); ?>/dashboard/dashboard-scripts.js?<?php echo time(); ?>"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/parts.js?<?php echo time(); ?>"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/pages.js?<?php echo time(); ?>"></script>
        <?php wp_footer(); ?>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/lazyfunc.js?<?php echo time(); ?>"></script>
        <?php $user_id = get_current_user_id(); ?>
        <script type="text/javascript">
			jQuery(document).ready(function(){
                //jQuery('.um-activity-post').html('Post');
                
                var loadMiniCharts = function(userid){
                    $.ajax({
                        url: "/wp-json/watchlist-api/v1/stockcharts?userid="+userid,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(data) {
                            // var app = angular.module('arbitrage_wl', ['nvd3']);
                            $(".to-watch-data").addClass("after-load");
                            
                            $.each(data.data, function(skey, svalue){
                                let candles = [];
                                let stock = svalue.stock;
                                let ischange = 0;
                                let changetext = "";
                                $.each(svalue.chartdata.t, function(ckey, cvalue){
                                    if(svalue.chartdata.c[ckey] > ischange){
                                        ischange = svalue.chartdata.c[ckey];
                                        changetext = 'up';
                                    } else if(svalue.chartdata.c[ckey] == ischange) {
                                        ischange = svalue.chartdata.c[ckey];
                                        changetext = 'equal';
                                    } else {
                                        ischange = svalue.chartdata.c[ckey];
                                        changetext = 'down';
                                    }
                                    let addslog = (parseFloat(ischange)).toFixed(2);
                                    candles.push({"category": ckey,"column-1": addslog});
                                });
                                let dcolor = (changetext == "equal" ? '#ffd900' : ( changetext == "up" ? '#53b987' : '#eb4d5c' ) );
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
                                    "chartCursor": {
                                        "enabled": true,
                                        "cursorColor": dcolor,
                                        "graphBulletSize": 2,
                                    },
                                    "trendLines":[],
                                    "graphs":[ {
                                        "balloonColor": "undefined", "balloonText": "[[value]]", "bullet": "round", "bulletAlpha": 0, "bulletBorderColor": dcolor, "bulletBorderThickness": 6, "bulletColor": dcolor, "bulletSize": 5, "columnWidth": 0, "fillAlphas": 0.05, "fillColors": dcolor, "gapPeriod": 3, "id": "AmGraph-1", "legendAlpha": 0, "legendColor": "undefined", "lineColor": dcolor, "lineThickness": 0.8, "minBulletSize": 18, "minDistance": 0, "negativeBase": 2, "negativeFillAlphas": 0, "negativeLineAlpha": 0, "title": "Expense Report", "topRadius": 0, "type": "smoothedLine", "valueField": "column-1", "visibleInLegend": !1
                                    }],
                                    "guides":[],
                                    "valueAxes":[ {
                                        "gridThickness": 0,
                                        "axisAlpha": 0,
                                        "gridAlpha": 0.1,
                                        "labelsEnabled": false
                                    }],
                                    "allLabels":[],
                                    "balloon": {
                                        "borderAlpha": 0,
                                        "borderColor": "",
                                        "borderThickness": 0,
                                        "fillAlpha": 0,
                                        "color": "#ffffff"
                                    },
                                    "titles":[],
                                    "dataProvider": candles
                                } );
                            });

                            
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            
                        }
                    });
                }
                let loadwatchlist = function(userid){
                    $.ajax({
                        url: "/wp-json/watchlist-api/v1/watchlists?userid="+userid,
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(data) {
                            var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
                            $.each(data.data, function(key, value){
                                let watchtoadd = '';
                                watchtoadd += '<div class="to-watch-data" data-dstock="'+value.stockname+'">';
                                watchtoadd += '<div class="to-left-watch">';
                                watchtoadd += '<div class="to-stock">';
                                watchtoadd += '<a style="color: #fff;" href="/chart/'+value.stockname+'" target="_blank">';
                                watchtoadd += '<span style="line-height: 40px; text-align: center; display: block; border-radius: 25px; border: 2px solid '+colors[key]+'; height: 43px; width: 43px; font-size: 11px !important;">'+value.stockname+'</span>';
                                watchtoadd += '</a>';
                                watchtoadd += '</div>';
                                watchtoadd += '<div class="chartarea">';
                                watchtoadd += '<div class="floatingdiv" id="chartdiv'+value.stockname+'"></div>';
                                watchtoadd += '</div>';
                                watchtoadd += '<div class="dbox-cont">';
                                watchtoadd += '<div class="stocknum_'+value.stockname+' watch_price">'+(value.last).toFixed(2)+'</div>';
                                watchtoadd += '<div class="dbox '+ (value.change == 0 ? 'yellow' : ( value.change > 0 ? 'green' : 'red' ) ) +'">';
                                watchtoadd += '<div class="stockperc_'+value.stockname+' watch_perc"><i class="fa '+ (value.change == 0 ? '' : ( value.change > 0 ? 'fa-caret-up' : 'fa-caret-down' ) ) +'"></i> '+(value.change).toFixed(2)+'%</div>';
                                watchtoadd += '</div>';
                                watchtoadd += '<br class="clear" />';

                                watchtoadd += '</div>';
                                watchtoadd += '</div>';
                                $(".sidewatchlist .even").append(watchtoadd);
                                if(key == 3){
                                    return false;
                                }
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            
                        }
                    });
                }

                
                new loadwatchlist(<?php echo $user_id;?>);
                new loadMiniCharts(<?php echo $user_id;?>);
			});
        </script>
        <script>
            $(document).ready(function(){
                $("li.five a").click(function(e){
                    e.preventDefault();
                    $.ajax({
                        url: "/wp-json/watchlist-api/v1/hasfb?userid=<?php echo $user_id;?>",
                        // url: "/wp-json/watchlist-api/v1/hasfb?userid=4",
                        type: 'GET',
                        dataType: 'json', // added data type
                        success: function(data) {
                            // console.log(data);
                            if(data.data == "gopop"){
                                $("#vynduemodals").modal('show');
                                $("#vynusername").val(data.username);
                                $(".showusername").text(data.username);
                            } else {
                                window.location.href = "https://vyndue.com/#/login";
                                // https://vyndue.com/#/login
                                console.log('redirect');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            
                        }
                    });
                    // $("#vynduemodals").modal('show');
                });

                $(".vynduepassnow #subspass").click(function(e){
                    e.preventDefault();

                    let passvals = $(".vynduepassnow").find("#darbitpass").val();
                    let usename = $(".vynduepassnow").find("#vynusername").val();
                    
                    $.ajax({
                        // url: "/wp-json/watchlist-api/v1/hasfb?userid=<?php echo $user_id;?>",
                        url: "/wp-json/watchlist-api/v1/fbuser",
                        type: 'GET',
                        data: { username: usename, password: passvals, userid : '<?php echo $user_id;?>' },
                        dataType: 'json', // added data type
                        success: function(data) {
                            // console.log(data);
                            $("#vynduemodals").modal('hide');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            
                        }
                    });

                });
            });
        </script>
        <style>
            
            #vynduemodals {
                top: 30%;
                margin-left: -43px;
            }
            #vynduemodals .modal-dialog .modal-content {
                border-radius: 5px;
                overflow: hidden;
                background: #142c46;
            }
            #vynduemodals .modal-body {
                background: #142c46;
                color: #fff;
            }
            #vynduemodals .modal-body input#darbitpass {
                width: 100%;
                border: 1px solid #1d3553;
                background: #10273e;
                border-radius: 3px;
                padding: 5px 10px;
                /* margin-bottom: 9px; */
                font-size: 14px;
            }
            #vynduemodals .modal-body input#subspass {
                width: 100%;
                background: none;
                border: 2px solid #e77e24;
                color: #e77e24;
                font-size: 14px;
                border-radius: 9px;
                padding: 5px;
                /* margin-top: 5px; */
            }
            #vynduemodals .modal-body p {
                margin-bottom: 5px;
                font-size: 14px;
            }
        </style>
        <div class="modal fade" id="vynduemodals" tabindex="" role="dialog" aria-labelledby="vynduemodalsLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="vynduemodalsLabel">Add password of Vyndue</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
                <div class="modal-body">
                    <div class="pops vynduepassnow">
                        <p>To login to Vyndue, you will need your Arbitrage Username.</p>
                        <p>Your username: <span class="showusername"></span></p>
                        
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-6" style="padding: 0;">
                                <input type="password" name="darbitpass" id="darbitpass" placeholder="Enter Password for Vyndue">
                                <input type="hidden" name="vynusername" id="vynusername">
                            </div>
                            <div class="col-md-6">
                                <input type="submit" name="subsnepass" value="Continue to Vyndue" id="subspass">
                            </div>
                        </div>
                        <!-- <input type="hidden" name="vynusername" id="vynusername"><br />
                        <input type="submit" name="subsnepass" value="Continue to Vyndue" id="subspass"> -->
                    </div>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>


<script>

(function ($) {
    var user_id = '<?php echo $user_id ?>'

    function add_loading_btn($btn) {
        $btn.append('&nbsp;<i class="fa fa-spinner fa-spin" style="margin: 0" aria-hidden="true"></i>')
    }

    function remove_loading_btn($btn) {
        $btn.find('i.fa').remove();
    }

    function wall_temporary_post(temporary_id, $form ) {
        var wall = $form.parents('.um').find('.um-activity-wall');

        widget_template = wp.template( 'um-activity-widget' );
        template_data = {
            'content'       : '<div class="desc-note">' + $form.find('[name="_post_content"]').val() + '</div>',
            'img_src'       : $form.find('input[name="_post_img"]').val(),
            'img_src_url'   : $form.find('input[name="_post_img_url"]').val(),
            'wall_id'       : $form.find('input[name="_wall_id"]').val(),
            'wall_user_name': $form.find('input[name="_wall_user_name"]').val(),
            'wall_user_url' : $form.find('input[name="_wall_user_url"]').val(),
            'user_id'       : user_id,
            'post_id'       : temporary_id,
            'post_url'      : '',
            'photo'         : ( $form.find('input[name="_post_img"]').val().trim().length > 0 ),
            'video'         : '',
            'video_content' : '',
            'oembed'        : '',
        };

        wall.prepend( widget_template( template_data ) );
    }

    function generateRandomString() {
        return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    }

    $(document).ready(function () {

        /**
         * Overrides the wall post submit function in
         * wp-content/plugins/um-social-activity/assets/js/um-activity.js line 407
         */
        $('.ondashboardpage').on('submit', '.um-activity-publish', function (e) {
            e.stopPropagation();
            e.preventDefault();

            var form = $(this);
            var $btn = form.find('.um-activity-post');

            //focus on textarea if empty
            if ( form.find('textarea').val().trim().length === 0 && form.find('input[name="_post_img"]').val().trim().length === 0) {
                form.find('textarea').focus();
                return false;
            }

            um_disable_post_submit( form );

            var formdata = form.serializeArray();

            if (form.find('input[name="_post_id"]') . val() === '0') {
                var temp_id = generateRandomString()
                wall_temporary_post(temp_id, form)
            }

            var $new_post = form.parents('.um').find('.um-activity-wall #postid-' + temp_id)
            $.ajax({
                // url: wp.ajax.settings.url,
                url: 'wp-admin/admin-ajax.php',
                type: 'post',
                dataType: 'json',
                data: formdata,
                success: function( data ) {

                    var widget_template;
                    var template_data;

                    if ( form.find('input[name="_post_id"]').val() === '0' ) {
                        var wall = form.parents('.um').find('.um-activity-wall');

                        widget_template = wp.template( 'um-activity-widget' );
                        template_data = {
                            'content'       : data.content,
                            'img_src'       : data.photo_gsc_url,
                            'img_src_url'   : data.photo_gsc_url,
                            'wall_id'       : data.wall_id,
                            'wall_user_name': data.wall_user_name,
                            'wall_user_url' : data.wall_user_url,
                            'user_id'       : data.user_id,
                            'post_id'       : data.postid,
                            'post_url'      : data.permalink,
                            'photo'         : ( form.find('input[name="_post_img"]').val().trim().length > 0 ),
                            'video'         : data.video || data.has_text_video,
                            'video_content' : data.video,
                            'oembed'        : data.has_oembed
                        };

                        // wall.prepend( widget_template( template_data ) );
                        $new_post.replaceWith( widget_template( template_data ) );
                        wall.find( '.unready' ).removeClass( 'unready um-activity-new-clone' ).fadeIn();

                        form.find('textarea').val('').height('auto');
                        um_clean_photo_fields( form );
                        um_post_placeholder( form.find( 'textarea' ) );

                        UM_wall_autocomplete_start();
                    } else {
                        form.parents('.um-activity-widget').removeClass( 'editing' );

                        widget_template = wp.template( 'um-activity-post' );
                        template_data = {
                            'content'       : data.content,
                            'img_src'       : data.photo_gsc_url,
                            'img_src_url'   : data.photo_gsc_url,
                            'wall_id'       : formdata._wall_id,
                            'wall_user_name': data.wall_user_name,
                            'wall_user_url' : data.wall_user_url,
                            'user_id'       : data.user_id,
                            'post_id'       : data.postid,
                            'post_url'      : data.permalink,
                            'photo'         : ( form.find('input[name="_post_img"]').val().trim().length > 0 ),
                            'video'         : data.video || data.has_text_video,
                            'video_content' : data.video,
                            'oembed'        : data.has_oembed
                        };

                        form.parents('.um-activity-body').html( widget_template( template_data ) );
                    }
                }
            });
        })
    });
    $('.opennotification').on('click', '.um-notification', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var $this = $(this);
        if (typeof $this.data('notification_uri') !== 'undefined') {
            window.location.href = $this.data('notification_uri')
        }
    });
    $('.um-activity-textarea').on('click', function (e) {
        $('.promter_tostocks').remove();
        $('.um-activity-textarea').append('<span class="promter_tostocks">Use <strong>$</strong> before stock code to <strong>tag stocks</strong></span>');
        var qoute = $('.promter_tostocks');
        setInterval(function(){
            $(qoute).fadeOut(3000);
        }, 4000);
    });
    $('.um-activity-textarea').on('keyup', function (e) {
        $('.promter_tostocks').fadeOut();
        $('.promter_tostocks').remove();
    });
    $('.um-activity-textarea').on('mouseleave', function (e) {
        $('.promter_tostocks').fadeOut(2000).remove();
    });
    $('.popname ul li').on('click', function (e) {
        $('.promter_tostocks').fadeOut();
        $('.promter_tostocks').remove();
    });

})(jQuery)
</script>