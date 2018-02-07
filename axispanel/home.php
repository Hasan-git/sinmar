<?php if (!isset($_SESSION)) {
    session_start();
} ?>
<?php include_once('includes/auth.php'); ?>
<?php include_once('includes/logout.php'); ?>

<?php $pagename="home"; ?>
    <!DOCTYPE html>
    <html>

    <head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <title>Axis Panel</title>
        <meta name="keywords" content="" />
        <meta name="description" content="AxisPanel">
        <meta name="author" content="AxisMEA">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Font CSS (Via CDN) -->
        <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600'>

        <!-- Datatables CSS -->
        <link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/dataTables.bootstrap.css">

        <!-- Datatables Addons CSS -->
        <link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/dataTables.plugins.css">

        <!-- Theme CSS -->
        <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">

        <!-- Admin Forms CSS -->
        <link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">

        <!-- Select2 Plugin CSS  -->
        <link rel="stylesheet" type="text/css" href="vendor/plugins/select2/css/core.css">

        <!-- toastr -->
        <link rel="stylesheet" type="text/css" href="vendor/plugins/toaster/toastr.min.css">

        <!-- Modal -->
        <link rel="stylesheet" href="vendor/plugins/modal/remodal.css">
        <link rel="stylesheet" href="vendor/plugins/modal/remodal-default-theme.css">

        <!-- Favicon -->
        <link rel="shortcut icon" href="assets/img/favicon.ico">

        <!-- dropzone -->
        <link rel="stylesheet" type="text/css" href="vendor/plugins/dropzone.v2/dropzone.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="datatables-page sb-l-o sb-r-c">

    <?php include_once('includes/themes.php') ?>

    <!-- Start: Main -->
    <div id="main">

    <?php include_once('includes/header.php') ?>
    <?php include_once('includes/lsidebar.php') ?>

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">
    <?php include_once('includes/topbar.php') ?>

    <!-- Begin: Content -->
    <section id="content" class=" animated fadeIn">

    <!-- begin: .tray-center -->
    <div class="tray tray-center">
    <div class="col-md-12">

        <!-- EDIT  -->
        <!-- EDIT  -->
        <div class="row" id="editFormContainer">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Corporation Statistics <span class="text-info" id="nfBoxName"></span></span>
                    </div>

                    <div class="panel-body" id="editFormContainer">
                        <span class="text-danger-darker">Fields with * are required</span>
                        <form class="form-horizontal" name="editform" id="editForm" method="POST" action="" enctype="multipart/form-data" role="form">
                            
                            <div class="form-group admin-form">
                                <div class="col-sm-3">
                                    <label class="control-label">Experience Years</label>
                                    <input data-validation="required" type="text" name="xpYears" id="xpYears" value="" class="form-control" >
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Projects</label>
                                    <input data-validation="required" type="text" name="projects" id="projects" value="" class="form-control" >
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Clients</label>
                                    <input data-validation="required" type="text" name="clients" id="clients" value="" class="form-control" >
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Employees</label>
                                    <input data-validation="required" type="text" name="employees" id="employees" value="" class="form-control" >
                                </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <div align="right" class="">
                                <button type="button" name="submitedit" data-row='' class="btn btn-primary" id="save">Save Changes</button>
                                <input type="hidden" name="id" id="id" value="">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>



    
    </div>
    </div>
    <!-- end: .tray-center -->

    </section>
    <!-- End: Content -->

    <?php include_once('includes/footer.php') ?>

    </section>
    <!-- End: Content-Wrapper -->

    </div>
    <!-- End: Main -->

    <!-- MODAL TEMPLATE for delete project -->
    <div class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
      <button data-remodal-action="close" class="remodal-close" aria-label="Close"></button>
      <div>
        <h2 id="modal1Title">Notification</h2>
        <p id="modal1Desc">
          Are you sure you want to delete this project ?
        </p>
      </div>
      <br>
      <button data-remodal-action="cancel" class="remodal-cancel">No</button>
      <button data-remodal-action="confirm" class="remodal-confirm">Yes</button>
    </div>

    <!-- BEGIN: PAGE SCRIPTS -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery-1.11.1.min.js"></script>
    <script src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

    <!-- Datatables -->
    <script src="vendor/plugins/datatables/media/js/jquery.dataTables.js"></script>

    <!-- Datatables Tabletools addon -->
    <script src="vendor/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>

    <!-- Datatables Bootstrap Modifications  -->
    <script src="vendor/plugins/datatables/media/js/dataTables.bootstrap.js"></script>

    <!-- Select2 Plugin Plugin -->
    <script src="vendor/plugins/select2/select2.min.js"></script>

    <!-- plugins -->
    <script src="vendor/plugins/toaster/toastr.min.js"></script>
    <script src="vendor/plugins/modal/remodal.js"></script>
    <script src="vendor/plugins/jqueryFormValidator/form-validator/jquery.form-validator.js"></script>
    <script type="text/javascript" src="vendor/plugins/dropzone/dropzone.min.js"></script>

    <!-- Theme Javascript -->
    <script src="assets/js/utility/utility.js"></script>
    <script src="assets/js/demo/demo.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/controllers/home.js"></script>

    <!-- END: PAGE SCRIPTS -->


    </body>

    </html>
