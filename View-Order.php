<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}

// Define variables and initialize with empty values
$name = $address = $item = $price = $date = $phone = $delivery = $status = "";

require_once "config.php";

$users_id = $_GET['id'];

$query = "SELECT * from items WHERE id=".$_GET['id']." ";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)){
      $id               = $row['id'];
      $name             = $row['sold_to'];
      //$address          = $row['address'];
      $item             = $row['item_name'];
      $price            = $row['price'];
      $order_date             = $row['date_released'];
      //$phone            = $row['phone'];
      //$delivery         = $row['delivery'];
      $status           = $row['item_status'];
      $notes           = $row['notes'];

  }
  $num_rows = mysqli_num_rows($result);
} else{
  echo "<p class='lead'><em>No records were found.</em></p>";
}

$query = "SELECT * from customers WHERE name ='$name' ";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)){
      $address          = $row['address'];
      $phone            = $row['phone'];

  }
  $num_rows = mysqli_num_rows($result);
} else{
  echo "<p class='lead'><em>No records were found.</em></p>";
}


                    
                  


if ($_SERVER["REQUEST_METHOD"] == "POST"){

  $query = "UPDATE orders SET status = 'Paid' WHERE id = '$users_id'";
  $approved = mysqli_query($link, $query) or die(mysqli_error($link));

  $showStatus = "<span class='label label-success'>Approved</span>";
  header("Location: order-list.php");


}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RMD | Purchase Order #
    <?php
    echo $users_id;
    ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
  <!-- the fixed layout is not compatible with sidebar-mini -->
  <body class="hold-transition skin-blue fixed sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">RMD</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>RMD</b> Auction House</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
        </nav>
      </header>

      <!-- =============================================== -->

      <?php include("template/sidebar.php"); ?>

      <!-- =============================================== -->
      
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="header">
                <div class="col-xs-3">
                  <img class="img-responsive" src="dist/img/logo-01.png">
                  <br>
                </div>
                <small class="pull-right">
                    <button onclick="window.history.back()" target="_blank" class="btn btn-default no-print" ><i class="fa fa-arrow-left">&nbsp;Back</i></button>
                    <button onclick="Print()" target="_blank" class="btn btn-default no-print" ><i class="fa fa-print">&nbsp;Print</i></button>
                </small>

              </h2>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-3 invoice-col">
              To
              <address>
                <strong>
                  <?php echo $name; ?>
                </strong>
                <br>Contact No:
                  <?php echo $phone; ?>
                <br>Address: 
                <?php echo $address; ?>

              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-3 invoice-col">
              From
              <address>
                <strong>RMD Auction House</strong><br>
                Address Here
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-3 invoice-col">
                Details
                <address>
                <b>Order &nbsp;</b>#
                  <?php
                  echo $users_id;
                  ?>

                <br>

                <b>Date:</b> 
                  <?php
                  echo $order_date;
                  ?>
             
                <br>
                <b>Status: &nbsp;</b><?php 
                if($status == "New Order"){
                                              echo "<td> <span class='label label-warning'>New Order</span> </td>";
                                            } elseif ($status == "Paid") {
                                                echo "<td> <span class='label label-success'>Paid</span> </td>";
                                            } elseif ($status == "Void") {
                                              echo "<td> <span class='label label-danger'>Void</span> </td>";
                                            } else {
                                              echo "<td> <span class='label label-default'>Error</span> </td>";
                                            } 
                ?></label>
              </address>

             
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-9 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Price</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  require_once "config.php";
                  $query = "SELECT * from items WHERE id= ".$_GET['id']."";
                  $result = mysqli_query($link, $query) or die(mysqli_error($link));
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)){

                      $totalPrice  =  $row['price'];

                      echo "<tr>";
                      //echo "<td>" .$row['po_trans_id'] . "</td>";
                      //echo "<td>" . $row['delivery'] . "</td>";
                      echo "<td>" . $row['item_name'] . "</td>";
                      echo "<td>" . $row['notes'] . "</td>";
                      echo "<td>??? " . number_format($totalPrice,2) . "</td>";

                      echo "</tr>";

                    }


                    // Free result set
                    mysqli_free_result($result);
                  } else{
                    echo "<p class='lead'><em>No records were found.</em></p>";
                  }

                  ?>


                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

  <!-- this row will not appear when printing -->
  <div class="row no-print">
    <div class="col-xs-12">


        </div>
      </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
  </div>

    <footer class="main-footer no-print">
      <?php include'template/footer.php'; ?>  
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<!-- page script -->
<script>
$(function () {
  $('#example1').DataTable()
  $('#example2').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : true,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false
  })
})
</script>
<!-- Alert animation -->
<script type="text/javascript">
$(document).ready(function () {

  window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
      $(this).remove();
    });
  }, 1000);

});
</script>
<script>
function Print() {
  window.print();
}
</script>
</body>
</html>
