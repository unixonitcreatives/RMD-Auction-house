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

require_once "config.php";

$users_id = $_GET['id'];

$query = "SELECT * from customers WHERE id=".$_GET['id']." ";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
if (mysqli_num_rows($result) > 0) {

  while ($row = mysqli_fetch_assoc($result)){
      $id               = $row['id'];
      $name             = $row['name'];
      $phone             = $row['phone'];
      $address            = $row['address'];
  }
  $num_rows = mysqli_num_rows($result);
} else{
  echo "<p class='lead'><em>No records were found.</em></p>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //Assigning posted values to variables.
  $name = test_input($_POST['name']);
  $address = test_input($_POST['address']);
  $phone = test_input($_POST['phone']);


  if(empty($alertMessage)){
    //UPDATE table_name SET column1 = value1, column2 = value2 WHERE id=100;

    $query = "UPDATE customers SET phone = '$phone' ,address = '$address'  WHERE id = '".$users_id."' " ;

    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if($result){
      $alertMessage = "<div class='alert alert-success' role='alert'>
      Bidder successfully updated.
      <script>window.location.replace('bidder-list.php');</script>
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

<!DOCTYPE PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <title>RMD Auction House | Customer List</title>
  <style>
    textarea {
    resize: none;
  }
  </style>


  <?php include("template/header.php"); ?>
  
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
          <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">+ Add New Bidder</h3>
                        </div>


                      <div class="box-body">
                        <?php echo $alertMessage; ?>
                        <div class="col-md-6">
                        <!-- form start -->
                                    <div class="form-group">
                                      <label>Bidder Name</label>
                                      <input type="text" class="form-control" id="" maxlength="50" placeholder="Name" name="name" value="<?php echo $name;?>"disabled>
                                    </div>

                                    <div class="form-group">
                                      <label>Contact No.</label>
                                      <input type="text" class="form-control" id="" placeholder="Phone" data-inputmask='"mask": "(999) 999-9999"' name="phone" value="<?php echo $phone;?>" data-mask>
                                    </div>

                                    <div class="form-group">
                                      <label>Address</label>
                                      <textarea class="form-control" rows="3" id="Name2" placeholder="Enter Address" name="address"><?php echo $address;?></textarea>
                                    </div>

                                    <div class="box-footer">
                                    <button type="submit" name="save" id="save" class="btn btn-primary" onclick="this.disabled=true;this.value='Submitting...'; this.form.submit();">Update</button>
                                    </div>
                                    </form>

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
