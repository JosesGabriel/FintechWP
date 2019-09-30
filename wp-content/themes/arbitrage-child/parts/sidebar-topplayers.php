<?php

    function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000000) return round(($n/1000000000000000), 2).'Quad';
        elseif ($n > 1000000000000) return round(($n/1000000000000), 2).'T';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).'B';
        elseif ($n > 1000000) return round(($n/1000000), 2).'M';
        elseif ($n > 1000) return round(($n/1000), 2).'K';

        return number_format($n);
    }


?>

<div class="dtanks">

	<h5>Top Players</h5>
	<hr class="style14 style15" style="width: 100% !important;margin-bottom: 5px !important;margin-top: 10px !important;">
	<div class="ranks">
		<div id="preloader" class="trendingpreloader">
			<div id="status">&nbsp;</div>
			<div id="status_txt"></div>
		</div>
		<ul class="topsect"></ul>
		<ul class="othersect"></ul>
		<ul class="myrank"></ul>
		<!-- <h5>Ranks</h5> -->
		<a class="viewmoreplayers">View more</a>
	</div>

</div>