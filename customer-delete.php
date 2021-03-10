<?php
session_start();
require_once 'config.php';
$users_id = $_GET['id'];
$cust = $_GET['name'];

$query = "DELETE from customers WHERE id='$users_id'";

$result = mysqli_query($link, $query) or die(mysqli_error($link));


if ($result){
    header("Location: customer-list.php?alert=deletesuccess");
}else {
    echo "Error deleting record: " . mysqli_error($link);
}


// Close connection
mysqli_close($link);
?>
