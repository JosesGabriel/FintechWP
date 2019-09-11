$( document ).ready(function() {

    setTimeout(function(){
        $.ajax({
            url: "https://dev-v1.arbitrage.ph/apipge/?daction=trendingstocks",
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                console.log(res);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    
    }, 2000);

    
});
