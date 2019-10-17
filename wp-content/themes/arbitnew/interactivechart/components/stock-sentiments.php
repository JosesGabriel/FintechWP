<?php /*?> Bullish & Beasish <?php */
    $link = $_SERVER['REQUEST_URI'];
    $link_array = explode('/',$link);
    $dxlink = array_filter($link_array);
    $page = end($dxlink);

    $dsentilist = get_post_meta( 504, '_sentiment_'.$page.'_list', true );
?>

<div class="regsentiment">
    <div class=" arb_padding_5 b0 arb_bullbear  {{dshowsentiment}}" style="<?php echo ($page != "chart" ? 'display:block;' : 'display:none;'); ?>height: 80px;overflow: hidden;">
        <div class="bullbearsents" data-bull="{{fullbidtotal}}" data-bear="{{fullasktotal}}">
            <span class="bullbearsents_label">Register your sentiments</span>
            <a href="#" class="bbs_bull"><img src="/svg/ico_bullish_no_ring.svg"></a>
            <div class="dbaronchart" style="width: <?php echo ($percbid > 0 ? '70' : ''); ?>%;">
                <div class="bbs_bull_bar" style="width: <?php echo $percbid; ?>%;">
                    <div class="bbs_bull_bar_inner"></div>
                    <span style="<?php echo ($percbid > 0 ? 'display:block;' : ''); ?>%;"><?php echo number_format($percbid,2); ?>%</span>
                </div>
                <div class="bbs_bear_bar" style="width: <?php echo $percask; ?>%;">
                    <div class="bbs_bear_bar_inner"></div>
                    <span style="<?php echo ($percask > 0 ? 'display:block;' : ''); ?>%;"><?php echo number_format($percask,2); ?>%</span>
                </div>
            </div>
            <a href="#" class="bbs_bear"><img src="/svg/ico_bearish_no_ring.svg"></a>
        </div>
        <div class="arb_clear"></div>
    </div>
</div>