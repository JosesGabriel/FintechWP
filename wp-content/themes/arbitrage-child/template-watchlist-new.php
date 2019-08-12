<?php

	/*
	* Template Name: Watchlist Page New
	* Template page for Watchlist Page Platform
    */

global $current_user;
$user = wp_get_current_user();
$userID = $current_user->ID;
get_header( 'dashboard' );

date_default_timezone_set('Asia/Manila');

?>    

<?php
// adding static json list of stocks
$staticstock = '["2GO","8990P","AAA","AB","ABA","ABC","ABG","ABS","ABSP","AC","ACE","ACPA","ACPB1","ACPB2","ACR","AEV","AGI","ALCO","ALCPB","ALHI","ALI","ALL","ANI","ANS","AP","APC","APL","APO","APX","AR","ARA","AT","ATI","ATN","ATNB","AUB","BC","BCB","BCOR","BCP","BDO","BEL","BH","BHI","BKR","BLFI","BLOOM","BMM","BPI","BRN","BSC","CA","CAB","CAT","CDC","CEB","CEI","CEU","CHI","CHIB","CHP","CIC","CIP","CLC","CLI","CNPF","COAL","COL","COSCO","CPG","CPM","CPV","CPVB","CROWN","CSB","CYBR","DAVIN","DD","DDPR","DELM","DFNN","DIZ","DMC","DMCP","DMPA1","DMPA2","DMW","DNA","DNL","DTEL","DWC","EAGLE","ECP","EDC","EEI","EG","EIBA","EIBB","ELI","EMP","EURO","EVER","EW","FAF","FB","FBP","FBP2","FDC","FERRO","FEU","FFI","FGEN","FGENF","FGENG","FIN","FJP","FJPB","FLI","FMETF","FNI","FOOD","FPH","FPHP","FPHPC","FPI","FYN","FYNB","GEO","GERI","GLO","GLOPA","GLOPP","GMA7","GMAP","GPH","GREEN","GSMI","GTCAP","GTPPA","GTPPB","H2O","HDG","HI","HLCM","HOUSE","HVN","I","ICT","IDC","IMI","IMP","IND","ION","IPM","IPO","IRC","IS","ISM","JAS","JFC","JGS","JOH","KEP","KPH","KPHB","LAND","LBC","LC","LCB","LFM","LIHC","LMG","LOTO","LPZ","LR","LRP","LRW","LSC","LTG","M-O","MA","MAB","MAC","MACAY","MAH","MAHB","MARC","MAXS","MB","MBC","MBT","MED","MEG","MER","MFC","MFIN","MG","MGH","MHC","MJC","MJIC","MPI","MRC","MRP","MRSGI","MVC","MWC","MWIDE","MWP","NI","NIKL","NOW","NRCP","NXGEN","OM","OPM","OPMB","ORE","OV","PA","PAL","PAX","PBB","PBC","PCOR","PCP","PERC","PGOLD","PHA","PHC","PHEN","PHES","PHN","PIP","PIZZA","PLC","PMPC","PMT","PNB","PNC","PNX","PNX3A","PNX3B","PNXP","POPI","PORT","PPC","PPG","PRC","PRF2A","PRF2B","PRIM","PRMX","PRO","PSB","PSE","PSEI","PTC","PTT","PX","PXP","RCB","RCI","REG","RFM","RLC","RLT","ROCK","ROX","RRHI","RWM","SBS","SCC","SECB","SEVN","SFI","SFIP","SGI","SGP","SHLPH","SHNG","SLF","SLI","SM","SMC","SMC2A","SMC2B","SMC2C","SMC2D","SMC2E","SMC2F","SMC2G","SMC2H","SMC2I","SMCP1","SMPH","SOC","SPC","SPM","SRDC","SSI","SSP","STI","STN","STR","SUN","SVC","T","TBGI","TECB2","TECH","TEL","TFC","TFHI","TLII","TLJJ","TUGS","UBP","UNI","UPM","URC","V","VITA","VLL","VMC","VUL","VVT","WEB","WIN","WLCON","WPI","X","ZHI"]';

$havemeta = get_user_meta($userID, '_watchlist_instrumental', true);

if (isset($_POST) && !empty($_POST)) {

    if (isset($_POST['subtype']) && $_POST['subtype'] == 'editdata') {

        foreach ($havemeta as $key => $value) {
            if ($value['stockname'] == $_POST['stockname']) {
                unset($havemeta[$key]);
            }
        }

        array_push($havemeta, $_POST);
        update_user_meta($userID, '_watchlist_instrumental', $havemeta);

        wp_redirect( 'https://arbitrage.ph/watchlist' );
        exit;

    } else {

        if (isset($havemeta) && !empty($havemeta)){
            if (in_array($_POST['stockname'], array_column($havemeta, 'stockname'))) {
                echo "Stock Already Exist";
            } else {
                array_push($havemeta, $_POST);
                update_user_meta($userID, '_watchlist_instrumental', $havemeta);
            }

        } else {
            $newarray = [];
            array_push($newarray, $_POST);
            // add_user_meta($userID, '_watchlist_instrumental', $newarray);
            update_user_meta($userID, '_watchlist_instrumental', $newarray);
        }

        wp_redirect( 'https://arbitrage.ph/watchlist' );
        exit;
    }


}

if (isset($_GET['remove'])) {
    foreach ($havemeta as $key => $value) {
        if ($value['stockname'] == $_GET['remove']) {
            unset($havemeta[$key]);
        }
    }
    update_user_meta($userID, '_watchlist_instrumental', $havemeta);
    wp_redirect( 'https://arbitrage.ph/watchlist' );
}

//removing date compare function as it broke the page:

#function date_compare($a, $b)
#{
#    $t1 = strtotime($a['toadddate']);
#    $t2 = strtotime($b['toadddate']);
#    return $t1 - $t2;
#}

#if ($havemeta) {
#    usort($havemeta, 'date_compare');
#    array_reverse($havemeta);
#}

#function working_days_ago($days) {
#    $count = 0;
#    $day = strtotime('-2 day');
#    while ($count < $days || date('N', $day) > 5) {
#       $count++;
#       $day = strtotime('-1 day', $day);
#    }
#    return date('Y-m-d', $day);
#}

$watchinfo = get_user_meta('7', '_scrp_stocks_chart', true);

?>



    <?php get_template_part('parts/global', 'css'); ?>
    <?php get_template_part('parts/sidebar', 'calc'); ?>
    <?php get_template_part('parts/sidebar', 'varcalc'); ?>
    <?php get_template_part('parts/sidebar', 'avarageprice'); ?>    

    <div id="main-content" class="ondashboardpage">
	<div class="inner-placeholder">
		<div class="inner-main-content">
			
			<div class="left-dashboard-part" id="left-dashboard-part">
				<div class="dashboard-sidebar-left">
					<div class="dashboard-sidebar-left-inner">
						
						<?php get_template_part('parts/sidebar', 'tasks'); ?>
                    
                    	<?php get_template_part('parts/sidebar', 'profile'); ?>
                        
					</div>
				</div>
			</div>
			<div class="center-dashboard-part">
				<div class="inner-center-dashboard">
					<div class="add-post">
                        <!--start content-->

                        <!--end content-->
					</div>
				</div>
			</div>
			<div class="right-dashboard-part">
				<div class="right-dashboard-part-inner">

					<?php get_template_part('parts/sidebar', 'trendingstocks'); ?>
					
					<?php get_template_part('parts/sidebar', 'traders'); ?>
                    
                    <?php //get_template_part('parts/sidebar', 'latestnews'); ?>
                    
                    <?php get_template_part('parts/sidebar', 'watchlist'); ?>

                    <?php get_template_part('parts/sidebar', 'alert'); ?>
					
					<?php get_template_part('parts/sidebar', 'footer'); ?>

				</div>
			</div>

			<br class="clear">
		</div>
	</div>

</div>

<?php get_footer('dashboard'); ?>

<script>
    if (typeof angular !== 'undefined') {
		var app = angular.module('arbitrage_wl', ['nvd3']);
		<?php
		if ($havemeta) {
		foreach ($havemeta as $key => $value) {



			// get stcok history
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/history2?symbol='.$value['stockname'].'&firstDataRequest=true&from='.working_days_ago('20') );
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$dhistofronold = curl_exec($curl);
			curl_close($curl);

			$dhistoforchart = json_decode($dhistofronold);

			$dhistoflist = "";
			$counter = 0;
			for ($i=0; $i < (count($dhistoforchart->o)); $i++) {
				$dhistoflist .= '{"date": '.($i + 1).', "open": '.$dhistoforchart->o[$i].', "high": '.$dhistoforchart->h[$i].', "low": '.$dhistoforchart->l[$i].', "close": '.$dhistoforchart->c[$i].'},';
				$counter++;
			}

			$currentTime = (new DateTime())->modify('+1 day');
			$startTime = new DateTime('15:30');
			$endTime = (new DateTime('09:00'))->modify('+1 day');

			if ($currentTime >= $startTime && $currentTime <= $endTime) {
			  	$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, 'https://chart.pse.tools/api/intraday/?symbol='.$value['stockname'].'&firstDataRequest=true&from='.date('Y-m-d') );
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$dintrabase = curl_exec($curl);
				curl_close($curl);

				$dintraforchart = json_decode($dintrabase);

				$open = end($dintraforchart->o);
				$high = end($dintraforchart->h);
				$low = end($dintraforchart->l);

				$dhistoflist .= '{"date": '.($counter + 1).', "open": '.$open.', "high": '.$high.', "low": '.$low.', "close": 0},';
			}



			?>
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
		});
		<?php
			}
		}
        ?>
    }
    </script>