<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ $url }}"
        }).then(function(ajaxData) {
            var entry;
            var year;
            var count;

            var name;

            var dataSets=[];
            var dataLabels=[];

            entry = ajaxData;
            count = 0;

            var colors=['rgba(75, 192, 192, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(0,0,0, 0.5)',
            ];

            for (name in entry) {
                var data=[];
                var values = entry[name];

                for (year in values){
                    data.push(values[year]);
                    if(count==0){
                        dataLabels.push(year);
                    }
                }
                var dataset={
                    label: name,
                    backgroundColor: colors[count%7],
                    borderColor: colors[count%7],
                    pointColor: colors[count%7],
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: data
                };
                dataSets.push(dataset);
                count++;
            }

            var ctx = $("#{{ $canvas_id }}").get(0).getContext("2d");

            $("#{{ $canvas_id }}_loading").get(0).className ="hidden";
            var chartData = {
                labels: dataLabels,
                datasets: dataSets
            };

            new Chart(ctx, {
                type:'bar',
                data : chartData,
                options: {
                    scales: {
                        xAxes: [{
                            stacked: true,
                            scaleLabel: {
                                display: true,

                            },
                            gridLines:{
                                display:false
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            labelString: '1K = $1.000 1M = 1.000.000',
                            ticks: {
                                callback: function(label, index, labels) {
                                    return humanReadableMoney(label);
                                }
                            },
                            gridLines:{
                                display:false
                            }
                        }]
                    }
                }

            });

        });
    });
</script>