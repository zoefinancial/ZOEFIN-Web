<script>
    function load_{{ $canvas_id }}(url) {
        $.ajax({
            url: url
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
                'rgba(255, 159, 64, 0.5)'];

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
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: colors[count%colors.length],
                    borderColor: colors[count%colors.length],
                    pointColor: colors[count%colors.length],
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    pointBorderColor: colors[count%colors.length],
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: colors[count%colors.length],
                    pointHoverBorderColor: colors[count%colors.length],
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 20,
                    spanGaps: true,
                    data: data,
                    yAxisID: (percentage_format_indicators.contains(name)?"y-axis-percentage":"y-axis-usd")

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
                type:'line',
                data : chartData,
                options: {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || 'Other';
                                var value=data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                                if(currency_format_indicators.contains(datasetLabel)) {
                                    return datasetLabel + ' : ' + humanReadableMoney(value, 2);
                                }else if(percentage_format_indicators.contains(datasetLabel)){
                                    return datasetLabel + ' : ' + value+'%';
                                }else{
                                    return datasetLabel + ' : ' + humanReadableMoney(value, 2);
                                }

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
                    },scales:{
                        yAxes: [
                            {
                                scaleType: "linear",
                                id: "y-axis-usd",
                                display: true,
                                position: "left",
                                labelString: '$ 1K = $1.000 $ 1M = $ 1.000.000',
                                ticks: {
                                    callback: function(label, index, labels) {
                                        return humanReadableMoney(label);
                                    }
                                },gridLines:{
                                    display:false
                                }
                            },{
                                scaleType: "linear",
                                id: "y-axis-percentage",
                                display: true,
                                position: "right",
                                ticks: {
                                    callback: function(label, index, labels) {
                                        return label + '%';
                                    }
                                },gridLines:{
                                    display:false
                                }
                            }
                        ],
                        xAxes:[{
                            gridLines:{
                                display:false
                            }
                        }]
                    }
                }
            });
        });
    }
</script>