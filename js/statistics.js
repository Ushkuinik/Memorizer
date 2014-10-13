$(document).ready(function() {
    "use strict";

    updateStatistics();
});

function updateStatistics() {

    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: {command: "getStatistics"},
        success: function(data) {
            console.log('data: ' + data);

            var object = jQuery.parseJSON(data);
            $('#result').html(alertResult(object.code, object.message, object.sql));
            if(parseInt(object.code) == 0) {

                var statistics = object.statistics;
                var i = 0;
                var data = [];
                for(var s in statistics) {
                    data[i++] = {
                        label: statistics[i]['code'],
                        data: statistics[i]['count']
                    }
                }

                $.plot('#graph1', data, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            innerRadius: 0.5,
                            label: {
                                show: true,
                                radius: 0.75,
                                formatter: labelFormatter,
                                threshold: 0.1
                            }
                        }
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        hoverable: true,
                        clickable: true
                    }
                });
            }
        },
        error: function(request, status, error) {
            alert(request.responseText);
        }
    });

    return false;
}

function labelFormatter(label, series) {
    return "<div style='font-size:10pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + series.data[0][1] + "</div>";
}

