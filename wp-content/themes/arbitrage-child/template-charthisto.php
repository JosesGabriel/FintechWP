<?php
	/*
	* Template Name: Chart History
	* Template page for Watchlist Page Platform
    */
    

    header('Content-Type: application/json');
    if(isset($_GET['symbol'])){
        $myfile = fopen("/data/".strtolower($_GET['symbol']).".json", "r") or die("Unable to open file!");
    
        echo fgets($myfile);
        fclose($myfile);

        // echo ;
    }

    if(isset($_GET['query'])){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "/wp-json/data-api/v1/stocks/list");
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response !== false) {
            $response = $response;

            $arraymode = $response->data;
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
                }
            }

            echo json_encode($listofitems);
        }
    }

    if(isset($_GET['g']) && $_GET['g'] == "fullstack" ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "/wp-json/data-api/v1/stocks/history/latest?exchange=PSE");
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        if ($response !== false) {
            $response = json_decode($response, true);
            echo json_encode($response['data']);
        }
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
        $dlistofstocks = '["2GO","8990P","AAA","AB","ABA","ABC","ABG","ABS","ABSP","AC","ACE","ACPA","ACPB1","ACPB2","ACR","AEV","AGI","ALCO","ALCPB","ALHI","ALI","ALL","ANI","ANS","AP","APC","APL","APO","APX","AR","ARA","AT","ATI","ATN","ATNB","AUB","BC","BCB","BCOR","BCP","BDO","BEL","BH","BHI","BKR","BLFI","BLOOM","BMM","BPI","BRN","BSC","CA","CAB","CAT","CDC","CEB","CEI","CEU","CHI","CHIB","CHP","CIC","CIP","CLC","CLI","CNPF","COAL","COL","COSCO","CPG","CPM","CPV","CPVB","CROWN","CSB","CYBR","DAVIN","DD","DDPR","DELM","DFNN","DIZ","DMC","DMCP","DMPA1","DMPA2","DMW","DNA","DNL","DTEL","DWC","EAGLE","ECP","EDC","EEI","EG","EIBA","EIBB","ELI","EMP","EURO","EVER","EW","FAF","FB","FBP","FBP2","FDC","FERRO","FEU","FFI","FGEN","FGENF","FGENG","FIN","FJP","FJPB","FLI","FMETF","FNI","FOOD","FPH","FPHP","FPHPC","FPI","FYN","FYNB","GEO","GERI","GLO","GLOPA","GLOPP","GMA7","GMAP","GPH","GREEN","GSMI","GTCAP","GTPPA","GTPPB","H2O","HDG","HI","HLCM","HOUSE","HVN","I","ICT","IDC","IMI","IMP","IND","ION","IPM","IPO","IRC","IS","ISM","JAS","JFC","JGS","JOH","KEP","KPH","KPHB","LAND","LBC","LC","LCB","LFM","LIHC","LMG","LOTO","LPZ","LR","LRP","LRW","LSC","LTG","M-O","MA","MAB","MAC","MACAY","MAH","MAHB","MARC","MAXS","MB","MBC","MBT","MED","MEG","MER","MFC","MFIN","MG","MGH","MHC","MJC","MJIC","MPI","MRC","MRP","MRSGI","MVC","MWC","MWIDE","MWP","NI","NIKL","NOW","NRCP","NXGEN","OM","OPM","OPMB","ORE","OV","PA","PAL","PAX","PBB","PBC","PCOR","PCP","PERC","PGOLD","PHA","PHC","PHEN","PHES","PHN","PIP","PIZZA","PLC","PMPC","PMT","PNB","PNC","PNX","PNX3A","PNX3B","PNXP","POPI","PORT","PPC","PPG","PRC","PRF2A","PRF2B","PRIM","PRMX","PRO","PSB","PSE","PSEI","PTC","PTT","PX","PXP","RCB","RCI","REG","RFM","RLC","RLT","ROCK","ROX","RRHI","RWM","SBS","SCC","SECB","SEVN","SFI","SFIP","SGI","SGP","SHLPH","SHNG","SLF","SLI","SM","SMC","SMC2A","SMC2B","SMC2C","SMC2D","SMC2E","SMC2F","SMC2G","SMC2H","SMC2I","SMCP1","SMPH","SOC","SPC","SPM","SRDC","SSI","SSP","STI","STN","STR","SUN","SVC","T","TBGI","TECB2","TECH","TEL","TFC","TFHI","TLII","TLJJ","TUGS","UBP","UNI","UPM","URC","V","VITA","VLL","VMC","VUL","VVT","WEB","WIN","WLCON","WPI","X","ZHI"]';
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