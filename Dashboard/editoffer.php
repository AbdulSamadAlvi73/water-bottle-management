<?php 
include("../conn.php");

session_start();
if(isset($_SESSION['admin']))
{
  $query = "SELECT * FROM admin";
  $row = mysqli_query($conn,$query);


  $id=$_GET['id'];

  $sel="SELECT * FROM `offers` WHERE id='$id'";
  $res=mysqli_query($conn,$sel);
  $row=mysqli_fetch_array($res);

 if(isset($_POST['submit'])){
    $offer = $_POST['offer'];
    $product_id = $_POST['product_id'];
    $price = $_POST['price']; 

  $query = "UPDATE `offers` SET `offer`='$offer',`product_id`='$product_id',`price`='$price' WHERE `id`='$id'";
  $query_run = mysqli_query($conn, $query);

  if($query_run) {
      header('location:viewoffers.php');
  } else {
      echo "Update Unsuccessful";
  }
}
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

    <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Update Offer</h5>

            <!-- Vertical Form -->
            <form class="row g-3" action="#" method="POST" enctype="multipart/form-data">
            <div class="col-12">
                <label for="offer" class="form-label">Offer</label>
                <input type="text" class="form-control" id="offer" name="offer" value="<?php echo $row['offer']?>">
              </div>
              <div class="col-12">
                <label for="city" class="form-label">Product Name</label>
                <select name="product_id" id="product_id" class="form-select" >
                  <option selected disabled>Select Product</option>
                  <?php
                    $sql = "SELECT * FROM products"; 
                    $productname = mysqli_query($conn,$sql);
                      while ($productdata = mysqli_fetch_assoc($productname)) {
                          echo "<option value=\"" . $productdata['id'] . "\">" . $productdata['product_name']."</option>";
                      }
                  ?>
                </select>
              </div>
              <div class="col-12">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $row['price']?>">
              </div>
              <div class="text-center">
                <button type="submit" name="submit" class="btn samad-btn-color">Update</button>
              </div>
            </form><!-- Vertical Form -->

          </div>
        </div>


      </div>

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