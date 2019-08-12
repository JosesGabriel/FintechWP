<?php
	/*
	* Template Name: Chart History
	* Template page for Watchlist Page Platform
    */
    

    // echo "<pre>";
    //     print_r($_GET);
    // echo "</pre>";
    header('Content-Type: application/json');
    if(isset($_GET['symbol'])){
        $myfile = fopen("https://arbitrage.ph/data/".strtolower($_GET['symbol']).".json", "r") or die("Unable to open file!");
    
        echo fgets($myfile);
        fclose($myfile);

        // echo ;
    }

    if(isset($_GET['query'])){
        $stocks = fopen("https://arbitrage.ph/data/stocks.json", "r") or die("Unable to open file!");
        $jsondata = fgets($stocks);
        fclose($stocks);

        $arraymode = json_decode($jsondata);
        $dstock = strtolower($_GET['query']);

        // add params
        $newinfo = [];
        foreach ($arraymode as $addvalskey => $addvalsvalue) {
            $addvalsvalue->full_name = $addvalsvalue->symbol;
            array_push($newinfo,$addvalsvalue);
        }

        $listofitems = [];
        foreach ($newinfo as $key => $value) {
            if (strpos(strtolower($value->symbol), $dstock) !== false) {
                
                array_push($listofitems, $value);
                // echo "ersr";
            }
        }

        // echo "[".json_encode($listofitems)."]";
        // echo '[{"symbol":"BPI","description":"BANK OF THE PHILIPPINE ISLANDS","full_name":"BPI", "display_name" : "BPI"}]'; 
        echo json_encode($listofitems);
        // print_r($dstock);

    }

    if(isset($_GET['g']) && $_GET['g'] == "fullstack" ){
        
        $stocks = fopen("https://arbitrage.ph/data/fallstocks.json", "r") or die("Unable to open file!");
        $jsondata = fgets($stocks);
        fclose($stocks);

        $infobase = json_decode($jsondata);
        // echo $jsondata;

        // $source = [];
        // foreach ($infobase as $key => $value) {
        //     $code = $value->StockInfo->StockCode;
        //     $value->StockHistory->symbol = $code;
        //     array_push($source, $value->StockHistory);
        // }

        // $fallss = [];
        // foreach ($infobase as $key => $value) {
        //     // 
        //     $inobject = [];
        //     foreach ($value->StockHistory as $innerskey => $innersvalue) {
        //         // array_push($inobject, [strtolower($innerskey) => $innersvalue]);
        //         $inobject[strtolower($innerskey)] = $innersvalue;
        //     }

        //     array_push($fallss, $inobject);
        //     // echo $value;
        //     // print_r($value);
        // }

        $outputs = keysToLower($infobase);

        echo json_encode($outputs);
        // echo json_encode($fallss);
    }

    if(isset($_GET['g']) && $_GET['g'] == "md"){
        $darray = [
            [
                "bid_count" => '20',
                "bid_volume" => '100',
                "bid_price" => '250',
                "ask_price" => '250',
                "ask_volume" => '100',
                "ask_count" => '20',
            ],
            [
                "bid_count" => '20',
                "bid_volume" => '100',
                "bid_price" => '250',
                "ask_price" => '250',
                "ask_volume" => '100',
                "ask_count" => '20',
            ],
            [
                "bid_count" => '20',
                "bid_volume" => '100',
                "bid_price" => '250',
                "ask_price" => '250',
                "ask_volume" => '100',
                "ask_count" => '20',
            ],
            [
                "bid_count" => '20',
                "bid_volume" => '100',
                "bid_price" => '250',
                "ask_price" => '250',
                "ask_volume" => '100',
                "ask_count" => '20',
            ],
            [
                "bid_count" => '20',
                "bid_volume" => '100',
                "bid_price" => '250',
                "ask_price" => '250',
                "ask_volume" => '100',
                "ask_count" => '20',
            ],
            [
                "bid_count" => '20',
                "bid_volume" => '100',
                "bid_price" => '250',
                "ask_price" => '250',
                "ask_volume" => '100',
                "ask_count" => '20',
            ],
        ];

        echo json_encode($darray);


    }

    if(isset($_GET['g']) && $_GET['g'] == "stocksdata"){
        echo "here";
    }

    if(isset($_GET['g']) && $_GET['g'] == "sampleprice"){
        $dlistofstocks =    ;
        $dlistofstocks = json_decode($dlistofstocks);
        //filter as per stock

        

        $stockinfo = [];
        foreach ($dlistofstocks as $key => $value) {
            $min = 1;
            $max = 10;
            if($value == "PHEN"){
                $curprice = 2.66;
                $stockinfo[$value]['last'] = $curprice;
                $stockinfo[$value]['change'] = 0;
                $stockinfo[$value]['open'] = 2.66;
                $stockinfo[$value]['high'] = 2.70;
                $stockinfo[$value]['low'] = 2.61;
                $stockinfo[$value]['volume'] = "9.20M";
                $stockinfo[$value]['value'] = $curprice;
                $stockinfo[$value]['symbol'] = $value;
            } elseif($value == "TEL"){
                $curprice = 1168;
                $stockinfo[$value]['last'] = $curprice;
                $stockinfo[$value]['change'] = 1.72;
                $stockinfo[$value]['open'] = 1168;
                $stockinfo[$value]['high'] = 1208;
                $stockinfo[$value]['low'] = 1168;
                $stockinfo[$value]['volume'] = "232.49k";
                $stockinfo[$value]['value'] = $curprice;
                $stockinfo[$value]['symbol'] = $value;
            } else {
                $curprice = mt_rand ($min*10, $max*10) / 10;
                $stockinfo[$value]['last'] = $curprice;
                $stockinfo[$value]['change'] = mt_rand ($min*10, $max*10) / 10;
                $stockinfo[$value]['open'] = mt_rand ($min*10, $max*10) / 10;
                $stockinfo[$value]['high'] = mt_rand (6*10, 10*10) / 10;
                $stockinfo[$value]['low'] = mt_rand (1*10, 5*10) / 10;
                $stockinfo[$value]['volume'] = "".rand(500,1000);
                $stockinfo[$value]['value'] = $curprice;
                $stockinfo[$value]['symbol'] = $value;
            }
        }
        $finalinfo = [];
        $finalinfo['data'] = $stockinfo;

        print_r(json_encode($finalinfo));
    }

    if(isset($_GET['todel']) && $_GET['todel'] == "sampleprice"){
        echo "here";
    }
    
    

    function &keysToLower(&$obj)
    {
        $type = (int) is_object($obj) - (int) is_array($obj);
        if ($type === 0) return $obj;
        foreach ($obj as $key => &$val)
        {
            $element = keysToLower($val);
            switch ($type)
            {
            case 1:
                if (!is_int($key) && $key !== ($keyLowercase = strtolower($key)))
                {
                    unset($obj->{$key});
                    $key = $keyLowercase;
                }
                $obj->{$key} = $element;
                break;
            case -1:
                if (!is_int($key) && $key !== ($keyLowercase = strtolower($key)))
                {
                    unset($obj[$key]);
                    $key = $keyLowercase;
                }
                $obj[$key] = $element;
                break;
            }
        }
        return $obj;
    }
    


 ?>