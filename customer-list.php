<?php
// Initialize the session
session_start();

// Include config file
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Define variables and initialize with empty values
$name = $address = $item = $price = $date = $phone = $delivery = $status = "";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //Assigning posted values to variables.
  $name = test_input($_POST['name']);
  $address = test_input($_POST['address']);
  $phone = test_input($_POST['phone']);


  // Validate supplier name

  if(empty($name)){
    $alertMessage = "Please enter name.";
  }

  if(empty($alertMessage)){
    $sql_check = "SELECT name FROM customers WHERE name ='$name'";
    if($result = mysqli_query($link, $sql_check)){
                             if(mysqli_num_rows($result) > 0){
                                echo "<script> window.alert('Name already exist, Please try again a different name')</script>";

                                 mysqli_free_result($result);
                             } else{
                                //Checking the values are existing in the database or not
                                $query = "INSERT INTO customers 
                                (name, phone, address) 
                                VALUES 
                                ('$name', '$phone', '$address')";

                                $result = mysqli_query($link, $query) or die(mysqli_error($link));

                                if($result){
                                  $alertMessage = "<div class='alert alert-success' role='alert'>
                                  New Customer Successfully Added in Database.
                                  </div>";

                                  echo "<script> window.alert('New Customer Successfully Added in Database')</script>";

                                  header("location: customer-list.php");
                                }else{
                                  $alertMessage = "<div class='alert alert-danger' role='alert'>
                                  Error Adding data in Database.
                                  </div>";}

                                  echo "<script> window.alert('Error Adding data in Database')</script>";

                                  // remove all session variables
                                  //session_unset();
                                  // destroy the session
                                  //session_destroy();

                                  // Close connection
                                  mysqli_close($link);
                             }
                         } else{
                             echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                         }

                         mysqli_close($link);

    }
  }     

    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<!DOCTYPE PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MDJS | Customer List</title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<style>
  textarea {
  resize: none;
}
</style>

<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-blue layout-fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">MJ</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>MD</b>JS</span>
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
    <section class="content-header">
      <h1>
         Mark & Diego Japan Surplus <br>
        <small>Order Management System</small>
      </h1>
    </section>

    <section class="content">
        <div class="row">
          
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="theform">
          <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">+ Add New Customer</h3>
                        </div>


                      <div class="box-body">
                        <?php echo $alertMessage; ?>
                        <div class="col-md-6">
                        <!-- form start -->
                                    <div class="form-group">
                                      <label class="text text-red">*</label>
                                      <label>Name</label>
                                      <input type="text" class="form-control" id="" maxlength="50" placeholder="Name" name="name" required>
                                    </div>

                                    <div class="form-group">
                                      <label>Phone</label>
                                      <input type="text" class="form-control" id="" placeholder="Phone" data-inputmask='"mask": "(999) 999-9999"' name="phone" data-mask>
                                    </div>

                                    <div class="form-group">
                                      <label>Address</label>
                                      <textarea class="form-control" rows="3" id="Name2" placeholder="Enter Address" name="address"></textarea>
                                    </div>

                                    <div class="box-footer">
                                    <button type="submit" name="save" id="save" class="btn btn-primary" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();">Submit</button>
                                    </div>
                                    </form>

                          </div>
                          <div class="col-md-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr>
                              <th width="10%">Action</th>
                              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" width="30%">Customer Name</th>
                              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" width="20">Phone</th>
                              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" width="40%">Address</th>


                              
                            </tr>
                          </thead>
                            <tbody>
                              <?php
                         // Include config file
                         require_once "config.php";
                         // Attempt select query execution
                         $query = "SELECT * FROM customers";
              
                        // $query = "SELECT * FROM orders WHERE name LIKE '%$name%' AND item LIKE '%$item%' AND status LIKE '%$status%'";
                         if($result = mysqli_query($link, $query)){
                             if(mysqli_num_rows($result) > 0){

                                     while($row = mysqli_fetch_array($result)){
                                         echo "<tr>";
                                             echo "<td>";
                                             echo "<a href='View-Customer.php?id=". $row['id'] ."' title='View Order' data-toggle='tooltip'><span class='glyphicon glyphicon-share'></span></a>";
                                                
                                             //echo " &nbsp; <a href='customer-delete.php?id=". $row['id'] ."&name=". $row['name']."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash remove'></span></a>";

                                             echo "</td>";

                                             echo "<td>" . $row['name'] . "</td>";
                                             echo "<td>" . $row['phone'] . "</td>";
                                             echo "<td>" . $row['address'] . "</td>";
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


          
        </div>
    </section>
    
  </div>

  <!-- /.content-wrapper -->

  <footer class="main-footer">
  <?php include'template/footer.php'; ?>  
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
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
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->

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
      'searching'   : true,
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


  })
</script>

<script>
  //uppercase text box
  function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}

function copyTextValue(bf) {
  var text1 = bf.checked ? document.getElementById("Name1").value : '';

  document.getElementById("Name2").value = text1;
  document.getElementById("Name3").value = text1;
  
}

$(function()
{
  $('#theform').submit(function(){
    $("input[type='submit']", this)
      .val("Please Wait...")
      .attr('disabled', 'disabled');
    return true;
  });
});




</script>

<!-- Delete Customer Ajax -->
<script>
$(".remove").click(function(){
var id = $(this).parents("tr").attr("id");
if(confirm('Are you sure to remove this record ?'))
{
  $.ajax({
    url: 'customer-delete.php',
    type: 'POST',
    data: {id: id},
    error: function(data) {
      $("#"+id).remove();
      alert('Record removed successfully');
},

success: function(data) {
  $("#"+id).remove();
  alert("Record removed successfully");
}
});
}
});
</script>

    </body>
</html>
