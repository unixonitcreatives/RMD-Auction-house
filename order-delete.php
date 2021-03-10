<?php
session_start();
require_once 'config.php';
$users_id = $_GET['id'];

$query = "DELETE from orders WHERE id='$users_id'";

$result = mysqli_query($link, $query) or die(mysqli_error($link));
if ($result){
	echo "<script>alert('Deleted Succesfully')</script>";
    header("Location: Order-List.php?alert='$users_id'");
}else {
    echo "Error deleting record: " . mysqli_error($link);
}


// Close connection
mysqli_close($link);
?>
