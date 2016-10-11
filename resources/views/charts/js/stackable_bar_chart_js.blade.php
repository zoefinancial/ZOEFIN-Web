<script>
    function load_{{ $canvas_id }}(url){
        var pieChartContent = document.getElementById('{{ $canvas_id }}_container');
        pieChartContent.innerHTML = '';
        $('#{{ $canvas_id }}_container').append('<canvas id="{{ $canvas_id }}" style="padding-left:10px; padding-right:10px; height: 400px;"></canvas>');
        $("#{{ $canvas_id }}_loading").get(0).className ="fa fa-spinner fa-pulse fa-fw";

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

            var allNames=[];
            var allValues=[];

            for (x in entry){
                val = entry[x];
                allValues[x]=[];
                for (y in entry[x]){
                    allNames[y]=y;
                    allValues[x][y]=val[y];
                }
            }

            for(v in allValues){
                for(n in allNames){
                    if(!( n in allValues[v])){
                        allValues[v][n]=0;
                    }
                }
            }

            allNames.sort();

            for (name in allValues) {
                var data=[];
                var values = allValues[name];

                for (year in allNames){
                    data.push(values[year]);
                    if(count==0){
                        dataLabels.push(year);
                    }
                }
                var dataset;

                @if(!isset($showTotal) || (isset($showTotal)&&$showTotal='true'))
                    if(name=='Total'){
                        dataset={
                            type:'line',
                            fill: false,
                            label: name,
                            @if(isset($showTotalLine))
                                    @if($showTotalLine!='true')
                            showLine:false,
                            @endif
                                    @endif
                            backgroundColor: colors[count%colors.length],
                            borderColor: colors[count%colors.length],
                            pointColor: colors[count%colors.length],
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: data,
                        };
                    }else{
                        dataset={
                            type:'bar',
                            label: name,
                            backgroundColor: colors[count%7],
                            borderColor: colors[count%7],
                            pointColor: colors[count%7],
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: data
                        };
                    }
                @else
                    if(name=='Total'){

                    }else{
                        dataset={
                            type:'bar',
                            label: name,
                            backgroundColor: colors[count%7],
                            borderColor: colors[count%7],
                            pointColor: colors[count%7],
                            pointStrokeColor: "#c1c7d1",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: data
                        };
                    }
                @endif
                dataSets.push(dataset);
                count++;
            }

            var ctx = $("#{{ $canvas_id }}").get(0).getContext("2d");


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
                                var datasets=data.datasets;
                                var total=0;
                                for(d in datasets){
                                    total=total+datasets[d].data[tooltipItem.index];
                                }
                                return  datasetLabel +' : '+ humanReadableMoney(value) ;
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            stacked: true,
                            scaleLabel: {
                                display: true,
                            },
                            gridLines:{
                                display:false
                            },
                            display:{{ $showXAxis or 'true' }},
                        }],
                        yAxes: [{
                            stacked: true,
                            labelString: '1K = $1,000 1M = 1,000,000',
                            ticks: {
                                callback: function(label, index, labels) {
                                    return humanReadableMoney(label);
                                }
                            },
                            gridLines:{
                                display:false
                            }
                        }]
                    },legend:{
                        display:{{ $showLegend or 'true' }}
                    }
                }
            });
            $("#{{ $canvas_id }}_loading").get(0).className ="hidden";
        })
    }
</script>