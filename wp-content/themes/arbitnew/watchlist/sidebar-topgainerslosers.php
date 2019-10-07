
<script>
    jQuery(document).ready( function() {
        $.ajax({
              type:'POST',
              url:'/wp-json/data-api/v1/stocks/history/latest?exchange=PSE',
              dataType: 'json',
              //data: "stockss="+JSON.stringify(data),
              success: function(response) {
                  // var myJSON = JSON.stringify(response);
                    var stocks = [];
                    var stocks2 = [];
                    var i = 0;
                    var d = new Date();
                    var curr_date = d.getDate();
                    var curr_month = d.getMonth() + 1; //Months are zero based
                    var curr_year = d.getFullYear();
                    var dt = curr_year + "-" + curr_month + "-" + curr_date;
                    var cur_d;
                    var cur_m;
                    var cur_y;

                   // console.log(dt);
                    jQuery.each(response.data, function(i, val) {
                        stocks[i] = [];
                        stocks[i][0] = val.symbol;
                        stocks[i][1] = val.changepercentage;
                        stocks[i][2] = val.description;
                        var ltime = val.lastupdatetime;
                        var ltime2 = ltime.split('T');
                        stocks[i][3] = new Date(ltime2[0]);                        
                        i++;
                    });

                    stocks.sort(function(a, b){
                        return b[3] - a[3];
                    });

                    var sdate = new Date(stocks[0][3]);
                    var new_day = sdate.getDate();
                    var new_mo = sdate.getMonth() + 1;
                    var new_yr = sdate.getFullYear();
                
                    var n = 0;

                    do {
                        cur_d = stocks[n][3].getDate();
                        cur_m = stocks[n][3].getMonth() + 1;
                        cur_y = stocks[n][3].getFullYear();
                        stocks2[n] = [];
                        stocks2[n][0] = stocks[n][0];
                        stocks2[n][1] = stocks[n][1]; 
                        stocks2[n][2] = stocks[n][2];  
                        stocks2[n][3] = stocks[n][3]; 
                        //console.log(stocks[n][3]);
                        n++;
                    }while(new_day == cur_d && new_mo == cur_m && new_yr == cur_y);

                    stocks2.sort(function(a, b){
                        return b[1] - a[1];
                    });
                    var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
                    for (var i = 0; i < 5; i++) {
                        
                        var list = '<li class="odd"> <span style="border-color:' + colors[i] + ';">' + stocks2[i][0] + '</span>';
                            list += '<a href="#">' + stocks2[i][2] + '<br><p style="color: #53b987 !important;">' + stocks2[i][1].toFixed(2) + '%</p></a>';
                            list += '</li>';

                        jQuery(".gainers ul").append(list);
                    }

                    stocks2.sort(function(a, b){
                        return a[1] - b[1];
                    });

                    for (var i = 0; i < 5; i++) {
                        
                        var list = '<li class="odd"> <span style="border-color:' + colors[i][6] + ';">' + stocks2[i][0] + '</span>';
                            list += '<a href="#">' + stocks2[i][2] + '<br><p style="color: #eb4d5c !important;">' + stocks2[i][1].toFixed(2) + '%</p></a>';
                            list += '</li>';

                        jQuery(".losers ul").append(list);
                    }
                },
                error: function(response) {                 
                }
            });
     });
        
</script>
    
    <div class="top-stocks">
            <div class="to-top-title gainers-title"><strong>Biggest Gainers </strong></div>
            <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
            <div class="to-content-part gainers">
                     <ul></ul>                                          
            </div>          

</div>
<div class="top-stocks">

    <div class="to-top-title losers-title"><strong>Biggest Losers</strong></div>
            <hr class="style14 style15" style="width: 90% !important;margin-bottom: 2px !important;margin-top: 6px !important;/* margin: 5px 0px !important; */">
            <div class="to-content-part losers">
                   <ul></ul>
            </div>
</div>


