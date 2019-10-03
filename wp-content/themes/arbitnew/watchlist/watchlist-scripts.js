$(document).ready(function(){

    $(".gainers-title").click(function () {
        
        if($('.gainers').css('display') == 'none'){
            $('.gainers').slideDown();
        }else {
             $('.gainers').slideUp();
        }
    });


    $(".losers-title").click(function () {
        
        if($('.losers').css('display') == 'none'){
            $('.losers').slideDown();
        }else {
             $('.losers').slideUp();
        }
    });


    jQuery('.addwatch').click(function(e){
    jQuery(".dtabcontent > div").removeClass('active').hide('slow');
    jQuery(".dtabcontent .addwatchtab").addClass('active').show('slow');
            
            $.ajax({
                url: "/wp-json/data-api/v1/stocks/list",
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                        
                    jQuery.each(res.data, function(index, value) {      
                            jQuery('.listofstocks').append('<a class="datastock_' + index + '" href="#" data-dstock="'+value.symbol+'">'+value.symbol+'</a>');
                            index++;        
                    });  

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    
                }
            });


    var staticstocks = ["2GO","8990P","AAA","AB","ABA","ABC","ABG","ABS","ABSP","AC","ACE","ACPA","ACPB1","ACPB2","ACR","AEV","AGI","ALCO","ALCPB","ALHI","ALI","ALL","ANI","ANS","AP","APC","APL","APO","APX","AR","ARA","AT","ATI","ATN","ATNB","AUB","BC","BCB","BCOR","BCP","BDO","BEL","BH","BHI","BKR","BLFI","BLOOM","BMM","BPI","BRN","BSC","CA","CAB","CAT","CDC","CEB","CEI","CEU","CHI","CHIB","CHP","CIC","CIP","CLC","CLI","CNPF","COAL","COL","COSCO","CPG","CPM","CPV","CPVB","CROWN","CSB","CYBR","DAVIN","DD","DDPR","DELM","DFNN","DIZ","DMC","DMCP","DMPA1","DMPA2","DMW","DNA","DNL","DTEL","DWC","EAGLE","ECP","EDC","EEI","EG","EIBA","EIBB","ELI","EMP","EURO","EVER","EW","FAF","FB","FBP","FBP2","FDC","FERRO","FEU","FFI","FGEN","FGENF","FGENG","FIN","FJP","FJPB","FLI","FMETF","FNI","FOOD","FPH","FPHP","FPHPC","FPI","FYN","FYNB","GEO","GERI","GLO","GLOPA","GLOPP","GMA7","GMAP","GPH","GREEN","GSMI","GTCAP","GTPPA","GTPPB","H2O","HDG","HI","HLCM","HOUSE","HVN","I","ICT","IDC","IMI","IMP","IND","ION","IPM","IPO","IRC","IS","ISM","JAS","JFC","JGS","JOH","KEP","KPH","KPHB","LAND","LBC","LC","LCB","LFM","LIHC","LMG","LOTO","LPZ","LR","LRP","LRW","LSC","LTG","M-O","MA","MAB","MAC","MACAY","MAH","MAHB","MARC","MAXS","MB","MBC","MBT","MED","MEG","MER","MFC","MFIN","MG","MGH","MHC","MJC","MJIC","MPI","MRC","MRP","MRSGI","MVC","MWC","MWIDE","MWP","NI","NIKL","NOW","NRCP","NXGEN","OM","OPM","OPMB","ORE","OV","PA","PAL","PAX","PBB","PBC","PCOR","PCP","PERC","PGOLD","PHA","PHC","PHEN","PHES","PHN","PIP","PIZZA","PLC","PMPC","PMT","PNB","PNC","PNX","PNX3A","PNX3B","PNXP","POPI","PORT","PPC","PPG","PRC","PRF2A","PRF2B","PRIM","PRMX","PRO","PSB","PSE","PSEI","PTC","PTT","PX","PXP","RCB","RCI","REG","RFM","RLC","RLT","ROCK","ROX","RRHI","RWM","SBS","SCC","SECB","SEVN","SFI","SFIP","SGI","SGP","SHLPH","SHNG","SLF","SLI","SM","SMC","SMC2A","SMC2B","SMC2C","SMC2D","SMC2E","SMC2F","SMC2G","SMC2H","SMC2I","SMCP1","SMPH","SOC","SPC","SPM","SRDC","SSI","SSP","STI","STN","STR","SUN","SVC","T","TBGI","TECB2","TECH","TEL","TFC","TFHI","TLII","TLJJ","TUGS","UBP","UNI","UPM","URC","V","VITA","VLL","VMC","VUL","VVT","WEB","WIN","WLCON","WPI","X","ZHI"];

    jQuery.each(staticstocks, function(index, value) {      
                           jQuery('.listofstocks').append('<a class="datastock_' + index + '" href="#" data-dstock="'+staticstocks[index]+'">'+staticstocks[index]+'</a>');
                          index++;        
                   });

               

    });

    jQuery('#canceladd').click(function(e){
        e.preventDefault();
        jQuery(".dtabcontent > div").removeClass('active').hide('slow');
        jQuery(".dtabcontent .watchtab").addClass('active').show('slow');
    });

    jQuery('#myDropdown').click(function(e){
                e.preventDefault();

                var dtyped = jQuery(this).val();
                
                if(jQuery(this).val().length < 1){
                    jQuery('.ddropbase').removeClass('opendrop').hide('slow');
                }

                if (jQuery(this).hasClass('disopen')) {
                    jQuery(this).removeClass('disopen');
                } else {
                    jQuery(this).addClass('disopen');
                    jQuery('.ddropbase').addClass('opendrop').show('slow');
                }

                jQuery('.stockerror.errorpop').remove();

    });


    jQuery( "#myDropdown" ).keyup(function(e) {
        e.preventDefault();

        var dtyped = jQuery(this).val();

        jQuery(".listofstocks > a").each(function(index){
            var istock = jQuery(this).attr('data-dstock');
            if (istock.toLowerCase().indexOf(dtyped) >= 0) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            }
        });
    });

    jQuery(document).on('click','.ddropbase a',function(e){
        e.preventDefault();
        var dstock = jQuery(this).attr('data-dstock');

        jQuery('#myDropdown').val(dstock);
        jQuery('.ddropbase').removeClass('opendrop').hide('slow');

        jQuery(this).parents('.ddropbase').find('#dstockname').val(dstock);

       
    });

     jQuery('#submitmenow').click(function(e){
              e.preventDefault();
              jQuery("#add-watchlist-param").submit();
              var isstock = jQuery(this).parents('#add-watchlist-param').find("#dstockname").val();         
             //var countli = jQuery(".listofinfo li").length;
             //if (countli != 0) {
                console.log(isstock);

               if (isstock != "" && jQuery("#add-watchlist-param input:checkbox:checked").length > 0 ) {
                  jQuery("#add-watchlist-param").submit();
                  $('.chart-loader').css("display","block");
                  $(this).hide();
             }
              //}
           });


});