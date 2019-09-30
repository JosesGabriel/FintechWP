<?php
	/*
	* Template Name: Enter Trade
	* Template page for Journal - Enter Trade
	*/

// 
get_header('dashboard');

global $current_user;
$user = wp_get_current_user();

if ( is_user_logged_in() ) {
	// user is now logged in
} else {
	wp_redirect( '/login/', 301 );
	exit;
}

$curuserid = $current_user->ID;

?>
<style>
body, html {
	margin:0;
	padding:0;
	background: #1b1b1b;
}
body, html, p, a, span {
	color: #ecf0f1;
	font-family: 'Roboto', sans-serif;
	font-size:13px;
	font-weight:300;
}
.hideformodal {display:none;}

/* Enter Trade Form */
.groupinput label {
    display: inline-block;
    width: 46px;
    font-weight: 300;
    font-size: 13px;
    height: 27px;
    line-height: 27px;
    padding: 0 0 0 7px;
    background-color: #34495e;
    border: none;
    color: #ecf0f1;
    border-radius: 3px 0 0 3px;
    margin-bottom: 0;
}
.groupinput input[type="text"] {
    display: inline-block;
    border-radius: 0 3px 3px 0;
    width: 172px;
    font-weight: 300;
    font-size: 13px;
    height: 27px;
    line-height: 27px;
    padding: 0 0 0 7px;
    background-color: #4e6a85;
    border: 1px solid #4e6a85;
    color: #ecf0f1;
    font-family: 'Roboto', sans-serif;
    font-size: 13px;
    font-weight: 300;
}
.groupinput select {
    display: inline-block;
    border-radius: 0 3px 3px 0;
    width: 140px;
    font-weight: 300;
    font-size: 13px;
    height: 27px;
    line-height: 27px;
    padding: 0 0 0 3px;
    background-color: #4e6a85;
    margin: 0 0 0 -4px;
    border: 1px solid #4e6a85;
    color: #ecf0f1;
    font-family: 'Roboto', sans-serif;
    font-size: 13px;
    font-weight: 300;
}
.confirmtrd,
input[type="submit"].confirmtrd {
    background-color: #3597d3;
    border: 0;
    line-height: 34px;
    height: 34px;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 12px;
    padding: 0 12px;
    border-radius: 3px;
    color: #fff;
    cursor: pointer;
	font-family: 'Roboto', sans-serif;
	display:inline-block;
}
.confirmtrd:hover,
input[type="submit"].confirmtrd:hover {
    background-color: #1870a6;
	color: #fff;
	text-decoration:none;
}
.confirmtrd.green {
    background-color: #27ae60 !important;
}
.confirmtrd.green:hover {
    background-color: #167b41 !important;
}
.confirmtrd.red {
    background-color: #e64c3c !important;
}
.confirmtrd.red:hover {
    background-color: #bb3527 !important;
}
.groupinput {
    margin-bottom: 10px;
}
textarea.darktheme {
	background-color: #4e6a85;
    border: 1px solid #4e6a85;
    height: 115px;
    max-width: 448px;
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    font-family: 'Roboto', sans-serif;
    font-size: 13px;
    font-weight: 300;
    color: #ecf0f1;
	margin-top: 10px;
}
.entr_col {
	width:33%;
	float:left;
}
.entr_clear {clear:both;}
.selltrade,
.entertrade {
    width: 720px;
    margin: auto;
}
.groupinput.midd label {
	width:80px;
}
.groupinput.midd select {
	width:157px;
}
.groupinput.midd input {
	width:138px;
}
.entr_wrapper_top {
	padding:20px 0 15px 20px;
	background-color:#0c1f33;
}
.entr_wrapper_mid {
    padding: 20px 0 15px 20px;
    background-color: #142b46;
    border-radius: 4px;
}
.entr_wrapper_bot {
	padding:25px 0 25px 25px;
	background-color:#2c3e50;
}
.rnd {border-radius:3px !important;}
.selectonly select {
	width:219px;
	margin:0;
}
.entr_ttle_bar {
    background-color: #142b46;
    padding: 12px;
	border-radius: 4px;
}
.entr_ttle_bar img {
    width: 22px;
    vertical-align: middle;
    margin: 0 7px 0 0;
}
.entr_ttle_bar strong {
    font-size: 14px;
    text-transform: uppercase;
    display: inline-block;
	font-weight:700 !important;
    vertical-align: middle;
}
.entr_successmsg {
    border-radius: 3px;
    background-color: #27ae60;
    color: #fff;
    padding: 4px 7px;
    width: 100%;
    margin: 0 auto;
    margin-bottom: 10px;
}
span.selldot {
    display: inline-block;
    background-color: #e84c3c;
    width: 10px;
    height: 10px;
    border-radius: 10px;
    vertical-align: middle;
    margin: -1px 0 0px 5px;
}
span.buydot {
    display: inline-block;
    background-color: #27ae60;
    width: 10px;
    height: 10px;
    border-radius: 10px;
    vertical-align: middle;
    margin: -1px 0 0px 5px;
}
span.datestamp_header {
	color: #a1adb5;
	display: inline-block;
	vertical-align: middle;
	margin: 0 0 0px 10px;
}
.fctnlhdn {
	visibility:hidden; 
	opacity:0;
	position:absolute;
	z-index:-1;
}

/* Popup Overrides */
div#fancybox-content {
	border-color: #2c3e50 !important;
    background: #2c3e50 !important;
}
#fancybox-outer {
	background: #2c3e50 !important;
	box-shadow: none !important;
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    border-radius: 6px;
    overflow: hidden;
}
#fancybox-close {top: 18px;right: 18px;}
.lockedd {position:relative;}
.lockedd i.fa.fa-lock {
    top: 7px;
    position: absolute;
    right: 21px;
    font-size: 14px;
}

/* Table CSS */
.tradelogtable {
	width:100%; 
	margin-bottom:15px;
}
.tradelogtable td {
    padding: 2px;
}
textarea.darktheme::-webkit-input-placeholder { /* Chrome/Opera/Safari */
	color: #ecf0f1;
}
textarea.darktheme::-moz-placeholder { /* Firefox 19+ */
	color: #ecf0f1;
}
textarea.darktheme:-ms-input-placeholder { /* IE 10+ */
	color: #ecf0f1;
}
textarea.darktheme:-moz-placeholder { /* Firefox 18- */
	color: #ecf0f1;
}
.tradelogscont {
	background-color:#34495e;
	max-width:1125px;
	width:100%;
	margin:0 auto;
}
.tradelogscont .innerr {
	padding:25px 0;
}
a.smlbtn {
    background-color: #e64c3c;
    color: #fff;
    padding: 2px 8px;
    display: inline-block;
    font-size: 12px;
    border-radius: 4px;
    font-weight: bold;
	text-decoration:none;
}
a.smlbtn.blue {
    background-color: #3597d3;
}
a.smlbtn.green {
    background-color: #27ae60;
}
a.smlbtn:hover {
	background-color: #bb3527;
}
a.smlbtn.blue:hover {
    background-color: #1870a6;
}
a.smlbtn.green:hover {
    background-color: #167b41;
}
.sysoutput {background-color: #313131;}
.sysoutput span {
    display: inline-block;
    margin: 0 -4px 0 0px;
    color: #9a9a9a;
    background-color: #313131;
    padding: 2px 8px;
}
.tradelogtable strong {
    font-weight: 700 !important;
}
.tradingnotescont {
	width:300px;
	min-height:250px;
}
</style>
</head>

<body>    
<div class="hideformodal">  

    <div class="entertrade" id="entertrade">
    
        <div class="entr_ttle_bar">
            <strong>Enter Buy Order</strong> <span class="datestamp_header"><?php date_default_timezone_set('Asia/Manila'); echo date("F j, Y g:i a"); ?></span>
        </div>
        
        <form action="/enter-trade" method="post">
        
        <div class="entr_wrapper_top">
        
                <div class="entr_col">
                    <div class="groupinput fctnlhdn">
                        <label>Date</label>
                        <select name="inpt_data_buymonth" style="width:90px;">
                            <option value="<?php echo date("F"); ?>" selected><?php echo date("F"); ?></option>
                            <option value="">- - -</option>
                            <option value="January">January</option>
                            <option value="Febuary">Febuary</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                        <input type="text" name="inpt_data_buyday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("j"); ?>">
                        <input type="text" name="inpt_data_buyyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("Y"); ?>">
                        </div>
                    
                    <div class="groupinput midd"><label>Stock</label><input type="text" name="inpt_data_stock" style="text-align: left;"></div>
                    <div class="groupinput midd"><label>Buy Price</label><input type="text" name="inpt_data_price"></div>
                    <div class="groupinput midd"><label>Quantity</label><input type="text" name="inpt_data_qty"></div>
                </div>
                
                <div class="entr_col">
                    <div class="groupinput midd"><label>Curr. Price</label><input type="text" name="inpt_data_currprice"></div>
                    <div class="groupinput midd"><label>Change</label><input type="text" name="inpt_data_change"></div>
                    <div class="groupinput midd"><label>Open</label><input type="text" name="inpt_data_open"></div>
                    <div class="groupinput midd"><label>Low</label><input type="text" name="inpt_data_low"></div>
                    <div class="groupinput midd"><label>High</label><input type="text" name="inpt_data_high"></div>
                </div>
                
                <div class="entr_col">
                    <div class="groupinput midd"><label>Volume</label><input type="text" name="inpt_data_volume"></div>
                    <div class="groupinput midd"><label>Value</label><input type="text" name="inpt_data_value"></div>
                    <div class="groupinput midd"><label>Board Lot</label><input type="text" name="inpt_data_boardlot"></div>
                </div>
                
                <div class="entr_clear"></div>
            
        </div>
        <div class="entr_wrapper_mid">
            
            <div class="entr_col">
                <div class="groupinput selectonly">
                    <select name="inpt_data_strategy" class="rnd">
                        <option value="" selected>Select Strategy</option>
                        <option value="Bottom Picking">Bottom Picking</option>
                        <option value="Breakout Play">Breakout Play</option>
                        <option value="Trend Following">Trend Following</option>
                    </select>
                </div>
            </div>
            
            <div class="entr_col">
                <div class="groupinput selectonly">
                    <select name="inpt_data_tradeplan" class="rnd">
                        <option value="" selected>Select Trade Plan</option>
                        <option value="Day Trade">Day Trade</option>
                        <option value="Swing Trade">Swing Trade</option>
                        <option value="Investment">Investment</option>
                    </select>
                </div>
            </div>
            
            <div class="entr_col">
                <div class="groupinput selectonly">
                    <select name="inpt_data_emotion" class="rnd">
                        <option value="" selected>Select Emotion</option>
                        <option value="Nuetral">Neutral</option>
                        <option value="Greedy">Greedy</option>
                        <option value="Fearful">Fearful</option>
                    </select>
                </div>
            </div>
            
            <div class="groupinput">
                <textarea class="darktheme" name="inpt_data_tradingnotes" onClick="this.value = ''">Trading Notes</textarea>
            </div>
            
            <div class="groupinput">
                <img class="chart-loader" src="/wp-content/plugins/um-social-activity/assets/img/loader.svg" style="width: 25px; height: 25px; display: none;">
            	<input type="hidden" value="Live" name="inpt_data_status">
            	<input type="submit" class="confirmtrd green" value="Confirm Trade">
            </div>
            
         </div>
                 
        </form>
    </div> 
    
    
    
</div>

<?php 
// Save trading data to live portfolio
if( isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == "Live" ){
	
	$user_idd = $curuserid;
	$user_namee = $current_user->user_login;
	
	$data_buymonth = $_POST['inpt_data_buymonth'];
	$data_buyday = $_POST['inpt_data_buyday'];
	$data_buyyear = $_POST['inpt_data_buyyear'];
	$data_stock = $_POST['inpt_data_stock'];
	$data_price = $_POST['inpt_data_price'];
	$data_qty = $_POST['inpt_data_qty'];
	$data_currprice = $_POST['inpt_data_currprice'];
	$data_change = $_POST['inpt_data_change'];
	$data_open = $_POST['inpt_data_open'];
	$data_low = $_POST['inpt_data_low'];
	$data_high = $_POST['inpt_data_high'];
	$data_volume = $_POST['inpt_data_volume'];
	$data_value = $_POST['inpt_data_value'];
	$data_boardlot = $_POST['inpt_data_boardlot'];
	$data_strategy = $_POST['inpt_data_strategy'];
	$data_tradeplan = $_POST['inpt_data_tradeplan'];
	$data_emotion = $_POST['inpt_data_emotion'];
	$data_tradingnotes = $_POST['inpt_data_tradingnotes'];
	$data_status = $_POST['inpt_data_status'];
	
	// Gather journal data.
	$journalpost = array(
		'post_title'    => 'Trading Log - '.rand(123456,987654).' ('.$user_namee.')',
		'post_content'  => $data_tradingnotes .'...',
		'post_status'   => 'publish',
		'post_author'   => $user_idd,
		'post_category' => array(19,20),
		'meta_input'	=> array(
			'data_buymonth'		=> $data_buymonth,
			'data_buyday'		=> $data_buyday,
			'data_buyyear'		=> $data_buyyear,
			'data_stock'		=> $data_stock,
			'data_price'		=> $data_price,
			'data_qty'			=> $data_qty,
			'data_currprice'	=> $data_currprice,
			'data_change'		=> $data_change,
			'data_open'			=> $data_open,
			'data_low'			=> $data_low,
			'data_high'			=> $data_high,
			'data_volume'		=> $data_volume,
			'data_value'		=> $data_value,
			'data_boardlot'		=> $data_boardlot,
			'data_strategy'		=> $data_strategy,
			'data_tradeplan'	=> $data_tradeplan,
			'data_emotion'		=> $data_emotion,
			'data_tradingnotes'	=> $data_tradingnotes,
			'data_status'		=> $data_status
		)
	);
	 
	// Insert the data into the database as post.
	wp_insert_post( $journalpost );
	
	$sysmsg = "<div class='entr_successmsg'>New trade has been added successfully.</div>";

}

// Save trading data to trade logs
if( isset($_POST['inpt_data_status']) && $_POST['inpt_data_status'] == "Log" ){
	
	$user_idd = $curuserid;
	$user_namee = $current_user->user_login;
	
	$data_postid = $_POST['inpt_data_postid'];
	
	$data_sellmonth = $_POST['inpt_data_sellmonth'];
	$data_sellday = $_POST['inpt_data_sellday'];
	$data_sellyear = $_POST['inpt_data_sellyear'];
	$data_sellprice = $_POST['inpt_data_sellprice']; /* Buy Price */
	$data_qty = $_POST['inpt_data_qty'];
	$data_currprice = $_POST['inpt_data_currprice'];
	$data_change = $_POST['inpt_data_change'];
	$data_open = $_POST['inpt_data_open'];
	$data_low = $_POST['inpt_data_low'];
	$data_high = $_POST['inpt_data_high'];
	$data_volume = $_POST['inpt_data_volume'];
	$data_value = $_POST['inpt_data_value'];
	$data_boardlot = $_POST['inpt_data_boardlot'];
	$data_strategy = $_POST['inpt_data_strategy'];
	$data_tradeplan = $_POST['inpt_data_tradeplan'];
	$data_emotion = $_POST['inpt_data_emotion'];
	$data_status = $_POST['inpt_data_status'];
		
	if(!$_POST['inpt_data_tradingnotes']){
		$data_tradingnotes = "...";
	}else{
		$data_tradingnotes = $_POST['inpt_data_tradingnotes'];
	}
	
	// Update journal data.
	$journalpostlog = array(
		'ID'           	=> $data_postid,
		'post_title'    => 'Trading Log - '.rand(123456,987654).' ('.$user_namee.')',
		'post_content'  => $data_tradingnotes,
		'meta_input'	=> array(
			'data_sellmonth'	=> $data_sellmonth,
			'data_sellday'		=> $data_sellday,
			'data_sellyear'		=> $data_sellyear,
			'data_sellprice'	=> $data_sellprice,
			'data_qty'			=> $data_qty,
			'data_currprice'	=> $data_currprice,
			'data_change'		=> $data_change,
			'data_open'			=> $data_open,
			'data_low'			=> $data_low,
			'data_high'			=> $data_high,
			'data_volume'		=> $data_volume,
			'data_value'		=> $data_value,
			'data_boardlot'		=> $data_boardlot,
			'data_strategy'		=> $data_strategy,
			'data_tradeplan'	=> $data_tradeplan,
			'data_emotion'		=> $data_emotion,
			'data_tradingnotes'	=> $data_tradingnotes,
			'data_status'		=> $data_status
		)
	);
	 
	// Update existing data.
	wp_update_post( $journalpostlog );
	
	$sysmsgtl = "<div class='entr_successmsg'>Trade has been saved to log</div>";

}

 ?>

<?php /*?> Live Portfolio <?php */?>
<div class="tradelogscont">
	<div class="innerr">
    
		<a href="#entertrade" class="confirmtrd green fancybox-inline" style="float: right;">Enter New Trade</a>
        <h1 style="font-size:20px;"><strong>Live Portfolio</strong></h1>
        <?php echo $sysmsg; ?>
        <table class="tradelogtable" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr style="border-bottom: 1px solid #4f6379">
              <td><strong>No</strong></td>
              <td><strong>Stock</strong></td>
              <td><strong>Strategy</strong></td>
              <td><strong>Trade Plan</strong></td>
              <td><strong>Emotion</strong></td>
              <td><strong>Position</strong></td>
              <td><strong>Buy Date</strong></td>
              <td><strong>Buy Price</strong></td>
              <td><strong>Average Price</strong></td>
              <td style="text-align: right;"><strong>Sell Trade</strong></td>
              <td style="text-align: right;"><strong>Notes</strong></td>
            </tr>
            
                <?php
                $author_query = array(
								'posts_per_page' => '-1',
								'author' => $curuserid,
								'meta_key' => 'data_status',
								'meta_value'  => 'Live'
				 				);
                $author_posts = new WP_Query($author_query);
                
				$numbrng = 0;
                while($author_posts->have_posts()) : $author_posts->the_post(); $numbrng++; ?>
                <tr>
                    <td><?php echo $numbrng; ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_stock', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_strategy', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_tradeplan', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_emotion', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?></td>
					<td>
                      <?php echo get_post_meta(get_the_ID(), 'data_buymonth', true); ?> 
                      <?php echo get_post_meta(get_the_ID(), 'data_buyday', true); ?>, 
                      <?php echo get_post_meta(get_the_ID(), 'data_buyyear', true); ?>
                    </td>
                    <td><?php if (get_post_meta(get_the_ID(), 'data_price', true)){ 
                          echo "₱ " . number_format(get_post_meta(get_the_ID(), 'data_price', true), 2, ".", ",");
                          }else{ echo "₱ 0.00"; }?></td>
                    <td><?php echo "₱ 0.00"; ?></td>
                    <td style="text-align: right;">
                    	<a href="#selltrade<?php echo "_".$numbrng ; ?>" class="smlbtn fancybox-inline">SELL</a>
                    	<div class="hideformodal">
                        	<div class="tradingnotescont" id="tradingnotes<?php echo "_".$numbrng ; ?>">
                            	<div class="entr_ttle_bar">
                                    <img src="/wp-content/uploads/2018/12/logo.png" alt="Arbitrage"> <strong>Trading Notes</strong>
                                </div>
                            	<div style="padding:10px 0 0 0"><?php echo get_post_meta(get_the_ID(), 'data_tradingnotes', true); ?></div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: right;"><a href="#tradingnotes<?php echo "_".$numbrng ; ?>" class="smlbtn blue fancybox-inline">
						<i class="fa fa-sticky-note-o" aria-hidden="true"></i></a>
                    </td>
                </tr>
                <?php /*?><tr class="sysoutput"> <!-- For development purposes only -->
                	<td colspan="10">
                      <span style="color:#fff;">System Details-></span>
                      <span><strong>Status</strong>: <?php echo get_post_meta(get_the_ID(), 'data_status', true); ?></span>
                      <span><strong>Price</strong>: <?php if (get_post_meta(get_the_ID(), 'data_price', true)){ 
                          echo "₱ " . number_format(get_post_meta(get_the_ID(), 'data_price', true), 2, ".", ",");
                          }else{ echo "₱ 0.00"; }?></span>
                      <span><strong>Current Price</strong>: <?php if (get_post_meta(get_the_ID(), 'data_currprice', true)){ 
                          echo "₱ " . number_format(get_post_meta(get_the_ID(), 'data_currprice', true), 2, ".", ",");
                          }else{ echo "₱ 0.00"; }?></span>
                      <span><strong>Change</strong>: <?php echo get_post_meta(get_the_ID(), 'data_change', true); ?></span>
                      <span><strong>Open</strong>: <?php echo get_post_meta(get_the_ID(), 'data_open', true); ?></span>
                      <span><strong>Low</strong>: <?php echo get_post_meta(get_the_ID(), 'data_low', true); ?></span>
                      <span><strong>High</strong>: <?php echo get_post_meta(get_the_ID(), 'data_high', true); ?></span>
                      <span><strong>Volume</strong>: <?php echo get_post_meta(get_the_ID(), 'data_volume', true); ?></span>
                      <span><strong>Value</strong>: <?php echo get_post_meta(get_the_ID(), 'data_value', true); ?></span>
                      <span><strong>Board Lot</strong>: <?php echo get_post_meta(get_the_ID(), 'data_boardlot', true); ?></span>
                    </td>
                </tr><?php */?>
                <div class="hideformodal">
                
                    <div class="selltrade" id="selltrade<?php echo "_".$numbrng ; ?>">
                    
                        <div class="entr_ttle_bar">
                            <strong>Sell Trade</strong> <span class="datestamp_header"><?php date_default_timezone_set('Asia/Manila'); echo date("F j, Y g:i a"); ?></span>
                        </div>
                        
                        <form action="/enter-trade" method="post">
                        
                        <div class="entr_wrapper_top">
                        
                                <div class="entr_col">
                                    <div class="groupinput fctnlhdn">
                                        <label>Sell Date</label>
                                        <select name="inpt_data_sellmonth" style="width:90px;">
                                            <option value="<?php echo date("F"); ?>" selected><?php echo date("F"); ?></option>
                                            <option value="">- - -</option>
                                            <option value="January">January</option>
                                            <option value="Febuary">Febuary</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                        <input type="text" name="inpt_data_sellday" style="width:32px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("j"); ?>">
                                        <input type="text" name="inpt_data_sellyear" style="width:45px; border-radius:3px; text-align:center; padding:0;" value="<?php echo date("Y"); ?>">
                                        </div>
                                    
                                    <div class="groupinput midd lockedd"><label>Stock</label><input type="text" name="inpt_data_stock" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_stock', true); ?>" readonly style="text-align: left;"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                    
                                    <div class="groupinput midd lockedd"><label>Buy Price</label><input type="text" name="inpt_data_price"
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_price', true); ?>" readonly><i class="fa fa-lock" aria-hidden="true"></i></div>
                                    
                                    <div class="groupinput midd"><label>Sell Price</label><input type="text" name="inpt_data_sellprice"></div>
                                    
                                    <div class="groupinput midd"><label>Qty.</label><input type="text" name="inpt_data_qty"
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?>"></div>
                                </div>
                                
                                <div class="entr_col">
                                    <div class="groupinput midd"><label>Curr. Price</label><input type="text" name="inpt_data_currprice" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_currprice', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Change</label><input type="text" name="inpt_data_change" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_change', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Open</label><input type="text" name="inpt_data_open" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_open', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Low</label><input type="text" name="inpt_data_low" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_low', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>High</label><input type="text" name="inpt_data_high" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_high', true); ?>"></div>
                                </div>
                                
                                <div class="entr_col">
                                    <div class="groupinput midd"><label>Volume</label><input type="text" name="inpt_data_volume" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_volume', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Value</label><input type="text" name="inpt_data_value" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_value', true); ?>"></div>
                                    
                                    <div class="groupinput midd"><label>Board Lot</label><input type="text" name="inpt_data_boardlot" 
                                    value="<?php echo get_post_meta(get_the_ID(), 'data_boardlot', true); ?>"></div>
                                </div>
                                
                                <div class="entr_clear"></div>
                            
                        </div>
                        <div class="entr_wrapper_mid">
                            
                            <div class="entr_col fctnlhdn">
                                <div class="groupinput selectonly">
                                    <select name="inpt_data_strategy" class="rnd">
                                        <option value="<?php echo get_post_meta(get_the_ID(), 'data_strategy', true); ?>" selected>
										Strategy: <?php echo get_post_meta(get_the_ID(), 'data_strategy', true); ?></option>
                                        <option value="">- - -</option>
                                        <option value="Bottom Picking">Bottom Picking</option>
                                        <option value="Breakout Play">Breakout Play</option>
                                        <option value="Trend Following">Trend Following</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="entr_col fctnlhdn">
                                <div class="groupinput selectonly">
                                    <select name="inpt_data_tradeplan" class="rnd">
                                        <option value="<?php echo get_post_meta(get_the_ID(), 'data_tradeplan', true); ?>" selected>
										Trade Plan: <?php echo get_post_meta(get_the_ID(), 'data_tradeplan', true); ?></option>
                                        <option value="">- - -</option>
                                        <option value="Day Trade">Day Trade</option>
                                        <option value="Swing Trade">Swing Trade</option>
                                        <option value="Investment">Investment</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="entr_col fctnlhdn">
                                <div class="groupinput selectonly">
                                    <select name="inpt_data_emotion" class="rnd">
                                        <option value="<?php echo get_post_meta(get_the_ID(), 'data_emotion', true); ?>" selected>
										Emotion: <?php echo get_post_meta(get_the_ID(), 'data_emotion', true); ?></option>
                                        <option value="Nuetral">Nuetral</option>
                                        <option value="Greedy">Greedy</option>
                                        <option value="Fearful">Fearful</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="groupinput fctnlhdn">
                                <textarea class="darktheme" name="inpt_data_tradingnotes"><?php echo get_post_meta(get_the_ID(), 'data_tradingnotes', true); ?></textarea>
                            </div>
                            
                            <div>
                                <input type="hidden" value="Log" name="inpt_data_status">
                                <input type="hidden" value="<?php echo get_the_ID(); ?>" name="inpt_data_postid">
                                <input type="submit" class="confirmtrd red" value="Sell Trade">
                            </div>
                            
                         </div>
                                 
                        </form>
                    </div> 
                
                </div>
                
                <?php endwhile; ?>
            
            
          </tbody>
        </table>
        
        
	</div>
</div>

<?php /*?> Trade Logs <?php */?>
<div class="tradelogscont">
	<div class="innerr">

        <h1 style="font-size:20px;"><strong>Trade Logs</strong></h1>
        <?php echo $sysmsgtl; ?>
        <table class="tradelogtable" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr style="border-bottom: 1px solid #4f6379">
              <td><strong>No</strong></td>
              <td><strong>Stock</strong></td>
              <td><strong>Strategy</strong></td>
              <td><strong>Trade Plan</strong></td>
              <td><strong>Emotion</strong></td>
              <td><strong>Qty.</strong></td>
              <td><strong>Buy Date</strong></td>
              <td><strong>Buy Price</strong></td>
              <td><strong>Average Price</strong></td>
              <td><strong>Sell Date</strong></td>
              <td><strong>Sell Price</strong></td>
              <td><strong>Performance</strong></td>
              <td><strong>Outcome</strong></td>
              <td><strong>Prof/Loss</strong></td>
              <td style="text-align:right;"><strong>Notes</strong></td>
            </tr>
            
                <?php
                $author_querytl = array(
								'posts_per_page' => '-1',
								'author' => $curuserid,
								'meta_key' => 'data_status',
								'meta_value'  => 'Log'
				 				);
                $author_poststl = new WP_Query($author_querytl);
                
				$numbrng = 0;
                while($author_poststl->have_posts()) : $author_poststl->the_post(); $numbrng++; ?>
                <tr>
                    <td><?php echo $numbrng; ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_stock', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_strategy', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_tradeplan', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_emotion', true); ?></td>
                    <td><?php echo get_post_meta(get_the_ID(), 'data_qty', true); ?></td>
					<td>
                      <?php echo get_post_meta(get_the_ID(), 'data_buymonth', true); ?> 
                      <?php echo get_post_meta(get_the_ID(), 'data_buyday', true); ?>, 
                      <?php echo get_post_meta(get_the_ID(), 'data_buyyear', true); ?>
                    </td>
                    <td><?php if (get_post_meta(get_the_ID(), 'data_price', true)){ 
                          echo "₱ " . number_format(get_post_meta(get_the_ID(), 'data_price', true), 2, ".", ",");
                          }else{ echo "₱ 0.00"; }?>
                    </td>
                    <td><?php echo "₱ 0.00"; ?></td>
                    <td>
                      <?php echo get_post_meta(get_the_ID(), 'data_sellmonth', true); ?> 
                      <?php echo get_post_meta(get_the_ID(), 'data_sellday', true); ?>, 
                      <?php echo get_post_meta(get_the_ID(), 'data_sellyear', true); ?>
                    </td>
                    <td><?php if (get_post_meta(get_the_ID(), 'data_sellprice', true)){ 
                          echo "₱ " . number_format(get_post_meta(get_the_ID(), 'data_price', true), 2, ".", ",");
                          }else{ echo "₱ 0.00"; }?>
                    </td>
                    <td><?php echo $data_performance; /* No data at the moment */ ?></td>
                    <td><?php echo $data_outcome; /* No data at the moment */ ?></td>
                    <td><?php echo $data_proflosss; /* No data at the moment */ ?></td>
                    
                    
                    <td style="text-align: right;">
                        <a href="#tradingnotes<?php echo "_".$numbrng ; ?>" class="smlbtn blue fancybox-inline"><i class="fa fa-sticky-note-o" aria-hidden="true"></i></a>
                    	<div class="hideformodal">
                        	<div class="tradingnotescont" id="tradingnotes<?php echo "_".$numbrng ; ?>">
                            	<div class="entr_ttle_bar">
                                    <img src="/wp-content/uploads/2018/12/logo.png" alt="Arbitrage"> <strong>Trading Notes</strong>
                                </div>
                            	<div style="padding:10px 0 0 0"><?php echo get_post_meta(get_the_ID(), 'data_tradingnotes', true); ?></div>
                            </div>
                        </div>
                    </td>
                </tr>
                
                <?php endwhile; ?>
            
            
          </tbody>
        </table>
        
        
	</div>
</div>
<?php get_footer();

