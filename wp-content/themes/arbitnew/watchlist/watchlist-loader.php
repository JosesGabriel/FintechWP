<script>
	var loadwatctlist = function(userid){
		$.ajax({
			url: "/wp-json/journal-api/v1/liveportfolio?userid="+userid,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(data) {
            	

            },
            error: function (xhr, ajaxOptions, thrownError) {
                
            }
		});
	}


</script>