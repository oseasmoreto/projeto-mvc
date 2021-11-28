/*=========================================================================================
    File Name: pie.js
    Description: Chartjs pie chart
    ----------------------------------------------------------------------------------------
    Item Name: Chameleon Admin - Modern Bootstrap 4 WebApp & Dashboard HTML Template + UI Kit
    Version: 1.2
    Author: ThemeSelection
    Author URL: https://themeselection.com/
==========================================================================================*/

// Pie chart
// ------------------------------
$(window).on("load", function(){

    var lbls = '';
    var serie = '';
    
    $.getJSON("/admin/home/monthcollection" + $('#idhome').val(), function (data) {
        lbls = data.label;
        serie = data.series;
        //Get the context of the Chart canvas element we want to select
        var ctx = $("#simple-pie-chart");

        // Chart Options
        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            responsiveAnimationDuration: 500,
        };
        //console.log(lbls[0])
        // Chart Data
        var chartData = {
          labels: lbls,
          datasets: [
            {
              label: "Fluxo de compra",
              data: serie,
              backgroundColor: ["#4a9b7e", "#56994d", "#18357e"]
            }
          ]
        };

        var config = {
            type: 'pie',

            // Chart Options
            options: chartOptions,

            data: chartData
        };

        // Create the chart
        var pieSimpleChart = new Chart(ctx, config);
    });
});