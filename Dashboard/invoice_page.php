<?php
// Fetch the item ID from the URL parameter
include("../conn.php");

if (isset($_GET['id'])) {
   $item_id = $_GET['id'];

    // Fetch specific data for the invoice based on $item_id
    // Perform database query to get invoice data and format it into an invoice
        if ($item_id === "this_week") {
            // Logic to filter data for "This Week"
            // Perform your database query to get data for this week
            // For example:
            $query = "SELECT order_items.*, customers.firstname AS customer_name, products.product_name
            FROM order_items
            JOIN customers ON customers.customer_id = order_items.customer_id
            JOIN products ON products.id = order_items.product_id WHERE WEEK(order_items.orderdate) = WEEK(NOW()) AND YEAR(order_items.orderdate) = YEAR(NOW())";
            // Execute the query and fetch data
            $invoice_data = mysqli_query($conn, $query);
            
        } elseif ($item_id === "this_month") {
            // Logic to filter data for "This Month"
            // Perform your database query to get data for this month
            // For example:
            $query = "SELECT order_items.*, customers.firstname AS customer_name, products.product_name
            FROM order_items
            JOIN customers ON customers.customer_id = order_items.customer_id
            JOIN products ON products.id = order_items.product_id WHERE MONTH(order_items.orderdate) = MONTH(NOW()) AND YEAR(order_items.orderdate) = YEAR(NOW())";
            // Execute the query and fetch data
            $invoice_data = mysqli_query($conn, $query);
        } elseif ($item_id === "this_year") {
            // Logic to filter data for "This Year"
            // Perform your database query to get data for this year
            // For example:
            $query = "SELECT order_items.*, customers.firstname AS customer_name, products.product_name
            FROM order_items
            JOIN customers ON customers.customer_id = order_items.customer_id
            JOIN products ON products.id = order_items.product_id
            WHERE YEAR(order_items.orderdate) = YEAR(NOW())
            ";
            // Execute the query and fetch data
            $invoice_data = mysqli_query($conn, $query);
        }else{
    // Example query (update with your database connection)
    // $conn = mysqli_connect('localhost', 'username', 'password', 'database');
    $query = "SELECT order_items.*, customers.firstname AS customer_name, products.product_name
    FROM order_items
    JOIN customers ON customers.customer_id = order_items.customer_id
    JOIN products ON products.id = order_items.product_id
    WHERE order_items.items_id= $item_id";
    $query_run = mysqli_query($conn, $query);
    $invoice_data = mysqli_fetch_assoc($query_run);

    // Check if data exists and proceed to generate invoice
    if ($invoice_data) {
     
        
    } }
    // else {
    //     // Handle case where data for the provided ID is not found
    //     echo "No data found for this ID.";
    // }
} else {
    // Handle case where ID is not provided or invalid
    echo "Invalid item ID.";
}

?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>Water Bottle - Invoice</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                .invoice {
                    border-collapse: collapse;
                    width: 100%;
                }
                .invoice th, .invoice td {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }
                .invoice th {
                    background-color: #f2f2f2;
                }
            </style>
        </head>
        <body>
            <h1>Invoice</h1>
            <table class='invoice'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>offer</th>
                        <th>Subtotal</th>
                        <th>Order Date</th>
                        <!-- Add other invoice details here based on fetched data -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $invoice_data['items_id']; ?></td>
                        <td><?php echo $invoice_data['customer_name']; ?></td>
                        <td><?php echo $invoice_data['product_name']; ?></td>
                        <td><?php echo $invoice_data['offer']; ?></td>
                        <td><?php echo $invoice_data['subtotal']; ?></td>
                        <td><?php echo $invoice_data['orderdate']; ?></td>
                        <!-- Add other invoice data here based on fetched data -->
                    </tr>
                    <!-- Add more rows for additional details -->
                </tbody>
            </table>
            
            <script>
                // Automatically trigger print dialog when the page loads
                window.onload = function() {
                    window.print();
                };
            </script>
        </body>
        </html>
      