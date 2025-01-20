<?php

include("../conn.php");

if (isset($_GET['delete'])) {
    $getid = $_GET['delete'];

    // Check if there are associated records in order_items
    $check_query = "SELECT COUNT(*) AS count FROM order_items WHERE product_id = $getid";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result) {
        $row = mysqli_fetch_assoc($check_result);
        $item_count = $row['count'];

        if ($item_count > 0) {
            ?>
            <script>
                alert("This product is associated with orders. Delete associated records first.");
                window.history.back(); // Go back to the previous page
            </script>
            <?php
            exit(); // Stop further execution
        } else {
            // No associated records found, proceed with deletion
            $query_del = "DELETE FROM `products` WHERE `id` = $getid";
            $run_id = mysqli_query($conn, $query_del);

            if ($run_id) {
                header("location:viewproducts.php");
            } else {
                ?>
                <script>
                    alert("Some error occurred while deleting.");
                    window.history.back(); // Go back to the previous page
                </script>
                <?php
            }
        }
    } else {
        ?>
        <script>
            alert("Error checking associated records.");
            window.history.back(); // Go back to the previous page
        </script>
        <?php
    }
}

// include("../conn.php");
// if (isset($_GET['delete'])) {
//     $getid = $_GET['delete'];
//     $query_del = "DELETE FROM `products` WHERE `id` = $getid";
//     $run_id = mysqli_query($conn, $query_del);
//     if ($run_id) {
//       header("location:viewproducts.php");
//     } else {
//     ?>
//       <script>
//         alert("Some Error Occur In Deleting");
//       </script>
//   <?php
//     }
// }
  ?>