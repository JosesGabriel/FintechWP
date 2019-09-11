$( document ).ready(function() {

    setTimeout(function(){
        $.ajax({
            url: "https://dev-v1.arbitrage.ph/apipge/?daction=trendingstocks",
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                console.log(res);
                $.each(res, function( index, value ) {
                    $toappend = '<li class="even '+index+'">';
                    $toappend += '<span>'+value.stock+'</span>';
                    $toappend += '<a href="#">'+value.stnamename+'<br>';
                    $toappend += '<p>'+value.following+' Hits</p></a>';
                    $toappend += '</li>';

                    if(index < 6){
                        $("ul.trendingme").append($toappend);
                    } else {
                        $("ul.trendingme > .trend-content-hidden").append($toappend);
                    }
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    
    }, 2000);

    
});
