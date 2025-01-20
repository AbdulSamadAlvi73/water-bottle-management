<?php
include("../conn.php");

session_start();
if (isset($_SESSION['admin'])) {
  $query = "SELECT * FROM admin";
  $row = mysqli_query($conn, $query);


  if (isset($_POST['submit'])) {
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $offer = $_POST['offer'];
    $orderdate = $_POST['orderdate'];
    $send_bottles = $_POST['send_bottles'];
    $subtotal = $_POST['subtotal'];
    $received_bottles = $_POST['received_bottles'];
    echo $query = "INSERT INTO `order_items` (`customer_id`, `product_id`,`offer`, `orderdate`,`send_bottles`, `subtotal`,`received_bottles`) VALUES ('$customer_id', '$product_id','$offer','$orderdate', '$send_bottles', '$subtotal','$received_bottles')";

    $query_run = mysqli_query($conn, $query);
    header("location:./vieworderitems.php");
  }


  if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    $sql = "SELECT * FROM offers WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);

    $options = '<option selected disabled>Select Offer</option>';
    while ($offerdata = mysqli_fetch_assoc($result)) {
      $options .= "<option value=\"" . $offerdata['id'] . "\">" . $offerdata['offer'] . "</option>";
    }
    echo $options;
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



      <!-- Recent Sales -->
      <div class="col-12" id="col12">
        <div class="card recent-sales overflow-auto">

          <div class="card-body">
            <h5 class="card-title">Search Customers</h5>
            <table class="table table-borderless datatable" id="grid">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">First Name</th>
                  <th scope="col">Last Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Phone Number</th>
                  <th scope="col">Address</th>
                  <th scope="col">Product</th>
                  <th scope="col">Select</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = "SELECT customers.*,products.product_name from customers
                JOIN products ON products.id = customers.product_id";
                $query_run = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($query_run)) {
                  ?>
                  <tr class="position-relative">
                    <th scope="row">
                      <?php echo $row['customer_id'] ?>
                    </th>
                    <td>
                      <?php echo $row['firstname'] ?>
                    </td>
                    <td>
                      <?php echo $row['lastname'] ?>
                    </td>
                    <td>
                      <?php echo $row['email'] ?>
                    </td>
                    <td>
                      <?php echo $row['phone_number'] ?>
                    </td>
                    <td>
                      <?php echo $row['address'] ?>
                    </td>
                    <td>
                      <?php echo $row['product_name'] ?>
                    </td>
                    <td>
                      <button
                        onclick="selectcustomer('<?php echo $row['customer_id'] ?>', '<?php echo $row['lastname'] ?>', '<?php echo $row['product_id'] ?>')"
                        class="btn btn-primary btn-sm">Select</button>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>

          </div>

        </div>
      </div><!-- End Recent Sales -->



      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Add Order Items</h5>

            <!-- Vertical Form -->
            <form class="row g-3" action="#" method="POST" enctype="multipart/form-data">
              <div class="col-md-12 col-sm-12">
                <label for="customer" class="form-label">Customer Name</label>
                <input type="number" style="display:none;" hidden readonly class="form-control" id="selectcustomerId"
                  name="customer_id">
                <input type="text" class="form-control" readonly id="selectcustomerName">
              </div>
              <div class="col-12">
                <label for="product" class="form-label">Product Name</label>
                <select name="product_id" id="product_id" class="form-select">
                  <option selected disabled>Select Product</option>
                  <?php
                  $sql = "SELECT * FROM products";
                  $result = mysqli_query($conn, $sql);
                  while ($productdata = mysqli_fetch_assoc($result)) {
                    echo "<option value=\"" . $productdata['id'] . "\">" . $productdata['product_name'] . " - " . "(" . $productdata['price'] . ")</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-12">
                <label for="offers" class="form-label">Offers</label>
                <select name="offer" id="offer_id" class="form-select">
                  <option selected disabled>Select Offer</option>
                </select>
              </div>
              <!-- <div class="col-12">
                <label for="city" class="form-label">Product Name</label>
                <select name="product_id" id="product_id" class="form-select">
                  <option selected disabled>Select Product</option>
                  <?php
                  $sql = "SELECT * FROM products";
                  $row = mysqli_query($conn, $sql);
                  while ($productdata = mysqli_fetch_assoc($row)) {
                    echo "<option value=\"" . $productdata['id'] . "\">" . $productdata['product_name'] . " - " . "(" . $productdata['price'] . ")</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-12">
                <label for="city" class="form-label">Offers</label>
                <select name="product_id" id="product_id" class="form-select">
                  <option selected disabled>Select Offer</option>
                  <?php
                  $sql = "SELECT offers.*, products.product_name
                  FROM offers
                  JOIN products ON offers.product_id = products.id";
                  $row = mysqli_query($conn, $sql);
                  while ($offerdata = mysqli_fetch_assoc($row)) {
                    echo "<option value=\"" . $offerdata['id'] . "\">" . $offerdata['offer'] . "</option>";
                  }
                  ?>
                </select>
              </div> -->
              <div class="col-12">
                <label for="date" class="form-label">Current Order Date</label>
                <input type="date" class="form-control" id="date" name="orderdate">
              </div>
              <div class="col-12">
                <label for="received_bottles" class="form-label">Received Bottles</label>
                <input type="number" class="form-control" id="received_bottles" name="received_bottles"
                  oninput="getSelectedOption()">
              </div>
              <div class="col-12">
                <label for="send_bottles" class="form-label">Send Bottles</label>
                <input type="number" class="form-control" id="send_bottles" name="send_bottles"
                  oninput="getSelectedOption()">
              </div>
              <div class="col-12">
                <label for="subtotal" class="form-label">Sub Total</label>
                <input type="number" class="form-control" id="subtotal" name="subtotal" readonly>
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
      let grid = document.querySelector('#grid tbody');
      let inputSearch = document.querySelector('#col12 .datatable-search input');
      inputSearch.placeholder = "Search By Name, Email, Phone";
      grid.style.display = "none";
      inputSearch.addEventListener("keyup", () => {
        if (inputSearch.value != "") {
          grid.style.display = "table-row-group";
        } else {
          grid.style.display = "none";
        }
      })
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
      function getSelectedOption() {
        // Get the select element
        var selectElement = document.getElementById("product_id");

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

        let send_bottles = document.getElementById("send_bottles").value;
        let subtotal = document.getElementById("subtotal");
        // let price =parseInt(valueInsideParentheses);
        subtotal.value = send_bottles * valueInsideParentheses;

      }


    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      
      $(document).ready(function () {
        $('#product_id').change(function () {
          var product_id = $(this).val();
          $.ajax({
            url: 'get_offers.php', // Replace with the file that handles fetching offers based on product_id
            method: 'POST',
            data: { product_id: product_id },
            success: function (response) {
              $('#offer_id').html(response);
            }
          });
        });
      });
    </script>
  </body>

  </html>
  <?php

} else {
  header("location:../admin.php");
}
?>