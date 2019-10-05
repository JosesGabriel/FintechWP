<script>
	var loadwatctlist = function(userid){
		$.ajax({
			url: "/wp-json/watchlist-api/v1/watchlists?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
                console.log(data);
                
                let watchtoadd = '';

                $.each(data.data, function(key, value){
                    watchtoadd += '<li class="watchonlist" data-dstock="'+value.stockname+'" data-dhisto="null">';
                    watchtoadd += '<div class="row">';
                    watchtoadd += '<div class="wlttlstockvals">';
                    watchtoadd += '<div class="stocknn">'+value.stockname+'</div>';
                    watchtoadd += '<div class="s_dropdown" style="display: inline-block;">';
                    watchtoadd += '<select class="editwatchlist" name="editstock" id="" data-space="'+value.stockname+'"><option value="select" hidden=""></option><option value="delete">Delete</option>';
                    watchtoadd += '<option value="edit" data-stock="'+value.stockname+'" data-entry="'+value.dconnumber_entry_price+'" data-tp="'+value.dconnumber_take_profit_point+'" data-sl="'+value.dconnumber_stop_loss_point+'">Edit</option></select>';
                    watchtoadd += '</div>';
                    watchtoadd += '<div class="dpricechange">';
                    watchtoadd += ' <div class="curprice_'+value.stockname+'">₱'+value.last+'</div>';
                    watchtoadd += '<div class="curchange_'+value.stockname+'" style="color:#FFC107;">'+value.change+'</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '<div class="col-md-12">';
                    watchtoadd += '<div class="dchart">';
                    watchtoadd += '<div class="chartjs">';
                    watchtoadd += '<div id="chart_div_'+value.stockname+'" class="chart"></div>';
                    watchtoadd += '<div class="minichartt">';
                    watchtoadd += '<a href="/chart/'+value.stockname+'" target="_blank" class="stocklnk"></a>';
                    watchtoadd += '<div ng-controller="minichartarb'+value.stockname+'" class="ng-scope">';
                    watchtoadd += '<nvd3 options="options" data="data" class="with-3d-shadow with-transitions ng-isolate-scope"></nvd3>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '<input type="hidden" class="minchart_'+value.stockname+'" id="minchart_'+value.stockname+'" name="minchart_'+value.stockname+'" autocomplete="off">';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '</div>';
                    watchtoadd += '<div class="dparams">';
                    watchtoadd += '<ul>';
                    if(value.dconnumber_entry_price != ""){
                        watchtoadd += '<li>';
                        watchtoadd += '<div class="dcondition">Entry Price</div>';
                        watchtoadd += '<div class="dvalue"><span class="ontoleft">'+value.dconnumber_entry_price+'</span></div>';
                        watchtoadd += '</li>';
                    }
                    if(value.dconnumber_take_profit_point != ""){
                        watchtoadd += '<li>';
                        watchtoadd += '<div class="dcondition">Take Profit</div>';
                        watchtoadd += '<div class="dvalue"><span class="ontoleft">'+value.dconnumber_take_profit_point+'</span></div>';
                        watchtoadd += '</li>';
                    }
                    if(value.dconnumber_stop_loss_point != ""){
                        watchtoadd += '<li>';
                        watchtoadd += '<div class="dcondition">Stop Loss</div>';
                        watchtoadd += '<div class="dvalue"><span class="ontoleft">'+value.dconnumber_stop_loss_point+'</span></div>';
                        watchtoadd += '</li>';
                    }
                    watchtoadd += '</ul>';
                    watchtoadd += '</div>';
                    watchtoadd += '</li>';
                });
                $(".watcherlist > ul").append(watchtoadd);
                

            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
		});
    }
    
    $( document ).ready(function() {
        jQuery('.watcherlist > ul').on('change', 'select.editwatchlist', function(e) {
            console.log($(this).val() );
            if($(this).val() == 'delete'){
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                            'Deleted!',
                            'Your Watchlist has been deleted.',
                            'success'
                        ).then((result) => {
                            var ditemtoremove = jQuery(this).attr('data-space');
                            window.location.href = "/watchlist/?remove="+ditemtoremove;
                        });
                    }
                });

                $("div.editwatchlist select").val("Select");
            }else if($(this).val() == 'edit'){
                // var ditemtoedit = jQuery(this).attr('data-space');
                // jQuery("#edit_" + ditemtoedit).click();

                let entry = $(this).find(':selected').data('entry');
                let tp = $(this).find(':selected').data('tp');
                let sl = $(this).find(':selected').data('sl');
                let stock = $(this).find(':selected').data('stock');

                $("#editstockmodal input[name='dconnumber_entry_price']").val(entry);
                $("#editstockmodal input[name='dconnumber_take_profit_point']").val(tp);
                $("#editstockmodal input[name='dconnumber_stop_loss_point']").val(sl);
                $("#editstockmodal input[name='stockname']").val(stock);
                $("#editstockmodal").modal('toggle');
                
            }
        });

        new loadwatctlist(<?php echo $user->ID; ?>);
    });


</script>