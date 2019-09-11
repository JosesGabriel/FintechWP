$( document ).ready(function() {

    // setTimeout(function(){
        
    
    // }, 1000);

    $.ajax({
        url: "https://dev-v1.arbitrage.ph/apipge/?daction=trendingstocks",
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            $(".trendingpreloader").hide();
            $.each(res, function( index, value ) {
                var colors = ['#f44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50'];
                var toappend = '<li class="even '+index+'">';
                toappend += '<span style="border-color: '+colors[index]+';">'+value.stock+'</span>';
                toappend += '<a href="#">'+value.stnamename+'<br>';
                toappend += '<p>'+value.following+' Hits</p></a>';
                toappend += '</li>';

                if(index < 6){
                    $("ul.trendingme > .trend-content-hidden").before(toappend);
                } else {
                    $("ul.trendingme > .trend-content-hidden").append(toappend);
                }
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });

    $.ajax({
        url: "https://dev-v1.arbitrage.ph/apipge/?daction=whotomingle",
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            $(".top-recommended-people > .trendingpreloader").hide();
            $.each(res, function( index, value ) {
                var toappendme = '<div class="trader-item userid_'+value.id+'">';
                toappendme += '<div class="traider-inner">';
                toappendme += '<div class="traider-image">';
                toappendme += '<div class="circle-frame" style="border:2px solid rgba(101, 131, 168, 0.4196078431372549);padding: 4px !important;border-radius: 50%;width: 47px;height: 47px;">';
                toappendme += '<div class="side-image" style="background: url("'+value.profpic+'") no-repeat center center;">&nbsp;</div>';
                toappendme += '</div>';
                toappendme += '</div>';
                toappendme += '<div class="traider-details">';
                toappendme += '<div class="traider-name"><a href="https://arbitrage.ph/user/'+value.user_nicename+'">'+value.displayname+'</a>';
                toappendme += '<div class="login"></div>';
                toappendme += '</div>';
                toappendme += '<div class="traider-follower">';
                toappendme += '<div class="onbfollow"><a href="#" id="mingle-btn" style="border: 1.3px solid #e77e24;" class="um-friend-btn um-button um-alt outmingle" data-user_id1="'+value.id+'" data-user_id2="'+value.currentuser+'">Mingle</a></div>';
                toappendme += '</div>';
                toappendme += '</div>';
                toappendme += '</div>';
                toappendme += '</div>';

                $(".top-recommended-people").append(toappendme);

            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });

    // $.ajax({
    //     url: "https://dev-v1.arbitrage.ph/apipge/?daction=socialwall",
    //     type: 'GET',
    //     dataType: 'html', // added data type
    //     success: function(res) {
    //         $(".social-wall-part").html(res);
    //     },
    //     error: function (xhr, ajaxOptions, thrownError) {
    //         console.log(xhr.status);
    //         console.log(thrownError);
    //     }
    // });

    
});
