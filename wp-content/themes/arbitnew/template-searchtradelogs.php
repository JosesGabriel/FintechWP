<?php
                                                                                // $paginate = (isset($_GET['ptnum']) && @$_GET['ptnum'] != "" ? 1 : $_GET['ptnum']);
                                                                                // echo  $_GET['ptnum'];
                                                                                $paginate = 20;
                                                                                $count = 1;
                                                                                $dpage = 1;
                                                                                $current = (isset($_GET['pt']) ? $_GET['pt'] : 1);
                                                                                $dlisttrade = [];
                                                                                if ($author_posts->have_posts()) {
                                                                                    while ($author_posts->have_posts()) {
                                                                                        $author_posts->the_post();
                                                                                        $dlisttrade[$dpage][$count]['id'] = get_the_ID();
                                                                                        $dlisttrade[$dpage][$count]['data_stock'] = get_post_meta(get_the_ID(), 'data_stock', true);
                                                                                        $dlisttrade[$dpage][$count]['data_sellmonth'] = get_post_meta(get_the_ID(), 'data_sellmonth', true);
                                                                                        $dlisttrade[$dpage][$count]['data_sellday'] = get_post_meta(get_the_ID(), 'data_sellday', true);
                                                                                        $dlisttrade[$dpage][$count]['data_sellyear'] = get_post_meta(get_the_ID(), 'data_sellyear', true);

                                                                                        $data_dprice = get_post_meta(get_the_ID(), 'data_dprice', true);
                                                                                        $dlisttrade[$dpage][$count]['data_dprice'] = str_replace('₱', '', $data_dprice);

                                                                                        $dlisttrade[$dpage][$count]['data_sell_price'] = get_post_meta(get_the_ID(), 'data_sell_price', true);
                                                                                        $dlisttrade[$dpage][$count]['data_quantity'] = get_post_meta(get_the_ID(), 'data_quantity', true);

                                                                                        $data_trade_info = get_post_meta(get_the_ID(), 'data_trade_info', true);
                                                                                        $dlisttrade[$dpage][$count]['data_trade_info'] = json_decode($data_trade_info);
                                                                                        $dlisttrade[$dpage][$count]['data_avr_price'] = get_post_meta(get_the_ID(), 'data_avr_price', true);

                                                                                        // $dlisttrade[$dpage]
                                                                                        if ($count == $paginate) {
                                                                                            $count = 1;
                                                                                            ++$dpage;
                                                                                        } else {
                                                                                            ++$count;
                                                                                        }
                                                                                    }
                                                                                    wp_reset_postdata();
                                                                                }

                                                                                foreach ($dlisttrade[$current] as $tlkey => $tlvalue):
                                                                                    $data_sellmonth = $tlvalue['data_sellmonth'];
                                                                                    $data_sellday = $tlvalue['data_sellday'];
                                                                                    $data_sellyear = $tlvalue['data_sellyear'];
                                                                                    $data_stock = $tlvalue['data_stock'];
                                                                                    $data_dprice = $tlvalue['data_dprice'];
                                                                                    $data_sell_price = $tlvalue['data_sell_price'];
                                                                                    $data_quantity = $tlvalue['data_quantity'];
                                                                                    $data_trade_info = $tlvalue['data_trade_info'];
                                                                                    $data_avr_price = $tlvalue['data_avr_price'];

                                                                                    // get prices
                                                                                    $soldplace = $data_quantity * $data_sell_price;
                                                                                    $baseprice = $data_quantity * $data_dprice;

                                                                                    $sellfee = getjurfees($soldplace, 'sell');

                                                                                    //profit or loss
                                                                                    $dprofit = ($soldplace - $sellfee) - ($data_quantity * $data_avr_price);

                                                                                    // profperc
                                                                                    $dtlprofperc = (abs($dprofit) / ($data_quantity * $data_avr_price)) * 100;
                                                                                    $totalprofit += $dprofit;
                                                                            ?>

                                                                          
                                                                            
                                                                                <?php 
                                                                                    if(isset($_GET['id'])){
                                                                                        echo 'successs -> ' . $_GET['id'];
                                                                                    }

                                                                                ?>

                                                                                <div class="sample" id="textid"></div>                                                                              
                                                                                    
                                                                            
                                                                                    
                                                                            <?php endforeach; ?>