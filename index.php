<?php
include("template/session.php");

// Include config file
require_once "config.php";

?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>RMD Auction House | Home</title>
    <?php include("template/header.php"); ?>
    
    <!-- =============================================== -->

    <?php include("template/sidebar.php"); ?>

    <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include'template/header-title.php'; ?> 

    <!-- Main content -->
    <section class="content">

     <div class="callout callout-danger">
        <h4>RMD Auction House Inventory System is under construction</h4>
        <p>Our developers are now working on the adjustments, thank you for your patience.</p>
        
        <p><strong>Note:</strong> Users might experience bugs and errors during the development period. Please contact developer for assistance.</p>
      </div>

    </section>
    <!-- /.content -->
  </div>

  <footer class="main-footer">
  <?php include'template/footer.php'; ?>      
  </footer>

  <?php include'template/script.php'; ?>

</body>
</html>
