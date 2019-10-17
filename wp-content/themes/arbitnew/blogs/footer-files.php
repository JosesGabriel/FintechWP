<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script> 

        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/parts.js?<?php echo time(); ?>"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/pages.js?<?php echo time(); ?>"></script>
        <?php wp_footer(); ?>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/lazyfunc.js?<?php echo time(); ?>"></script>
    
        <script>
            $(document).ready(function(){
                $(".vynduepassnow_cancel").click(function(e){
                    e.preventDefault();
                    $("#vynduemodals").modal('hide');
                });
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
                            window.location.href = "https://vyndue.com/#/login";
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            
                        }
                    });

                });
            });
        </script>
        <?php
            global $current_user;
            $userid = get_current_user_id();
            $unametype = get_user_meta($userid, 'disname', true);
        ?>
        <style>
            
            #vynduemodals {
                top: 50px;
                margin-left: -43px;
                overflow: inherit;
            }
            #vynduemodals .modal-dialog .modal-content {
                border-radius: 5px;
                overflow: hidden;
                background: #142c46;
                width: 350px;
                margin: 0 auto;
            }
            #vynduemodals .modal-body {
                background: #142c46;
                color: #fff;
            }
            #vynduemodals .modal-body input#darbitpass {
                width: 100%;
                border: 1px solid #1d3553;
                background: #10273e;
                border-radius: 100px;
                padding: 5px 10px;
                /* margin-bottom: 9px; */
                font-size: 14px;
                color: #fff;
            }
            #vynduemodals .modal-body input#darbitpass:focus {
                outline: none;
            }
            #vynduemodals .modal-body input#subspass {
                background: none;
                border: 2px solid #e77e24;
                color: #fff;
                font-size: 12px;
                border-radius: 50px;
                padding: 5px 10px;
                display: inline-block;
                cursor: pointer;
            }
            #vynduemodals .modal-body input#subspass:hover {
                border: 2px solid #e77e24;
                background: #e77e24;
                color: #fff;
            }
            #vynduemodals .modal-body .vynduepassnow_cancel {
                background: none;
                border: 2px solid #F44336;
                color: #fff ;
                font-size: 12px;
                border-radius: 50px;
                padding: 5px 10px;
                display: inline-block;
                cursor: pointer;
            }
            #vynduemodals .modal-body .vynduepassnow_cancel:hover {
                border: 2px solid #F44336;
                background: #F44336;
                color: #fff;
            }
            .vynduepassnow--phar {
                margin-bottom: 5px;
                font-size: 13px;
                margin: 0 auto;
                line-height: 1.4;
                text-align: center;
            }
            .vynduepassnow--phar-bot {
                font-size: 11px;
                font-weight: 300;
                color: #9c9c9c;
                margin: 9px auto;
                line-height: 1.4;
                text-align: center;
            }
            .vynduepassnow--username-youornot {
                font-size: 11px;
                font-weight: 300;
                color: #c9c9c9;
                margin: 0 auto 10px;
                line-height: 1.4;
                text-align: center;
            }
            .vynduepassnow--username {
                font-size: 18px;
                font-weight: 500;
                text-align: center;
            }
            .vynduepassnow_vyndue-img {
                width: 31%;
                margin: 0 auto;
                display: block;
            }
            .vynduepassnow_user-img {
                width: 100%;
                border-radius: 100px;
            }
            .vynduepassnow_user-img-main {
                display: block;
                margin: 17px auto;
                width: 39%;
                height: 39%;
                border-radius: 100px;
                border: 3px solid rgba(101, 131, 168, 0.4196078431372549);
                padding: 4px;
                overflow: hidden;

                -webkit-box-shadow: 0px 0px 11px -2px rgba(8, 22, 38, 0.5);
                -moz-box-shadow: 0px 0px 11px -2px rgba(8, 22, 38, 0.5);
                box-shadow: 0px 0px 11px -2px rgba(8, 22, 38, 0.5);
            }
            .vynduepassnow_btns {
                margin: 18px 0 3px auto;
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
                        <img class="vynduepassnow_vyndue-img" src="/svg/vyndue-latest-v2.svg">
                        <p class="vynduepassnow--phar">To login to Vyndue, you will need your Arbitrage Username and Username.</p>
                        <div class="vynduepassnow_user-img-main">
                            <img class="vynduepassnow_user-img" src="<?php echo esc_url( get_avatar_url( $userid ) ); ?>" alt="<?php echo um_user( 'first_name' ) . " " . um_user( 'last_name' ); ?>">
                        </div>
                        <p class="vynduepassnow--username"><span class="showusername"><?php echo um_user( 'first_name' ) . " " . um_user( 'last_name' ); ?></span></p>
                        <p class="vynduepassnow--username-youornot">( This is your Username )</p>
                        
                        <hr class="style14 style15">
                        <p class="vynduepassnow--phar-bot">We have detected that you Register via Facebook, hence no password is associated with your account. Please enter your preferred Password for Vyndue on the dialogue box below.</p>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-12" style="padding: 0;">
                                <input autocomplete=“false” type="password" name="darbitpass" id="darbitpass" placeholder="Enter Password for Vyndue">
                                <input type="hidden" name="vynusername" id="vynusername">
                            </div>
                            <div class="vynduepassnow_btns">
                                <input type="submit" name="subsnepass" value="Continue to Vyndue" id="subspass">
                                <a class="vynduepassnow_cancel">Cancel</a>
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