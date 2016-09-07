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
                    backgroundColor: colors[count%colors.length],
                    borderColor: colors[count%colors.length],
                    pointColor: colors[count%colors.length],
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
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || 'Other';
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
                    },scales:{
                        yAxes: [{
                            labelString: '1K = $1.000 1M = 1.000.000',
                            ticks: {
                                callback: function(label, index, labels) {
                                    return humanReadableMoney(label);
                                }
                            },gridLines:{
                                display:false
                            }
                        }],
                        xAxes:[{
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