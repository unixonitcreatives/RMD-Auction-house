<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
                         
?>

<!DOCTYPE PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MDJS | Order List</title>
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
<!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-blue layout-fixed sidebar-mini">
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
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include'template/header-title.php'; ?> 

    <section class="content">
        <div class="row">
          <?php echo $alertMessage; ?>
          <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Order List</h3>
                        </div>

                        <div class="box-body">


                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="theform">
                            <div class="col-md-3">
                        <!-- form start -->
                           
                            <div class="form-group">
                              <label>Customer Name</label>
                              <input type="text" class="form-control" id="" maxlength="50" placeholder="Customer Name" name="name">
                            </div>

                             </div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Item</label>
                                      <input type="text" class="form-control" id="" placeholder="Item" name="item">
                                    </div>
                            </div>
                            <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Order Status</label>
                                      <select class="form-control" style="width: 100%;" name="status" name="status">
                                        <option>New Order</option>
                                        <option>Paid</option>
                                      </select>
                                    </div>
                            </div>

                            <div class="col-md-2">
                                    <div class="form-group">
                                    <label>Search</label>
                                    <button type="submit" name="save" id="save" class="btn btn-primary form-control" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();">Go</button>
                                    </div>
                            </div>

                            </form>


                            <div class="col-md-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr>
                              
                              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" width="10%">Status</th>
                              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" width="10%">Customer Name</th>
                              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" width="15%">Item</th>
                              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" width="10%">Price</th>
    
                              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" width="10%">Date Ordered</th>
                              <th width="15%">Action</th>
                        
                              
                            </tr>
                          </thead>
                            <tbody>
                              <?php

                       // if ($_SERVER["REQUEST_METHOD"] == "POST"){ 
                         // Include config file
                         require_once "config.php";
                         $name = $_POST['name']; 
                         $item = $_POST['item']; 
                         $status = $_POST['status']; 
                         $from = $_POST['from']; 
                         $to = $_POST['to']; 

                         // Attempt select query execution
                         //$query = "SELECT * FROM orders WHERE name LIKE '%$name%' AND item LIKE '%$item%' AND status LIKE '%$status%' AND order_date 
                         //BETWEEN '$from' AND '$to'";
              
                          $query = "SELECT * FROM orders WHERE name LIKE '%$name%' AND item LIKE '%$item%' AND status LIKE '%$status%' ORDER BY status, id desc";
                         if($result = mysqli_query($link, $query)){
                             if(mysqli_num_rows($result) > 0){

                                     while($row = mysqli_fetch_array($result)){
                                         echo "<tr>";

                                             
                                             $status = $row['status'];
                                            if($status == "New Order"){
                                              echo "<td> <span class='label label-warning'>New Order</span> </td>";
                                            } elseif ($status == "Paid") {
                                                echo "<td> <span class='label label-success'>Paid</span> </td>";
                                            } elseif ($status == "Void") {
                                              echo "<td> <span class='label label-danger'>Void</span> </td>";
                                            } else {
                                              echo "<td> <span class='label label-default'>Error</span> </td>";
                                            }
                                             echo "<td>" . $row['name'] . "</td>";
                                             echo "<td><pre>" . $row['item'] . "</pre></td>";
                                             echo "<td>₱" . number_format($row['price'],2) . "</td>";

                                             echo "<td>" . $row['order_date'] . "</td>";

                                              echo "<td>";
                                             echo "<a href='View-Order.php?id=". $row['id'] ."' title='View order' data-toggle='tooltip'><span class='glyphicon glyphicon-file'></span></a>";
                                                
                                               echo " &nbsp; <a href='order-delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash remove'></span></a>";
                                             
                                             echo "</td>";
                                             //echo "<td>" . $row['delivery'] . "</td>";
                                            



                                             
                                         echo "</tr>";
                                     }

                                 // Free result set
                                 mysqli_free_result($result);
                             } else{
                                 echo "<p class='lead'><em>No records were found.</em></p>";
                             }
                         } else{
                             echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                         }
                     
                         // Close connection
                         mysqli_close($link);
                         ?>
                            </tbody>
                          </table>
                        </div>

                        </div>
                      </div>
          
        </div>
    </section>
    
  </div>
  <footer class="main-footer">
     <?php include'template/footer.php'; ?>  
  </footer>
  <!-- /.content-wrapper -->
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


<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Page script -->
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>





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

<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })
 </script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    $('#datepicker2').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

<script>
  //uppercase text box
  function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

$("#theform").submit(function(event){
   loadAjax();
   event.preventDefault()
})
</script>

<!-- Delete Customer Ajax -->



    </body>
</html>
