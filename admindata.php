<?php
session_start();
require('./conn');
$email = $_POST['email'];
$pass = $_POST['pass'];

$query = "SELECT * FROM admin Where email = '$email' AND password = '$pass'";
$row = mysqli_query($conn,$query);
$data = mysqli_fetch_assoc($row);
if($data){

    $_SESSION['admin'] = $data['name'];
    header('location:Dashboard/index.php?session='.$_SESSION['admin']);

}else{
    header('locaotion:./admin.php');
}

?>