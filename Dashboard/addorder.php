<?php
include("../conn.php");

session_start();
if (isset($_SESSION['admin'])) {
  $query = "SELECT * FROM admin";
  $row = mysqli_query($conn, $query);


  if (isset($_POST['submit'])) {
    $customer_id = $_POST['customer_id'];
    $order_date = $_POST['order_date'];
    $total_amount = $_POST['total_amount'];
    $status = $_POST['status'];

    $query = "INSERT INTO `orders` (`customer_id`, `order_date`,  `total_amount`, `status`) VALUES ('$customer_id', '$order_date', '$total_amount', '$status')";
    $query_run = mysqli_query($conn, $query);
    header("location:./vieworders.php");
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
            <h5 class="card-title">Add Order</h5>

            <!-- Vertical Form -->
            <form class="row g-3" action="#" method="POST" enctype="multipart/form-data">
             
              <div class="col-md-6 col-sm-12">
                <label for="customer_id" class="form-label">Customer Name</label>
                <select name="customer_id" id="customer_id" class="form-select" oninput="getSelectedOption()">
                  <option selected disabled>Select Customer</option>
                  <?php
                  $sql = "SELECT customers.*, order_items.subtotal
                  FROM customers
                  LEFT JOIN order_items ON customers.customer_id = order_items.customer_id";
                  $row = mysqli_query($conn, $sql);
                  while ($data = mysqli_fetch_assoc($row)) {
                    echo "<option value=\"" . $data['customer_id'] . "\">" . $data['firstname'] ." - ". $data['email'] ." - ". $data['phone_number'] ." - ". " ( ". $data['subtotal']." ) " . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6 col-sm-12">
                <label for="searchCustomer" class="form-label">Search Customer</label>
                <input type="text" class="form-control" id="searchCustomer" onkeyup="filterCustomers()" oninput="getSelectedOption()"
                  placeholder="Search by name, email, or phone">
              </div>
              <div class="col-12">
                <label for="date" class="form-label">Current Order Date</label>
                <input type="date" class="form-control" id="date" name="order_date" readonly>
              </div>
              <div class="col-12">
                <label for="total_amount" class="form-label">Total Amount</label>
                <input type="text" class="form-control" id="total_amount" name="total_amount" readonly>
              </div>
              <div class="col-12">
                <label for="" class="form-label">Status</label>
                <select class="form-select" name="status" id="Status">
                  <option value="Delivered" selected>Delivered</option>
                  <option value="Processing">Processing</option>
                  <option value="Shipped">Shipped</option>
                </select>
              </div>
              <div class="text-center">
                <button type="submit" class="btn samad-btn-color" name="submit">Add</button>
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

    <script>
      function getSelectedOption() {
        // Get the select element
        var selectElement = document.getElementById("customer_id");

        // Get the index of the selected option
        var selectedIndex = selectElement.selectedIndex;

        // Get the text content of the selected option
        var selectedOptionText = selectElement.options[selectedIndex].innerText;

        // Log or use the selected option text
        let str = selectedOptionText;
        let start = str.indexOf('(') + 1; // Find the index of '('
        let end = str.indexOf(')'); // Find the index of ')'
        let valueInsideParentheses = str.substring(start, end); // Extract the value between '(' and ')'
        console.log(valueInsideParentheses);

        let total_amount = document.getElementById("total_amount");
        // // let price =parseInt(valueInsideParentheses);
        total_amount.value =valueInsideParentheses ;

      }
    
    </script>

    <script>
      function setDefaultDate() {
        // Get today's date
        let today = new Date();

        // Format the date to YYYY-MM-DD (required for input type="date")
        let formattedDate = today.toISOString().split('T')[0];

        // Set the default value for the order_date input field
        document.getElementById('date').value = formattedDate;
      };
      setDefaultDate();
    </script>


    <script>
      function filterCustomers() {
        // Declare variables
        let input, filter, select, option, txtValue;
        input = document.getElementById('searchCustomer');
        filter = input.value.toUpperCase();
        select = document.getElementById('customer_id');
        option = select.getElementsByTagName('option');

        // Loop through all option elements
        for (let i = 0; i < option.length; i++) {
          txtValue = option[i].textContent || option[i].innerText;
          let customerInfo = txtValue.toUpperCase();

          // Check if customerInfo includes the filter text
          if (customerInfo.includes(filter)) {
            option[i].style.display = '';
            option[i].selected = true;
            // Automatically select the matching option
        
          } else {
            option[i].style.display = 'none';
          }
        }
      }
    </script>

  </body>

  </html>

  <?php

} else {
  header("location:../admin.php");
}
?>