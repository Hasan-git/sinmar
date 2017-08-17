<?php if (!isset($_SESSION)) {
    session_start();
} ?>
<?php include_once('includes/auth.php'); ?>
<?php include_once('includes/logout.php'); ?>

<?php $pagename="Project Names"; ?>
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

        <!-- toastr -->
        <link rel="stylesheet" type="text/css" href="vendor/plugins/toaster/toastr.min.css">
        
        <!-- Modal -->
        <link rel="stylesheet" href="vendor/plugins/modal/remodal.css">
        <link rel="stylesheet" href="vendor/plugins/modal/remodal-default-theme.css">

        <!-- Favicon -->
        <link rel="shortcut icon" href="assets/img/favicon.ico">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

    </head>

    <body class="datatables-page sb-l-o sb-r-c">

    <!-------------------------------------------------------------+
      <body> Helper Classes:
    ---------------------------------------------------------------+
      '.sb-l-o' - Sets Left Sidebar to "open"
      '.sb-l-m' - Sets Left Sidebar to "minified"
      '.sb-l-c' - Sets Left Sidebar to "closed"

      '.sb-r-o' - Sets Right Sidebar to "open"
      '.sb-r-c' - Sets Right Sidebar to "closed"
    ---------------------------------------------------------------+
     Example: <body class="example-page sb-l-o sb-r-c">
     Results: Sidebar left Open, Sidebar right Closed
    --------------------------------------------------------------->

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

                        <!-- NEW PROJECT -->
                        <!-- NEW PROJECT -->
                        <!-- NEW PROJECT -->
                        <div class="row j-hide" id="newProForm" >
                            <div class="col-md-6">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <span class="panel-title">Create New Project</span>
                                    </div>

                                    <div class="panel-body">
                                        <form class="form-horizontal" name="newform" id="newform" method="POST" action="" role="form">
                                            <div class="form-group">
                                                <label for="inputStandard" class="col-lg-3 control-label">Project Name</label>
                                                <div class="col-lg-8">
                                                    <input type="text" data-validation="required" id="nProjectName" name="projectName" class="form-control" placeholder="Insert Project Name" required>
                                                </div>
                                            </div>
                                            <div align="right" class="">
                                                <button type="button" class="btn btn-default" role="button" id="canelNewPro" > Cancel </button>
                                                <button type="button" name="submitnew" class="btn btn-primary" id="saveNewPro" > Create Project</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <!-- EDIT PROJECT -->
                        <!-- EDIT PROJECT -->
                        <!-- EDIT PROJECT -->
                        <div class="row j-hide" id="editmode">
                            <div class="col-md-6">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <span class="panel-title">Edit <span class="text-info" id="proNameBox"></span> Project </span>
                                    </div>

                                    <div class="panel-body">
                                        <form class="form-horizontal" name="editform" id="editProForm" method="POST"  >
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Project Name</label>
                                                <div class="col-lg-8">
                                                    <input type="hidden" id="projectId" name="projectId" value="" >
                                                    <input type="text" id="projectName" data-validation="required" name="projectName" class="form-control" value="" required>
                                                </div>
                                            </div>
                                            <div align="right" class="">
                                                <button type="button" class="btn btn-default " role="button" id="canelEditPro"> Cancel </button>
                                                <button type="button" name="submitedit" data-row='' class="btn btn-primary" id="saveEditPro">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="clearfix"></div>

                    <!-- CREATE NEW PROJECT BTN -->
                    <button class="btn btn-default btn-gradient" scrollto="#newProForm" id="newProOpen"><i class="fa fa-plus"></i> Create New Project </button>

                    <div class="panel panel-visible">
                        <div class="panel-heading">
                            <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tags"></span>Project Names</div>
                        </div>

                        <div class="panel-body pn">
                            <form name="table" method="POST" action="">
                                <table class="table table-striped table-hover" id="datatable3" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Project Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Index</th>
                                        <th>Project Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>


                                    </tbody>
                                </table>

                            </form>
                        </div>
                    </div>
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

   <!-- plugins -->
    <script src="vendor/plugins/toaster/toastr.min.js"></script>
    <script src="vendor/plugins/modal/remodal.js"></script>
    <script src="vendor/plugins/jqueryFormValidator/form-validator/jquery.form-validator.js"></script>

    <!-- Theme Javascript -->
    <script src="assets/js/utility/utility.js"></script>
    <script src="assets/js/demo/demo.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/controllers/index.js"></script>

    </body>

    </html>


