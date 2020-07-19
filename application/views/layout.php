<?php require_once('include/header.php'); ?>
<?php /*
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <base href="<?php echo base_url(); ?>">
    <title>AngularJS and CodeIgniter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script>
      var BASE_URL = "<?php echo site_url(); ?>/";
    </script>

  </head>
*/?>
  <body class="menu-position-side menu-side-left full-screen with-content-panel">
    <div class="all-wrapper with-side-panel solid-bg-all">
        <?php require_once('include/sidebar.php'); ?>

        <div class="content-w">
                <?php require_once('include/sub-header.php'); ?>
                    <!-- Page content -->
                      <div class="content-i">
                        <div class="content-box">


                        <div ng-app="project">
                             <div ng-view></div>

                        </div>
                      </div>
                </div>
            </div>
        </div>

  
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="<?php echo base_url(); ?>static/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="static/js/angular.js"></script>
<!--   <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-2DyR1P8Ct3NfvusOJjYl1HbPz6SbR3o"></script>
 -->
    <script src="static/js/angular-resource.js"></script>
    <script src="static/js/ng-grid.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-utils/0.1.1/angular-ui-utils.min.js"></script>
    <script src="static/js/ui-bootstrap-tpls-0.5.0.min.js"></script>
    <script src="static/js/jQuery-ui-directive.js"></script>
    <script src="static/appScript/app.js"></script>

    <script src="<?php echo base_url(); ?>static/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/moment/moment.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap-validator/dist/validator.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/dropzone/dist/dropzone.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/editable-table/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/tether/dist/js/tether.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/slick-carousel/slick/slick.min.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/util.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/alert.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/button.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/carousel.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/collapse.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/dropdown.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/modal.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/tab.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/tooltip.js"></script>
    <script src="<?php echo base_url(); ?>static/bower_components/bootstrap/js/dist/popover.js"></script>
    <script src="<?php echo base_url(); ?>static/js/demo_customizer.js?version=4.5.0"></script>
    <script src="<?php echo base_url(); ?>static/js/main.js?version=4.5.0"></script>

    <script src="<?php echo base_url(); ?>static/js/jquery.bootstrap-growl.min.js"></script>



<!--   <script src="<?php echo base_url(); ?>static/js/vendor/jquery.min.js"></script>
<!-- 
   <script src="static/js/jquery-1.9.1.js"></script> -->
   
<!--   <script src="<?php echo base_url(); ?>static/js/vendor/bootstrap.min.js"></script>
  <script src="static/js/angular-resource.js"></script>
  <script src="static/js/ng-grid.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-utils/0.1.1/angular-ui-utils.min.js"></script>
  <script src="static/js/ui-bootstrap-tpls-0.5.0.min.js"></script>
  <script src="static/js/jQuery-ui-directive.js"></script>
  <script src="static/appScript/app.js"></script>
 -->
<!--   <script src="static/js/jquery-ui-1.10.2.custom.min.js"></script>
 -->
<!--   <script src="<?php echo base_url(); ?>static/js/plugins.js"></script>
  <script src="<?php echo base_url(); ?>static/js/app.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>/static/js/bootstrap-datetimepicker.js" charset="UTF-8"></script> -->


  </body>
</html>