<?php
    // Starting the session
    session_start();

    if(!isset($_SESSION['user'])) header('location: index.php');
    $user = $_SESSION['user'];

    // Getting pie chart data - product order status relation
    include('database/get-pie-chart-data.php');

    // Getting bar chart data - supplier product (stock amount) relation
    include('database/get-bar-chart-data.php');

    // Getting line chart data - supplier-transactions-history relation
    include('database/get-line-chart-data.php');
?>

<html>
    <head>
        <title>Dashboard - Morty's Pet Store Management System</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <script src="https://kit.fontawesome.com/65a31e3d12.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="dashBoardMainContainer">
            <?php include('prefabs/dashboard-sidebar.php') ?>
            <div class="dashBoardContentContainer" id="dashBoardContentContainer">
                <?php include('prefabs/dashboard-top-nav-bar.php') ?>
                <div class="dashBoardGraphBoardContent">
                    <div id="lineChartContainer"></div>  
                    <div class="dashBoardContentMainBody">
                        <div class="contentSections">
                            <figure class="barChart">
                                <div id="barChartContainer"></div>
                                <p class="barChartDescription"></p>
                            </figure>
                        </div>
                        <div class="contentSections">
                            <figure class="pieChart">
                                <div id="pieChartContainer"></div>
                                <p class="pieChartDescription"></p>
                            </figure>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
        
        <script src="js/script.js"></script>
        
        <!-- These are 3rd party libraries and scripts used in this project to create the pie chart and other functionalities -->

        <!-- Highcharts Library for Creating Charts -->
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script>
            var graphData = <?= json_encode($result_list) ?>;

            // Building the pie chart
            Highcharts.chart('pieChartContainer', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Stock Order Delivery Status'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y} orders</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: 'orders'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        borderWidth: 2,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b><br>{point.y} orders',
                            distance: 20
                        },
                    }
                },
                series: [{
                    name: 'Status',
                    colorByPoint: true,
                    data: graphData
                }]
            });
            
            var productData = <?= json_encode($products) ?>; // Product names
            var supplierSeries = <?= json_encode($supplier_series) ?>; // Supplier stock data

            // Calculating total stock for each product
            var totalStockData = productData.map((_, index) => {
                return supplierSeries.reduce((sum, series) => sum + series.data[index], 0);
            });

            // Building the grouped column chart
            Highcharts.chart('barChartContainer', {
                chart: {
                    type: 'column' // Use a column chart
                },
                title: {
                    text: 'Product Stock and Supplier Contribution'
                },
                xAxis: {
                    categories: productData, // Product names as categories
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Units in Stock'
                    }
                },
                tooltip: {
                    formatter: function () {
                        // Calculate the total stock for the hovered product
                        var productIndex = this.point.index;
                        var totalStock = totalStockData[productIndex];

                        // Return the custom tooltip content
                        return `
                            <b>Total Stock: ${totalStock} units</b><br/>
                            ${this.series.name}: ${this.y} units
                        `;
                    },
                    useHTML: true // Enable HTML in the tooltip
                },
                plotOptions: {
                    column: {
                        grouping: true, // Group columns by product
                        shadow: false,
                        borderWidth: 0
                    }
                },
                series: supplierSeries // Use the supplier series data
            });

            var lineData = <?= json_encode($line_x_values) ?>; 
            var lineValues = <?= json_encode($line_y_values) ?>; 
            
            console.log(lineData, lineValues); // Debugging output

            // Building the line chart
            Highcharts.chart('lineChartContainer', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Daily Stock Shipments Overview'
                },
                xAxis: {
                    categories: lineData
                },
                yAxis: {
                    title: { text: 'Product Qty (Units)' }
                },
                plotOptions: {
                    line: {
                        dataLabels: { enabled: false },
                        enableMouseTracking: true
                    }
                },
                series: [{
                    name: 'Supplier 1',
                    data: lineValues 
                }]
            });
        </script>
    </body>
</html>