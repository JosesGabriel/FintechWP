$( document ).ready(function() {

    // setTimeout(function(){


    // }, 1000);
    $.ajax({
        url: '/apipge/?daction=sidebar-bulletin',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                $('.right-dashboard-part .latest-news .to-rss-inner').prepend(res.data);
            }
        }
    });

    $.ajax({
        url: "/sidebar-api/?daction=trendingstocks",
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

        }
    });

    $.ajax({
        url: "/sidebar-api/?daction=whotomingle",
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            $(".trendingpreloader").hide();
            $.each(res, function( index, value ) {
                var toappendme = '<div class="trader-item userid_'+value.id+'">';
                toappendme += '<div class="traider-inner">';
                toappendme += '<div class="traider-image">';
                toappendme += '<div class="circle-frame" style="border:2px solid rgba(101, 131, 168, 0.4196078431372549);padding: 4px !important;border-radius: 50%;width: 47px;height: 47px;">';
                toappendme += '<div class="side-image" style="background: url('+value.profpic+') no-repeat center center;">&nbsp;</div>';
                toappendme += '</div>';
                toappendme += '</div>';
                toappendme += '<div class="traider-details">';
                toappendme += '<div class="traider-name"><a href="/user/'+value.user_nicename+'">'+value.displayname+'</a>';
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

        }
    });



    $.ajax({
        url: "/apipge/?daction=topplayers",
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {

            $.each(res, function( index, value ) {
                if(value.type == 'allrank'){
                    if(value.myrank <= 3){
                        var ranker = '<li>'
                            ranker += '<div class="hudbadge"><img src="/svg/top'+value.myrank+'.svg" alt=""></div>'
                            ranker += '<div class="playerscontent">'
                            ranker += '<div class="isname" style="width: 120px;">'+value.displayname+'</div>'
                            ranker += '<span class="profit_loss" style="color: #24a65d;float: right;position: absolute;top: 4px;width: 95%;text-align: right;font-size: 13px;"> ₱ '+value.bttotal+'</span>';
                            ranker += '<div class="istotal">';
                            ranker += '<span class="value-t"> ₱ '+value.bttotal+'</span>';
                            ranker += '<span class="value-p" style="color: #25ae5f;"><i class="fas fa-caret-up caret"></i>'+value.btperc+' %</span>';
                            ranker += '</div>';
                            ranker += '</div>';
                        ranker += '</li>';
                        $(".ranks .topsect").append(ranker);
                    } else if(value.myrank >= 4 && value.myrank <= 5) {
                        var ranker = '<li>'
                            ranker += '<div class="hudbadge"><img src="/svg/top4.svg" alt=""></div>'
                            ranker += '<div class="playerscontent">'
                            ranker += '<div class="isname" style="width: 120px;">'+value.displayname+'</div>'
                            ranker += '<span class="profit_loss" style="color: #24a65d;float: right;position: absolute;top: 4px;width: 95%;text-align: right;font-size: 13px;"> ₱ '+value.bttotal+'</span>';
                            ranker += '<div class="istotal">';
                            ranker += '<span class="value-t"> ₱ '+value.bttotal+'</span>';
                            ranker += '<span class="value-p" style="color: #25ae5f;"><i class="fas fa-caret-up caret"></i>'+value.btperc+' %</span>';
                            ranker += '</div>';
                            ranker += '</div>';
                        ranker += '</li>';
                        $(".ranks .othersect").append(ranker);
                    }
                } else {
                    if(value.myrank > 5){
                        if(value.btperc > 0){
                            hwmyrank = '#25ae5f;';
                            hwmyrankside = 'fa-caret-up';
                        }else{
                            hwmyrank = '#e64c3c;';
                            hwmyrankside = 'fa-caret-down';
                        }
                        var ranker = '<li>'
                            ranker += '<div class="hudbadge"><span class="my_rank-number">'+value.myrank+'</span><img src="/wp-content/themes/arbitrage-child/images/top0.svg" alt=""></div>'
                            // ranker += '<div class="hudbadge">'+value.myrank+'</div>'
                            ranker += '<div class="playerscontent">'
                            ranker += '<div class="isname" style="width: 120px;">'+value.displayname+'</div>'
                            ranker += '<span class="profit_loss" style="color: #24a65d;float: right;position: absolute;top: 4px;width: 95%;text-align: right;font-size: 13px;"> ₱ '+value.bttotal+'</span>';
                            ranker += '<div class="istotal">';
                            ranker += '<span class="value-t"> ₱ '+value.bttotal+'</span>';
                            ranker += '<span class="value-p" style="color: '+ hwmyrank +'"><i class="fas '+ hwmyrankside +' caret"></i>'+value.btperc+' %</span>';
                            ranker += '</div>';
                            ranker += '</div>';
                        ranker += '</li>';
                        $(".ranks .myrank").append(ranker);
                    }

                }

            });
            $(".ranks .trendingpreloader").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {

        }
    });


});
