$(document).ready(
    function() {
        $.ajax(
            {
                url: "{{ $url }}"
            }
        ).then(function(ajaxData) {
            var entry;
            var name;
            var count;

            var dataLabels=[];
            var dataValues=[];

            entry = ajaxData;

            count = 0;

            for (name in entry) {
                dataLabels.push(name);
                dataValues.push(entry[name]);
            }

            var ctx = $("#{{ $canvas_id }}").get(0).getContext("2d");

            var chartData = {
                labels: dataLabels,
                    datasets: [
                        {
                            label: "Net Worth",
                            backgroundColor: [
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)'
                            ],
                            borderColor: [
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1,
                            highlightFill: "rgba(220,220,0,1)",
                            highlightStroke: "rgba(0,220,220,1)",
                            data: dataValues
                        }
                    ]
                };

            var barChart = new Chart(
                ctx,{
                    type:'bar',
                    data : chartData,
                    options: {
                        barShowStroke: true,
                        scaleBeginAtZero : false,
                        scaleOverride: true,
                        responsive: true,
                        barBeginAtOrigin: true,
                        legend: {
                            display: false
                        }
                    }
                }
            );
            }
        );
    }
);