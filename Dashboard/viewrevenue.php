<?php
include("../conn.php");
session_start();
if (isset($_SESSION['admin'])) {
    $query = "SELECT * FROM admin";
    $row = mysqli_query($conn, $query);

    // Query to fetch total sales
    $queryTotalSales = "SELECT SUM(subtotal) AS total_sales FROM order_items";
    $resultTotalSales = mysqli_query($conn, $queryTotalSales);
    $rowTotalSales = mysqli_fetch_assoc($resultTotalSales);
    $totalSales = $rowTotalSales['total_sales'];

    // Query to calculate sent, received, and pending bottles
    $queryBottles = "SELECT SUM(send_bottles) AS sent_bottles, SUM(received_bottles) AS received_bottles FROM order_items";
    $resultBottles = mysqli_query($conn, $queryBottles);
    $rowBottles = mysqli_fetch_assoc($resultBottles);
    $sentBottles = $rowBottles['sent_bottles'];
    $receivedBottles = $rowBottles['received_bottles'];
    $pendingBottles = $sentBottles - $receivedBottles;

    // Query to fetch customer details
    $queryCustomers = "SELECT customers.customer_id, customers.lastname AS customer_name, COUNT(order_items.customer_id) AS order_count 
    FROM customers 
    LEFT JOIN order_items ON customers.customer_id = order_items.customer_id 
    GROUP BY customers.customer_id, customers.lastname";
    $resultCustomers = mysqli_query($conn, $queryCustomers);
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Dashboard - Water Bottle</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="../../images/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
            rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="assets/css/style.css" rel="stylesheet">
        <style>
            .datatable-table th a {
                text-wrap: nowrap !important;
                color: #1CA3EC !important;
            }

            .datatable-table td {
                text-wrap: nowrap !important;
            }
        </style>
    </head>

    <body>

        <!-- ======= Header ======= -->
        <?php
        include('./header.php');
        ?>
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <?php
        include('./sidebar.php');
        ?>
        <!-- End Sidebar-->


        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="row">

                            <!-- Sales Card -->
                            <div class="col-xxl-4 col-sm-6 col-xs-12 col-md-3">
                                <div class="card info-card sales-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Bottle <span>| sent Bottles</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-cart"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>
                                                    <?php echo $sentBottles; ?>
                                                </h6>
                                                <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Sales Card -->
                            <div class="col-xxl-4 col-sm-6 col-xs-12 col-md-3">
                                <div class="card info-card sales-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Bottle <span>| Received Bottles</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-cart"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>
                                                    <?php echo $receivedBottles; ?>
                                                </h6>
                                                <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Sales Card -->
                            <div class="col-xxl-4 col-sm-6 col-xs-12 col-md-3">
                                <div class="card info-card sales-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Bottle <span>| Pending Bottles</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-cart"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>
                                                    <?php echo $pendingBottles; ?>
                                                </h6>
                                                <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Sales Card -->
                            <!-- Revenue Card -->
                            <div class="col-xxl-4 col-sm-6 col-xs-12 col-md-3">
                                <div class="card info-card revenue-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Revenue <span>| Total Sales</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-currency-dollar"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>
                                                    <?php echo $totalSales; ?>
                                                </h6>
                                                <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Revenue Card -->
                        </div>
                    </div>

                    <!-- Left side columns -->
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">View Revenue</h5>
                                    <!-- <p>Total Sales: $<?php echo $totalSales; ?></p> -->

                                    <!-- Display Bottle Metrics -->
                                    <!-- <p>Sent Bottles: <?php echo $sentBottles; ?></p>
    <p>Received Bottles: <?php echo $receivedBottles; ?></p>
    <p>Pending Bottles: <?php echo $pendingBottles; ?></p> -->
                                    <!-- Table with hoverable rows -->
                                    <table class="table table-hover datatable">
                                        <thead class="samad-dashborad-header">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th>Customer Name</th>
                                                <th>Orders Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_assoc($resultCustomers)) { ?>
                                                <tr>
                                                    <th scope="row">
                                                        <?php echo $row['customer_id'] ?>
                                                    </th>
                                                    <td>
                                                        <?php echo $row['customer_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['order_count']; ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <!-- End Table with hoverable rows -->

                                </div>
                            </div>

                        </div>
                    </div><!-- End Left side columns -->


                </div>
            </section>

        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <?php
        include('./footer.php');
        ?>
        <!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/chart.js/chart.umd.js"></script>
        <script src="assets/vendor/echarts/echarts.min.js"></script>
        <script src="assets/vendor/quill/quill.min.js"></script>
        <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
        <script src="assets/vendor/tinymce/tinymce.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>

    </body>

    </html>

    <?php

} else {
    header("location:../admin.php");
}
?>