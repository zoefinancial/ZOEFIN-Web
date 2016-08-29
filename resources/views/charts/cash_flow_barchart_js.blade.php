$(document).ready(function() {
$.ajax({
url: "/user/cash_flow"
}).then(function(ajaxData) {
var entry;
var year;
var count;

var level2;
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
backgroundColor: colors[count%6],
borderColor: colors[count%6],
pointColor: colors[count%6],
pointStrokeColor: "#c1c7d1",
pointHighlightFill: "#fff",
pointHighlightStroke: "rgba(220,220,220,1)",
data: data
};
dataSets.push(dataset);
count++;
}

var ctx = $("#cashFlowChart").get(0).getContext("2d");
// var ctxTemp = document.getElementById("graphTest").getContext("2d");
var chartData = {
labels: dataLabels,
datasets: dataSets
};

var barChart = new Chart(ctx, {
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
});

});
});