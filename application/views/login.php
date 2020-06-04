<?php require_once("include/header.php"); ?>

<body class="auth-wrapper">
    <div class="all-wrapper menu-side with-pattern">
      <div class="auth-box-w">
        <div class="logo-w" style="padding: 6%; border-radius: 100px">
          <a href="#"><img alt="" src="<?php echo base_url(); ?>/favicon.png" width="80px" style="border-radius: 100px"></a>
        </div>
        <h4 class="auth-header">
          Login Form
        </h4>
        <?php if($this->session->userdata('error')){ ?>
        <div class="alert alert-warning" >
          <strong>Wrong!</strong> Email or Password.
        </div>
        <?php } ?>
        <form action="<?php echo site_url();?>/login/submit" method="POST">
          <div class="form-group">
            <label for="">Username</label><input class="form-control" name="username" placeholder="Enter your username" type="text">
            <div class="pre-icon os-icon os-icon-user-male-circle"></div>
          </div>
          <div class="form-group">
            <label for="">Password</label><input class="form-control" name="password" placeholder="Enter your password" type="password">
            <div class="pre-icon os-icon os-icon-fingerprint"></div>
          </div>
          <div class="buttons-w">
            <button class="btn btn-primary">Log me in</button>
            <div class="form-check-inline">
<!--               <label class="form-check-label"><input class="form-check-input" type="checkbox">Remember Me</label>
 -->            </div>
          </div>
        </form>
      </div>
    </div>
</div>
</body>



























<?php /*









  <!-- Login Full Background -->
  <!-- For best results use an image with a resolution of 1280x1280 pixels (prefer a blurred image for smaller file size) -->
  <img src="<?php echo base_url(); ?>static/img/placeholders/backgrounds/login_full_bg.jpg" alt="Login Full Background" class="full-bg animation-pulseSlow">
        <!-- END Login Full Background -->

        <!-- Login Container -->
        <div id="login-container" class="animation-fadeIn">
            <!-- Login Title -->
            <div class="login-title text-center">
                <h1><i class="gi gi-flash"></i> <strong>All About Electronics Admin</strong><br><small>Please <strong>Login</strong> </small></h1>
            </div>
            <!-- END Login Title -->

            <!-- Login Block -->
            <div class="block push-bit">
                <!-- Login Form -->
                <?php if($this->session->userdata('error')){ ?>
                <div class="alert alert-warning" >
                  <strong>Wrong!</strong> Email or Password.
                </div>
                <?php } ?>

                <form action="<?php echo site_url();?>/login/submit" method="post" class="form-horizontal form-bordered form-control-borderless">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                <input type="text" id="login-email" name="username" class="form-control input-lg" placeholder="Username">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                                <input type="password" id="login-password" name="password" class="form-control input-lg" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-8 text-left">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Login</button>
                        </div>
                    </div>
                   
                </form>
                <!-- END Login Form -->

<!--     <div class="container">
      <form class="form-signin" action="<?php echo site_url();?>/login/submit" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-block-level" name="username" value="" placeholder="Email address">
        <input type="password" class="input-block-level" name="password" value="" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
      </form>

  -->   </div> <!-- /container -->  
<!-- <script src="../static/js/jquery-1.9.1.js"></script>
   
 <script src="../static/js/bootstrap.min.js"></script>	
 -->   
 </div> 
  <script src="<?php echo base_url(); ?>/static/js/vendor/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>/static/js/vendor/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>/static/js/plugins.js"></script>
  <script src="<?php echo base_url(); ?>/static/js/app.js"></script>

  </body>
</html>*/
?>
