<script>
    $(document).ready(
            function() {
                $.ajax({
                    url: "{{ $url }}"
                }).then(function(ajaxData) {
                    var entry;

                    var name;

                    var dataValues=[];
                    var dataLabels=[];

                    entry = ajaxData['Investments'];

                    var colors=['rgba(75, 192, 192, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'];

                    for (name in entry) {
                        dataLabels.push(name);
                        dataValues.push(entry[name]);
                    }

                    var pieChartData = {
                        labels: dataLabels,
                        datasets: [
                            {

                                backgroundColor: colors,
                                borderColor: colors,
                                borderWidth: 1,
                                highlightFill: "rgba(220,220,0,1)",
                                highlightStroke: "rgba(0,220,220,1)",
                                data: dataValues
                            }
                        ]
                    };

                    var pieChartCanvas = $("#{{ $pie_canvas_id }}").get(0).getContext("2d");

                    $("#{{ $pie_canvas_id }}_loading").get(0).className="hidden";

                    new Chart(pieChartCanvas, {
                        type:'pie',
                        data : pieChartData,
                        options: {
                            barShowStroke: true,
                            scaleBeginAtZero : false,
                            scaleOverride: true,
                            responsive: true,
                            barBeginAtOrigin: true,
                            legend: {
                                display: false
                            },
                            indexLabel: "#percent%"
                        }
                    });

                    entry = ajaxData['Taxes Related Info'];

                    dataLabels=[];
                    dataValues=[];

                    for (name in entry) {
                        dataLabels.push(name);
                        dataValues.push(entry[name]);
                    }

                    var barChartData = {
                        labels: dataLabels,
                        datasets: [
                            {
                                label: "Net Worth",
                                backgroundColor: colors,
                                borderColor: colors,
                                borderWidth: 1,
                                highlightFill: "rgba(220,220,0,1)",
                                highlightStroke: "rgba(0,220,220,1)",
                                data: dataValues
                            }
                        ]
                    };

                    var barChartCanvas = $("#{{ $bar_canvas_id }}").get(0).getContext("2d");

                    new Chart(barChartCanvas, {
                        type:'bar',
                        data : barChartData,
                        options: {
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || 'Other';
                                        //var label = data.labels[tooltipItem.index];
                                        var value=data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                        return  datasetLabel +' : '+ humanReadableMoney(value,2);
                                    }
                                }
                            },
                            barShowStroke: true,
                            scaleBeginAtZero : false,
                            scaleOverride: true,
                            responsive: true,
                            barBeginAtOrigin: true,
                            legend: {
                                display: false
                            },
                            scales: {
                                yAxes: [
                                    {
                                        ticks: {
                                           callback: function(label, index, labels) {
                                                  return humanReadableMoney(label);
                                            }
                                        },
                                        scaleLabel: {
                                            display: true
                                        }
                                   }
                                ]
                            }
                        }
                    });
                });
            }
    );
</script>