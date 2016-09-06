<script>
$(document).ready(
    function() {
        $.ajax({
            url: "{{ $url }}"
            }).then(function(ajaxData) {
                var entry;
                var count;

                var name;

                var dataValues=[];
                var dataLabels=[];

                entry = ajaxData;
                count = 0;

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

                var ctx = $("#{{ $canvas_id }}").get(0).getContext("2d");


                new Chart(ctx, {
                    type:'pie',
                    data : pieChartData,
                    options: {
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var datasetLabel = data.labels[tooltipItem.index] || 'Other';
                                    var value=data.datasets[0].data[tooltipItem.index];
                                    return  datasetLabel + ' : '+humanReadableMoney(value);
                                }
                            }
                        },
                        barShowStroke: true,
                        scaleBeginAtZero : false,
                        scaleOverride: true,
                        responsive: true,
                        barBeginAtOrigin: true,
                        legend: {
                            display: true
                        }
                    }
                });
                $("#{{ $canvas_id }}_loading").get(0).className="hidden";
            });
        }
    );
</script>