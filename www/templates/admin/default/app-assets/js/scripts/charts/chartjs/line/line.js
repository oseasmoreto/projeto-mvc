/*=========================================================================================
    File Name: line.js
    Description: Chartjs simple line chart
    ----------------------------------------------------------------------------------------
    Item Name: Chameleon Admin - Modern Bootstrap 4 WebApp & Dashboard HTML Template + UI Kit
    Version: 1.2
    Author: ThemeSelection
    Author URL: https://themeselection.com/
==========================================================================================*/

// Line chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#line-chart");
 var lbls = '';
 var serie = '';
 $.getJSON("/admin/home/valuescollection" + $('#idhome').val(), function (data) {
     lbls = data.labels;
     serie = data.series;

     var chartOptions = {
         responsive: true,
         maintainAspectRatio: false,
         legend: {
             position: 'bottom',
         },
         hover: {
             mode: 'label'
         },
         scales: {
             xAxes: [{
                 display: true,
                 gridLines: {
                     color: "#f3f3f3",
                     drawTicks: false,
                 },
                 scaleLabel: {
                     display: true,
                     labelString: 'Coleções'
                 }
             }],
             yAxes: [{
                 display: true,
                 gridLines: {
                     color: "#f3f3f3",
                     drawTicks: false,
                 },
                 scaleLabel: {
                     display: true,
                     labelString: 'Porcentagem'
                 }
             }]
         },
         title: {
             display: false,
             text: ''
         }
     };

     // Chart Data
     var chartData = {
         labels: lbls,
         datasets: [{
             label: "Vs ano passado %",
             data: serie,
             lineTension: 0,
             fill: false,
             borderColor: "#FF7D4D",
             pointBorderColor: "#FF7D4D",
             pointBackgroundColor: "#FFF",
             pointBorderWidth: 2,
             pointHoverBorderWidth: 2,
             pointRadius: 4,
         }]
     };

     var config = {
         type: 'line',

         // Chart Options
         options: chartOptions,

         data: chartData
     };

     // Create the chart
     var lineChart = new Chart(ctx, config);
 });
    // Chart Options
    
});