
var getCurrentAllocation = function(userid){
    $.ajax({
        url: "/wp-json/journal-api/v1/currentallocation?userid="+userid,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(data) {
            console.log(data);

            AmCharts.makeChart("chartdiv4a", {
                "type": "pie",
                "startDuration": 0,
                "sequencedAnimation": false,
                "theme": "none",
                "marginBottom": 0,
                "marginTop": 0,
                "marginLeft": 0,
                "marginRight": 0,
                "labelsEnabled": false,
                "addClassNames": true,
                "fontFamily": "Roboto",
                "fontSize": 11,
                "color": "#d8d8d8",
                "innerRadius": "50%",
                "colors": [
                  "#00E676",
                  "#ff1744"
                ],
                "defs": {
                  "filter": [{
                    "id": "shadow",
                    "width": "200%",
                    "height": "200%",
                    "feOffset": {
                      "result": "offOut",
                      "in": "SourceAlpha",
                      "dx": 0,
                      "dy": 0
                    },
                    "feGaussianBlur": {
                      "result": "blurOut",
                      "in": "offOut",
                      "stdDeviation": 5
                    },
                    "feBlend": {
                      "in": "SourceGraphic",
                      "in2": "blurOut",
                      "mode": "normal"
                    }
                  }]
                },
                "dataProvider": [{
                  "stats": "Win",
                  "vals": 11
                }, {
                  "stats": "Losses",
                  "vals": 2
                }],
                "valueField": "vals",
                "titleField": "stats",
                "export": {
                  "enabled": false
                }
              });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            
        }
    });
}