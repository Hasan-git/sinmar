<?php if (!isset($_SESSION)) {
    session_start();
} ?>
<?php include_once('includes/auth.php'); ?>
<?php include_once('includes/logout.php'); ?>
<?php include_once('includes/connect.php'); ?>
<?php
// Query
// $sql = "SELECT projectId, projectName FROM tblprojects ORDER BY projectId DESC";
// $result = mysqli_query($conn, $sql);

//insert record
// if(isset($_POST['newproject']) && isset($_POST['submitnew'])) {
//     $new = $_POST['newproject'];

//     $sqlnew = "INSERT INTO tblprojects (projectName) VALUES ('$new')";

//     if (mysqli_query($conn, $sqlnew)) {
//         $text = "Record Inserted successfully.";
//         $color = "blue";
//     }
//     else {
//         $text = 'Error: ' . mysqli_error($conn);
//         $color = "red";
//     }
//     $insertGoTo = sprintf("projectnames.php?action=new&text=%s&color=%s",$text,$color);
//     header(sprintf("Location: %s", $insertGoTo));
// }

//query for edit form
if(isset($_GET['action']) && $_GET['action']=='edit' && isset($_GET['projectId'])) {
    $projectid = $_GET['projectId'];

    $sqledit = sprintf("SELECT projectId, projectName FROM tblprojects WHERE projectId = %u",$projectid);
    $resultedit = mysqli_query($conn, $sqledit);
    $row_edit = mysqli_fetch_assoc($resultedit);
}

//Updating Record
if(isset($_POST['submitedit']) && isset($_POST['editprojectName']) && isset($_POST['editprojectId']))	{
    $projectname = $_POST['editprojectName'];
    $projectid = $_POST['editprojectId'];

    $sqlupdate = sprintf("UPDATE tblprojects SET projectName='%s' WHERE projectId=%u", $projectname, $projectid);

    if (mysqli_query($conn, $sqlupdate)) {
        $text = "Record updated successfully.";
        $color = "orange";
    } else {
        $text = "Error updating record: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("projectnames.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}

//query for delete form
if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['projectId'])) {
    $projectid = $_GET['projectId'];

    $sqldelete = sprintf("SELECT projectId, projectName FROM tblprojects WHERE projectId = %u",$projectid);
    $resultdelete = mysqli_query($conn, $sqldelete);
    $row_delete = mysqli_fetch_assoc($resultdelete);
}

//Deleting record
if(isset($_POST['submitdelete']) && isset($_POST['deleteprojectId'])) {
    $projectid = $_POST['deleteprojectId'];

    $sqldelete = sprintf("DELETE FROM tblprojects WHERE projectId = %u",$projectid);

    if (mysqli_query($conn, $sqldelete)) {
        $text = "Record deleted successfully";
        $color = "#660000";
    } else {
        $text = "Error deleting record: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("projectnames.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}

//Delete selected record
if(isset($_POST['submitalldelete']) && isset($_POST['checknum'])) {
    $list = $_POST['checknum'];

    foreach($list as $name) {
        $sqlalldelete = sprintf("DELETE FROM tblprojects WHERE projectName = '%s'",$name);
        $resultalldelete = mysqli_query($conn, $sqlalldelete);
    }

    if (mysqli_query($conn, $sqlalldelete)) {
        $text = "All Records deleted successfully";
        $color = "#660000";
    } else {
        $text = "Error deleting records: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("projectnames.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}
?>

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

                    <?php if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['projectId'])) { ?>
                        <div class="row">
                            <div class="col-md-6">

                                <!-- Input Fields -->
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <span class="panel-title">Are you sure you want to Delete <?php if(isset($row_delete['projectName'])) {echo $row_delete['projectName'];} ?>?</span>
                                    </div>

                                    <div class="panel-body">
                                        <form class="form-horizontal" name="deleteform" method="POST" action="projectnames.php" role="form">
                                            <div class="form-group">
                                                <input type="hidden" name="deleteprojectId" value="<?php if(isset($row_delete['projectId'])){ echo $row_delete['projectId'];} ?>" >
                                                <h4>&emsp;&emsp;<?php if(isset($row_delete['projectName'])){ echo $row_delete['projectName'];} ?></h4>
                                            </div>
                                            <div align="right" class="">
                                                <a href="projectnames.php" class="btn btn-default " role="button"> Cancel Delete </a>
                                                <button type="submit" name="submitdelete" class="btn btn-danger">Delete Project</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>

                    <?php if(isset($_POST['deleteall']) && isset($_POST['checknum'])) { ?>
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Input Fields -->
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <span class="panel-title">Are you sure you want to Delete Records?</span>
                                    </div>

                                    <div class="panel-body">
                                        <form class="form-horizontal" name="deleteallform" method="POST" action="projectnames.php" role="form">
                                            <div class="form-group">

                                                <?php
                                                $list = $_POST['checknum'];
                                                foreach($list as $name) { ?>
                                                    <input type="hidden" name="checknum[]" value="<?php echo $name; ?>" checked >
                                                    <p>&emsp;&emsp;<?php echo $name; ?></p>
                                                <?php } ?>

                                            </div>
                                            <div align="right" class="">
                                                <a href="projectnames.php" class="btn btn-default " role="button"> Cancel Delete </a>
                                                <button type="submit" name="submitalldelete" class="btn btn-danger">Delete Projects</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>

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
                                        <!-- <th>Select</th> -->
                                        <th>Index</th>
                                        <th>Project Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <!-- <th>Select</th> -->
                                        <th>Index</th>
                                        <th>Project Name</th>
                                        <th>Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
<!--                                     <?php if (mysqli_num_rows($result) > 0) {
                                        $i=1;
                                        while($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td>&emsp;<input type="checkbox" name="checknum[]" value="<?php echo $row['projectName']; ?>"></td>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['projectName']; ?></td>
                                                <td>
                                                    <a href="projectnames.php?action=edit&projectId=<?php echo $row['projectId']; ?>" class="btn btn-warning btn-sm btn-rounded btn-gradient"><i class="fa fa-pencil"></i> Edit </a>
                                                    <a href="projectnames.php?action=delete&projectId=<?php echo $row['projectId']; ?>" class="btn btn-danger btn-sm btn-rounded btn-gradient"><i class="fa fa-times-circle"></i> Delete </a>
                                                </td>
                                            </tr>
                                            <?php $i++; }/*whileend*/
                                    }/*ifend*/ ?> -->


                                    </tbody>
                                </table>
                                <!-- <button type="submit" name="deleteall" class="btn btn-danger btn-md dark">Delete Selected</button> -->
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
<?php
mysqli_free_result($result);
if(isset($_GET['action']) && $_GET['action']=='edit') {
    mysqli_free_result($resultedit);
}
if(isset($_GET['action']) && $_GET['action']=='delete') {
    mysqli_free_result($resultdelete);
}
mysqli_close($conn);
?>

