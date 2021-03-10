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

$query = "SELECT * from customers WHERE id=".$_GET['id']." ";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)){
      $id               = $row['id'];
      $name             = $row['name'];
      $address          = $row['address'];
      $item             = $row['item'];
      $price            = $row['price'];
      $order_date             = $row['order_date'];
      $phone            = $row['phone'];
      $delivery         = $row['delivery'];
      $status           = $row['status'];
      $notes           = $row['notes'];
  }
  $num_rows = mysqli_num_rows($result);
} else{
  echo "<p class='lead'><em>No records were found.</em></p>";
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MyHome | Purchase Order #
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
          <span class="logo-mini"><b>I</b>MS</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>MD</b>JS</span>
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

        <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li><a href="New-Order.php"><i class="fa fa-plus"></i><span>New Order</span></a></li>
        <li><a href="Order-List.php"><i class="fa fa-bars"></i><span>Order List</span></a></li>
        <li><a href="customer-list.php"><i class="fa fa-users"></i><span>Customer</span></a></li>
        <!--
        <li><a href="Delivery-List.php"><i class="fa fa-truck"></i>Delivery List</a></li> 
        <li><a href="Product-List.php"><i class="fa fa-cubes"></i>Product List</a></li>
        <li><a href="Customer-List.php"><i class="fa fa-users"></i>Customer List</a></li>
      -->
        <li><a href="logout.php"><i class="fa fa-close"></i><span>Logout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

      <!-- =============================================== -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="header">
                <div class="col-xs-3">
                </div>
              </h2>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-3 invoice-col">
              <address>
                <strong>
                  <h2><?php echo $name; ?></h2>
                </strong>
                Contact No:
                  <?php echo $phone; ?>
                <br>Address: 
                <?php echo $address; ?>

              </address>
            </div>
            <!-- /.col -->

          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-bordered table-hover dataTable" id="#example2" role="grid" aria-describedby="example2_info">
                <thead>
                  <tr>
                    <th>Action</th>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Item</th>
                    <th>Price</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  require_once "config.php";
                  $query = "SELECT * from orders WHERE name = '$name' ORDER BY status";
                  $result = mysqli_query($link, $query) or die(mysqli_error($link));
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)){

                      $totalPrice  =  $row['price'];

                      echo "<tr>";
                      echo "<td>";
                                             echo "<a href='View-Order.php?id=". $row['id'] ."' title='View Order' data-toggle='tooltip'><span class='glyphicon glyphicon-share'></span></a>";

                                             //echo " &nbsp; <a href='order-delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash remove'></span></a>";
                                             
                      echo "</td>";
                      //echo "<td>" .$row['po_trans_id'] . "</td>";
                      //echo "<td>" . $row['delivery'] . "</td>";
                      echo "<td>" . $row['id'] . "</td>";
                                            if($row['status'] == "New Order"){
                                              echo "<td> <span class='label label-warning'>New Order</span> </td>";
                                            } elseif ($row['status'] == "Paid") {
                                                echo "<td> <span class='label label-success'>Paid</span> </td>";
                                            } elseif ($row['status'] == "Void") {
                                              echo "<td> <span class='label label-danger'>Void</span> </td>";
                                            } else {
                                              echo "<td> <span class='label label-default'>Error</span> </td>";
                                            }
                      echo "<td><pre>" . $row['item'] . "</pre></td>";
                      echo "<td>₱ " . number_format($totalPrice,2) . "</td>";


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
        
    <strong>Handcrafted with love. By <a href="mailto:vincentcachila@gmail.com?Subject=Hello%20Vince!">Vince Cachila</a>.</strong> All rights
    reserved 2019.
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
