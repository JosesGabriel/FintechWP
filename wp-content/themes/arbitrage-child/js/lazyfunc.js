$( document ).ready(function() {

    // setTimeout(function(){
        
    
    // }, 1000);

    $.ajax({
        url: "https://dev-v1.arbitrage.ph/apipge/?daction=trendingstocks",
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            $(".trendingpreloader").hide();
            console.log(res);
            $.each(res, function( index, value ) {
                var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
                $toappend = '<li class="even '+index+'">';
                $toappend += '<span style="border-color: '+colors[index]+';">'+value.stock+'</span>';
                $toappend += '<a href="#">'+value.stnamename+'<br>';
                $toappend += '<p>'+value.following+' Hits</p></a>';
                $toappend += '</li>';

                if(index < 6){
                    $("ul.trendingme > .trend-content-hidden").before($toappend);
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

    
});
