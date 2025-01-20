<?php
include("../conn.php");
session_start();
if(isset($_SESSION['admin']))
{
  $query = "SELECT * FROM admin";
  $row = mysqli_query($conn,$query);

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
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
  .datatable-table th a{
  text-wrap: nowrap !important;
  color: #1CA3EC !important;
}
.datatable-table td{
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

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
<div class="card">
  <div class="card-body">
    <h5 class="card-title">View Order Items</h5>

    <!-- Table with hoverable rows -->
    <table class="table table-hover datatable">
      <thead class="samad-dashborad-header">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Order Name</th>
          <th scope="col">Product Name</th>
          <th scope="col">Offer</th>
          <th scope="col">Order Date</th>
          <th scope="col">Received Bottles</th>
          <th scope="col">Sended Bottles</th>
          <th scope="col">Subtotal</th>
          <!-- <th scope="col">Delete</th> -->
        </tr>
      </thead>
      <tbody>
      <?php
        $query = "SELECT order_items.*, customers.lastname AS customer_name, products.product_name
        FROM order_items
        JOIN customers ON customers.customer_id = order_items.customer_id
        JOIN products ON products.id = order_items.product_id";
        $query_run = mysqli_query($conn,$query);
        while($row = mysqli_fetch_assoc($query_run)){
        ?>
       <tr>
          <th scope="row"><?php echo $row['items_id'] ?></th>
          <td><?php echo $row['customer_name'] ?></td>
          <td><?php echo $row['product_name'] ?></td>
          <td><?php echo $row['offer'] ?></td>
          <td><?php echo $row['orderdate'] ?></td>
          <td><?php echo $row['received_bottles'] ?></td>
          <td><?php echo $row['send_bottles'] ?></td>
          <td><?php echo $row['subtotal'] ?></td>
          <!-- <td class="text-center"><a href="./editorder.php?id=<?php echo $row['id']?>"><i class="bi bi-pencil-square text-primary"></i></a></td> -->
          <!-- <td class="text-center">
          <form action="./deletehotel.php" method="POST">
            <a href="deletehotel.php?delete=<?php echo $row['id'] ?>" name="delete"><i class="bi bi-trash3-fill text-danger"></i></a>
            </form>
          </td> -->
       </tr>
        <?php
        }
       ?>
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

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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

    }else{
      header("location:../admin.php");
    }
?>