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
            $("#{{ $canvas_id }}_loading").get(0).className="hidden";
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
                        responsive: true,
                        barBeginAtOrigin: true,
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        callback: function(label, index, labels) {
                                            return '$' + label.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                            //return label/1000 + 'k'
                                        }
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'USD'
                                        //labelString: '1k = $1000'
                                    }
                                }
                            ]
                        },
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