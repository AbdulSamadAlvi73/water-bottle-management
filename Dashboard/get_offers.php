<?php
include("../conn.php");

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    $sql = "SELECT * FROM offers WHERE product_id = $product_id";
    $result = mysqli_query($conn, $sql);
    
    $options = '<option selected disabled>Select Offer</option>';
    while ($offerdata = mysqli_fetch_assoc($result)) {
        $options .= "<option value=\"" . $offerdata['offer'] . "\">" . $offerdata['offer'] . "</option>";
    }
    echo $options;
}
?>
