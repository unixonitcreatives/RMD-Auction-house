

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
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
          'autoWidth'   : true
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
        $(".remove").click(function(){
            var id = $(this).parents("tr").attr("id");

            if(confirm('Are you sure to remove this record ?'))
            {
                $.ajax({
                   url: 'supplier-delete.php',
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
//disable button on click
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
