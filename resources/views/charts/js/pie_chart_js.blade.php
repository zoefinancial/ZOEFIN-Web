<script>
    function load_{{ $canvas_id }}(url) {
        var pieChartContent = document.getElementById('{{ $canvas_id }}_container');
        pieChartContent.innerHTML = '';
        $('#{{ $canvas_id }}_container').append('<canvas id="{{ $canvas_id }}" style="padding-left:10px; padding-right:10px; height: 400px;"></canvas>');
        $("#{{ $canvas_id }}_loading").get(0).className ="fa fa-spinner fa-pulse fa-fw";

        $.ajax({
            url: url
        }).then(function (ajaxData) {
            var entry;

            var name;

            var dataValues = [];
            var dataLabels = [];

            entry = ajaxData;
            count = 0;


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
                        pointColor: colors,
                        borderWidth: 1,
                        highlightFill: "rgba(220,220,0,1)",
                        highlightStroke: "rgba(0,220,220,1)",
                        data: dataValues
                    }
                ]
            };

            var ctx = $("#{{ $canvas_id }}").get(0).getContext("2d");

            new Chart(ctx, {
                type: 'pie',
                data: pieChartData,
                options: {
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var datasetLabel = data.labels[tooltipItem.index] || 'Other';
                                var value = data.datasets[0].data[tooltipItem.index];
                                return datasetLabel + ' : ' + humanReadableMoney(value);
                            }
                        }
                    },
                    barShowStroke: true,
                    scaleBeginAtZero: false,
                    scaleOverride: true,
                    responsive: true,
                    barBeginAtOrigin: true,
                    legend: {
                        display: true
                    }
                }
            });
            $("#{{ $canvas_id }}_loading").get(0).className = "hidden";
        });
    }
</script>