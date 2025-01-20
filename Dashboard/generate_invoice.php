<?php
// Fetch the item ID from the URL parameter
include("../conn.php");

if (isset($_GET['id'])) {   
    $item_id = $_GET['id'];

    // Fetch specific data for the invoice based on $item_id
    // Perform database query to get invoice data and format it into an invoice

    // Example:
    $query = "SELECT * FROM order_items WHERE items_id = $item_id";
    $result = mysqli_query($conn, $query);
    $invoice_data = mysqli_fetch_assoc($result);

    // Once you have the data, generate the invoice HTML/CSS here
    // For demonstration purposes, redirect to a page containing the invoice

    // Redirect to the page that generates the invoice
    header("Location: invoice_page.php?id=$item_id");
    exit();
} else {
    // Handle case where ID is not provided or invalid
    echo "Invalid item ID.";
}
?>
