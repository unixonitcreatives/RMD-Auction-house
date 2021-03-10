<!DOCTYPE html>
<html>
<body>

<?php
$q = intval($_GET['q']);

$con = mysqli_connect('remotemysql.com','nCJRDnImYY','xxkEtqxKCr','nCJRDnImYY');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"db");
$sql="SELECT * FROM customers WHERE name = '". urldecode($q) ."'";
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['phone'] . "</td>";
    echo "<td>" . $row['address'] . "</td>";