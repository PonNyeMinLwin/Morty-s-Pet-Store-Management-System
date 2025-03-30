<?php
    // Starting the session
    session_start();

    if(!isset($_SESSION['user'])) header('location: index.php');
    $user = $_SESSION['user'];

    // Getting pie chart data - product order status relation
    include('database/get-order-status-data.php');

    // Getting bar chart data - supplier product (stock amount) relation
    include('database/get-supplier-product-data.php');
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
                    <div class="dashBoardContentMainBody">
                        <div class="contentSections">
                            <figure class="pieChart">
                                <div id="pieChartContainer"></div>
                                <p class="pieChartDescription"></p>
                            </figure>
                        </div>
                        <div class="contentSections">
                            <figure class="pieChart">
                                <div id="barChartContainer"></div>
                                <p class="pieChartDescription"></p>
                            </figure>
                        </div>      
                    </div>
                </div>
            </div>
        </div>
        
        <script src="js/script.js"></script>
        
        // These are 3rd party libraries and scripts used in this project to create the pie chart and other functionalities

        // Highcharts Library for Creating Charts 
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script>
            var graphData = <?= json_encode($result_list) ?>;

            // Build the chart 
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
            
            var supplierData = <?= json_encode($categories) ?>; 
            var productData = <?= json_encode($products) ?>; 
            var productCountData = <?= json_encode($product_count) ?>; 

            var seriesData = supplierData.map((supplier, index) => {
                return {
                    name: supplier,
                    data: productCountData[index] 
                };
            });
            

            Highcharts.chart('barChartContainer', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Supplier Product (Stock Count) Relation'
                },
                xAxis: {
                    categories: productData,
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Units'
                    }
                },
                toolTip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y} units</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Stock',
                    data: productCountData
                }]
            });
        </script>
    </body>
</html>