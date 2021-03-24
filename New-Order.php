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


// ============================================================ //
// Define variables and initialize with empty values
$notes = $users_id = $name = $address = $item = $price = $date = $phone = $delivery = $status = "";

require_once "config.php";

$users_id = $_GET['id']; //url id

$query = "SELECT * from items WHERE id = $users_id " ;
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)){
      $id               = $row['id'];
      $name             = $row['item_name'];
      $date_arrived     = $row['date_arrived'];
      $status           = $row['item_status'];
      $notes            = $row['notes'];

  }

  $num_rows = mysqli_num_rows($result);
} else{
  echo "<p class='lead'><em>No records were found.</em></p>";
}

// ============================================================ //



// // Define variables and initialize with empty values
 

//If the form is submitted or not.
//If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //Assigning posted values to variables.
  $bidder_name = test_input($_POST['bidder_name']);
  $item = test_input($_POST['item']);
  $date_ordered = test_input($_POST['date_ordered']);
  $item_status = test_input($_POST['item_status']);
  $price = test_input($_POST['price']);
  $notes = test_input($_POST['notes']);
  // Validate supplier name

  if(empty($bidder_name)){
    $alertMessage = "Please enter name.";
  }

 if(empty($price)){
    $alertMessage = "<p class='text-danger'>Please enter Price Value.</p>";
  }
  if(empty($date_ordered)){
    $alertMessage = "<p class='text-danger'>Please enter Order Date.</p>";
  }

  if(empty($alertMessage)){
    //UPDATE table_name SET column1 = value1, column2 = value2 WHERE id=100;

    $query = "UPDATE items SET item_status= 'Paid' ,date_released = '$date_ordered' ,sold_to = 
    '$bidder_name', price = '$price' WHERE id = '".$users_id."' " ;

    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if($result){
      $alertMessage = "<div class='alert alert-success' role='alert'>
      New order successfully added to the database.
      <script>window.location.replace('order-list.php');</script>
      </div>";
    }else{
      $alertMessage = "<div class='alert alert-danger' role='alert'>
      Error adding data in Database.
      </div>";}

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

<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RMD | New Order</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
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

  <?php include("template/sidebar.php"); ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include'template/header-title.php'; ?> 
    <section class="content">
        <div class="row">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $users_id; ?>" method="post" id="theform">
              <div class="col-md-9">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">+ Add New Order</h3>
                          <?php echo $alertMessage; ?>
                        </div>


                        <div class="box-body">
                          <div class="col-md-6">
                          <!-- form start -->
                                    <div class="form-group">
                                      <label class="text text-red">*</label>
                                      <label>Bidder Name</label>
                                      <select class="form-control select2" style="width: 100%;" id="" maxlength="50" placeholder="Name" name="bidder_name" onchange="" required>
                                        
                                        <option selected="selected">Default Customer</option>
                                        <?php

                                         // Include config file
                                         require_once "config.php";
                                         // Attempt select query execution
                                         $query = "SELECT * FROM customers";
                                        // $query = "SELECT * FROM orders WHERE name LIKE '%$name%' AND item LIKE '%$item%' AND status LIKE '%$status%'";
                                         if($result = mysqli_query($link, $query)){
                                             if(mysqli_num_rows($result) > 0){

                                                     while($row = mysqli_fetch_array($result)){

                                                             echo "<option>" . $row['name'] .  "</option>";
                                                     }

                                                 // Free result set
                                                 mysqli_free_result($result);
                                             } else{
                                                 echo "<p class='lead'><em>No records were found.</em></p>";
                                             }
                                         } else{
                                             echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                         }

                                         mysqli_close($link);

                                        ?>

                                      
                                      </select>
                                    </div>

                                    <!--
                                    <div class="form-group">
                                      <label>Phone</label>
                                      <input type="text" class="form-control" id="" placeholder="Phone" data-inputmask='"mask": "(999) 999-9999"' name="phone" data-mask>
                                    </div>
                                  -->

                                    <div class="form-group">
                                      <label class="text text-red">*</label>
                                      <label>Item Code</label>
                                      <textarea class="form-control" rows="1" id="" placeholder="Enter Item & Product" name="item" disabled><?php echo $name; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                      <label>Description</label>
                                      <textarea class="form-control" rows="3" id="Name2" placeholder="Enter Additional Notes" name="notes" disabled><?php echo $notes; ?></textarea>
                                    </div>

                                    

                               
                            </div>

                            <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="text text-red">*</label>
                                      <label>Date</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" autocomplete="off" id="datepicker" value="<?php echo date("m/d/Y"); ?>" name="date_ordered" data-mask required> 
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label class="text text-red">*</label>
                                      <label>Price</label>

                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          ₱
                                        </div>

                                        <input type="text" class="form-control" name="price" autocomplete="off" placeholder="Price" required>
                                      </div>


                                      <!-- /.input group -->
                                    </div>
                                    <!-- 
                                    <div class="form-group">
                                      <label class="text text-red">*</label>
                                      <label>Address</label>
                                     <textarea class="form-control" rows="3" id="Name1" placeholder="Enter Delivery Details" name="address"></textarea>
                                    </div>


                                    <div class="form-group">
                                      <label>Delivery Details</label> <input type="checkbox" name="check1" onchange="copyTextValue(this);"/>&nbsp;Same as above
                                       <textarea class="form-control" rows="3" id="Name2" placeholder="Enter Delivery Details" name="delivery"></textarea>
                                      
                                    </div>
                                    -->

                                    

                                   

                          </div>
                        </div>
                              <div class="box-footer">
                              <button type="submit" name="save" id="save" class="btn btn-primary" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();">Submit</button>
                              </div>
                              </form>
              </div>
          

        </div>
    </section>
    </div>
  

  <footer class="main-footer">
  <?php include'template/footer.php'; ?>  
  </footer>
  <!-- /.content-wrapper -->
</div>

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

function showCustomer(str) {
document.getElementById("address").value = data.value; //data is the element

}


</script>



</body>
</html>
