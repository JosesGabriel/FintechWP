<div class="arb_padding_5 b0 bidaskbar">
    <span class="bidaskbar_btn">Bid/Ask Bar: <span>Top Five</span> <i class="fa ng-scope fa-caret-down"></i></span>

    <div class="bidaskbar_opt">
        <ul>
            <li><a href="#" data-istype="topfive" class="topfive">Top Five</a></li>
            <li><a href="#" data-istype="fullbar" class="fullbar">Full Depth</a></li>
        </ul>
        <script>
            $(document).ready(function() {
                $( ".bidaskbar_opt .topfive" ).click(function() {
                $( ".bidaskbar_btn span" ).html("Top Five");
                });
                $( ".bidaskbar_opt .fullbar" ).click(function() {
                $( ".bidaskbar_btn span" ).html("Full Depth");
                });
            });
        </script>
    </div>

    <div class="arb_bar topfive">
        <div class="greybarbg">
            <div class="arb_bar_green" style="width:{{bidperc}}%">&nbsp;</div>
            <div class="arb_bar_red" style="width:{{askperc}}%">&nbsp;</div>
        </div>
        <div class="arb_clear"></div>
        <div class="dlabels">
            <div class="buyers">
                <span style="font-weight: normal;color: #c9ccce;">BUYERS</span> {{bidperc | number : 2}}%
            </div>
            <div class="sellers">
                {{askperc | number : 2}}% <span style="font-weight: normal;color: #c9ccce;">SELLERS</span>
            </div>
        </div>
        <div class="arb_clear"></div>
    </div>

    <div class="arb_bar fullbar" style="display: none">
        <div class="arb_bar_green" style="width:{{fullbidperc}}%">&nbsp;</div>
        <div class="arb_bar_red" style="width:{{fullaskperc}}%">&nbsp;</div>
        <div class="arb_clear"></div>
        <div class="dlabels">
            <div class="buyers">
                <span style="font-weight: normal;color: #c9ccce;">BUYERS</span> {{fullbidperc | number : 2}}%
            </div>
            <div class="sellers">
                {{fullaskperc | number : 2}}% <span style="font-weight: normal;color: #c9ccce;">SELLERS</span>
            </div>
        </div>
        <div class="arb_clear"></div>
    </div>
</div>