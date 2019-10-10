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
                            console.log(data);
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
                                    } else {
                                        ischange = svalue.chartdata.c[ckey];
                                        changetext = 'down';
                                    }
                                    let addslog = (parseFloat(ischange)).toFixed(2);
                                    candles.push({"category": ckey,"column-1": addslog});
                                    
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
                                    "chartCursor": {
                                        "enabled": true,
                                        "cursorColor": dcolor,
                                        "graphBulletSize": 2,
                                    },
                                    "trendLines":[],
                                    "graphs":[ {
                                        "balloonColor": "undefined", "balloonText": "[[value]]", "bullet": "round", "bulletAlpha": 0, "bulletBorderColor": "undefined", "bulletBorderThickness": 6, "bulletColor": "#ff1744", "bulletSize": 0, "columnWidth": 0, "fillAlphas": 0.05, "fillColors": dcolor, "gapPeriod": 3, "id": "AmGraph-1", "legendAlpha": 0, "legendColor": "undefined", "lineColor": dcolor, "lineThickness": 0.8, "minBulletSize": 18, "minDistance": 0, "negativeBase": 2, "negativeFillAlphas": 0, "negativeLineAlpha": 0, "title": "Expense Report", "topRadius": 0, "type": "smoothedLine", "valueField": "column-1", "visibleInLegend": !1
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
                                watchtoadd += '<div class="dbox '+(value.change > 0 ? 'green' : 'red')+'">';
                                watchtoadd += '<div class="stockperc_'+value.stockname+' watch_perc"><i class="fa '+(value.change > 0 ? 'fa-caret-up' : 'fa-caret-down')+'"></i> '+(value.change).toFixed(2)+'%</div>';
                                watchtoadd += '</div>';
                                watchtoadd += '<br class="clear" />';

                                watchtoadd += '</div>';
                                watchtoadd += '</div>';
                                $(".sidewatchlist .even").append(watchtoadd);
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
            console.log("post submitted");
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
                        console.log("ed success");
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

})(jQuery)
</script>
