</div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?php echo date("Y");?> <a href="http://www.talhaweb.com/" target="_blank">Talha</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Develop by Talha <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
  <script src="js/jquery.data_tables.min.js"></script>



<script>
  
<?php $i=1; foreach($result as $row2) :?>
$('#notification_reload').click(function(){
    let notify_<?php echo $i; ?> = $('#id_<?php echo $i; ?>').val();  
    
    // console.log(amount);
    $.ajax({
        type: "POST",
        url:'ajax.php',
        data: {
          notify_<?php echo $i; ?> : notify_<?php echo $i; ?>,
        },
        success:function(response){
            let data = response;
            console.log(data);
            $('.notifyRemo').removeClass();
        }
    });  
});

<?php $i++; endforeach; ?>
</script>

  
<script>
// $(document).ready(function () {
//   setInterval(function () {
//       $('#notification_reload').load('#notification_reload');
//   }, 3000);
// });
</script>

</body>

</html>
