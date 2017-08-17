<?php include_once('includes/connect.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
    session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['userName'])) {
    $loginUsername=$_POST['userName'];
    $password=$_POST['password'];
    $MM_fldUserAuthorization = "";
    $MM_redirectLoginSuccess = "index.php";
    $MM_redirectLoginFailed = "login.php";
    $MM_redirecttoReferrer = false;
    $dbname = "sinmarlb_dbsinmar";
    mysqli_select_db($conn, $dbname);

    $LoginRS__query=sprintf("SELECT userName, password FROM tblusers WHERE userName='%s' AND password='%s'", $loginUsername, $password);

    $LoginRS = mysqli_query($conn, $LoginRS__query) or die(mysql_error());
    $loginFoundUser = mysqli_num_rows($LoginRS);
    if ($loginFoundUser) {
        $loginStrGroup = "";

        if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
        //declare two session variables and assign them
        $_SESSION['MM_Username'] = $loginUsername;
        $_SESSION['MM_UserGroup'] = $loginStrGroup;

        if (isset($_SESSION['PrevUrl']) && false) {
            $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
        }
        header("Location: " . $MM_redirectLoginSuccess );
    }
    else {
        header("Location: ". $MM_redirectLoginFailed );
    }
}
?>
<!DOCTYPE html>
<html>

<head>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <title>Axis Panel</title>
  <meta name="keywords" content="" />
  <meta name="description" content="">
  <meta name="author" content="AxisMEA">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Font CSS (Via CDN) -->
  <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>

  <!-- Theme CSS -->
  <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">

  <!-- Admin Forms CSS -->
  <link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">

  <!-- Favicon -->
  <link rel="shortcut icon" href="assets/img/favicon.ico">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
   <![endif]-->
</head>

<body class="external-page external-alt sb-l-c sb-r-c">

  <!-- Start: Main -->
  <div id="main" class="animated fadeIn">

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

      <!-- Begin: Content -->
      <section id="content">

        <div class=" theme-info mw500" id="login" style="align-content: center; margin: auto auto;">

          <!-- Login Logo -->
          <div class="row table-layout">
              <img src="assets/img/logos/logo.png" title="AxisPanel Logo" class="center-block img-responsive" style="max-width: 275px;">
          </div>

          <!-- Login Panel/Form -->
          <div class="panel mt30 mb25">

            <form method="post" name="login" action="<?php echo $loginFormAction; ?>" id="contact">
              <div class="admin-form panel-body bg-light p25 pb15">

                <!-- Divider -->
                <div class="section-divider mv30">
                  <span>Log In</span>
                </div>

                <!-- Username Input -->
                <div class="section">
                  <label for="username" class="field-label text-muted fs18 mb10">Username</label>
                  <label for="username" class="field prepend-icon">
                    <input type="text" name="userName" id="username" class="gui-input" placeholder="Enter username">
                    <label for="username" class="field-icon">
                      <i class="fa fa-user"></i>
                    </label>
                  </label>
                </div>

                <!-- Password Input -->
                <div class="section">
                  <label for="username" class="field-label text-muted fs18 mb10">Password</label>
                  <label for="password" class="field prepend-icon">
                    <input type="password" name="password" id="password" class="gui-input" placeholder="Enter password">
                    <label for="password" class="field-icon">
                      <i class="fa fa-lock"></i>
                    </label>
                  </label>
                </div>

              </div>

              <div class="panel-footer clearfix">
                <div class="admin-form">
                    <label class="switch ib switch-primary mt10">
                      <input type="checkbox" name="remember" id="remember" disabled>
                      <label for="remember" data-on="YES" data-off="NO"></label>
                      <span>Remember me</span>
                    </label>
                </div>
                  <div>
                  <button type="submit" class="btn-primary btn-lg pull-right">Sign In</button>
                  </div>
              </div>

            </form>
          </div>

          <!-- Registration Links -->
          <div class="login-links">
            <p>
              <a href="forgetpass.php" class="active" title="Sign In">Forgot Password?</a>
            </p>
          </div>

        </div>

      </section>
      <!-- End: Content -->

    </section>
    <!-- End: Content-Wrapper -->

  </div>
  <!-- End: Main -->


  <!-- BEGIN: PAGE SCRIPTS -->

  <!-- jQuery -->
  <script src="vendor/jquery/jquery-1.11.1.min.js"></script>
  <script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

  <!-- Theme Javascript -->
  <script src="assets/js/utility/utility.js"></script>
  <script src="assets/js/demo/demo.js"></script>
  <script src="assets/js/main.js"></script>

  <!-- Page Javascript -->
  <script type="text/javascript">
  jQuery(document).ready(function() {

    "use strict";

    // Init Theme Core      
    Core.init();

    // Init Demo JS
    Demo.init();

  });
  </script>

  <!-- END: PAGE SCRIPTS -->

</body>

</html>
