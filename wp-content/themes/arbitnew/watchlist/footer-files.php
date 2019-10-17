<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.3/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.9/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-nvd3/1.0.9/angular-nvd3.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nvd3/1.8.6/nv.d3.css"> -->

<!-- new charts -->

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script> 
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/pages.js?<?php echo time(); ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/parts.js?<?php echo time(); ?>"></script>
<script src="/wp-content/themes/arbitnew/watchlist/watchlist-scripts.js?<?php echo time(); ?>"></script>

<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
<?php
    include "watchlist-loader.php";
?>
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