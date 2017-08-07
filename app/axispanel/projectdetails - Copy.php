<?php if (!isset($_SESSION)) {
    session_start();
} ?>
<?php include_once('includes/auth.php'); ?>
<?php include_once('includes/logout.php'); ?>

<?php $pagename="Project Details"; ?>
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

              <!-- NEW PROJECT -->
              <!-- NEW PROJECT -->
              <!-- NEW PROJECT -->
        <div class="row j-hide" id="newFormContainer" >
            <div class="col-md-10">
                <div class="panel">
                    <div class="panel-heading">
                        <span>Create New Detail</span>
                    </div>

                    <div class="panel-body">
                        <span class="text-danger-darker">Fields with * are required</span>
                        <form class="form-horizontal" name="newform" id="newform"  method="POST" action="" enctype="multipart/form-data" role="form">
                            <div class="form-group admin-form">
                                <div class="col-sm-6">
                                    <label class="control-label">Detail Title*</label>
                                    <input type="text" data-validation="required" name="prdetailsTitle" id="prdetailsTitle" class="form-control" placeholder="Project Detail Title ..." required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Project Name*</label>
                                    <select data-validation="required" name="prdetailsName" id="prdetailsName" class="select2-single form-control" required>
                                        <option>Select Project</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-6">
                                    <label class="control-label">Detail Type*</label>
                                    <select data-validation="required" name="prdetailsType" id="prdetailsType" class="select2-single form-control" required>
                                        
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Detail SubType</label>
                                    <input type="text" name="prdetailsSubtype" id="prdetailsSubtype" class="form-control" placeholder="Sub Type If Needed..." >
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-12">
                                    <label class="control-label">Title Description</label>
                                    <textarea name="description" id="description" class="form-control textarea-grow" rows="4" placeholder="Write Description Here..."></textarea>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-12">
                                    <label class="control-label">Title Notes</label>
                                    <textarea name="notes" id="notes" class="form-control textarea-grow" rows="4" placeholder="Write Notes Here..."></textarea>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-3">
                                    <label class="control-label">Location</label>
                                    <input type="text" name="location" id="location" class="form-control" placeholder="Location..." >
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Project Date*</label>
                                    <input data-validation="required" type="date" name="projectDate" id="projectDate" class="form-control" placeholder="Date..." required="required" >
                                </div>
                                <div class="col-sm-1">
                                    <label class="control-label" for="new">Is New?</label>
                                    <div class="checkbox-custom checkbox-primary mb10">
                                        <input type="checkbox" id="new" name="new" checked>
                                        <label for="new"></label>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <label class="control-label">Upload Image*</label>
                                    <label class="field prepend-icon file">
                                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                                        <input type="file" class="gui-file" name="projectImage" id="projectImage" onChange="document.getElementById('imagename').value = this.value.substr(12);" required>
                                        <input data-validation="required" type="text" class="gui-input" name="projectImageName" id="imagename" placeholder="Please Select An Image">
                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                    </label>
                                </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <div align="right" class="">
                                <button type="button" class="btn btn-default" role="button" id="cancelNewForm" > Cancel </button>
                                <button type="button" name="submitnew" class="btn btn-primary" id="saveNewForm" > Create Detail</button>
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
        <div class="row j-hide" id="editFormContainer">
            <div class="col-md-10">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Edit <span class="text-info" id="nfBoxName"></span></span>
                    </div>

                    <div class="panel-body">
                        <span class="text-danger-darker">Fields with * are required</span>
                        <form class="form-horizontal" name="editform" id="editForm" method="POST" action="" enctype="multipart/form-data" role="form">
                            <div class="form-group admin-form">
                                <div class="col-sm-6">
                                    <label class="control-label">Detail Title*</label>
                                    <input data-validation="required" type="text" name="prdetailsTitle" id="prdetailsTitle" value="" class="form-control" placeholder="Project Detail Title ..." required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Project Name*</label>
                                    <select data-validation="required" name="prdetailsName" id="prdetailsName" class="select2-single form-control" required>
                                        <option value="">Select Project</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-6">
                                    <label class="control-label">Detail Type*</label>
                                    <select data-validation="required" name="prdetailsType" id="prdetailsType" class="select2-single form-control" required>
                                        <option value="">Select Type</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Detail SubType</label>
                                    <input type="text" name="prdetailsSubtype" id="prdetailsSubtype" value="" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-12">
                                    <label class="control-label">Title Description</label>
                                    <textarea name="description" id="description"  class="form-control textarea-grow" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-12">
                                    <label class="control-label">Title Notes</label>
                                    <textarea name="notes" id="notes" class="form-control textarea-grow" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-3">
                                    <label class="control-label">Location</label>
                                    <input type="text" name="location" id="location" value="" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Project Date*</label>
                                    <input data-validation="required" type="date" name="projectDate" id="projectDate" value="" class="form-control" required="required" >
                                </div>
                                <div class="col-sm-1">
                                    <label class="control-label" for="new">Is New?</label>
                                    <div class="">
                                        <input type="checkbox" style="width: 40px;" class="form-control" id="new" name="new" >
                                        <label for="new"></label>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <label class="control-label">Upload Image*</label>
                                    <label class="field prepend-icon file">
                                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                                        <input type="file" class="gui-file" name="projectImage" id="projectImage" onChange="document.getElementById('imagename2').value = this.value.substr(12);">
                                        <input data-validation="required" type="text" class="gui-input" value="" name="projectImageName" id="imagename2" placeholder="Please Select An Image">
                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                    </label>
                                </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <div align="right" class="">
                                <button type="button" class="btn btn-default " role="button" id="cancelEditForm"> Cancel </button>
                                <button type="button" name="submitedit" data-row='' class="btn btn-primary" id="saveEditForm">Save changes</button>
                                <input type="hidden" name="prdetailsId" id="prdetailsId" value="">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row j-hide" id="imagesContainer">
            <div class="col-xs-6">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Additional Images for <b class="text-info" id='iboxname'></b></span>
                    </div>

                    <div class="panel-body">

                    <!-- SHOW IMAGES -->
                    <button type="button" style="margin:10px;" class="btn btn-info" data-toggle="collapse" data-target="#images-viewer">Images Panel</button>
                    
                    <!-- IMAGES CONTAINER -->
                    <div class="image-viewer collapse" id="images-viewer">

                    </div>

                        <form class="form-horizontal" name="imagesform" id="imagesform" method="POST" action="" enctype="multipart/form-data" role="form">

                            <div class="clearfix"><br/></div>
                            <div class="form-group admin-form">
                                <div class="col-sm-10">
                                    <label class="control-label">Image (Before)*</label>
                                    <label class="field prepend-icon file">
                                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                                        <input type="file" data-validation="required" class="gui-file" name="imageBeforeFile" id="imageBeforeFile" onChange="document.getElementById('imageBefore').value = this.value.substr(12);" required>
                                        <input type="text" data-validation="required" class="gui-input" name="imageBefore" id="imageBefore" placeholder="Please Select An Image">
                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-10">
                                    <label class="control-label">Image (After)*</label>
                                    <label class="field prepend-icon file">
                                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                                        <input type="file" data-validation="required" class="gui-file" name="imageAfterFile" id="imageAfterFile" onChange="document.getElementById('imageAfter').value = this.value.substr(12);" required>
                                        <input type="text" data-validation="required" class="gui-input" name="imageAfter" id="imageAfter" placeholder="Please Select An Image">
                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                    </label>
                                </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <div align="right" class="">
                                <button type="button" class="btn btn-default " role="button" id="cancelImagesForm"> Cancel </button>
                                <button type="button" name="submitedit" data-row='' class="btn btn-primary" id="saveImagesForm">Save changes</button>

                                <input type="hidden" name="projectTitle" id="projectTitle" value="" >
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-2">
                <button class="btn btn-default btn-gradient" scrollto="#newFormContainer" id="openNewRecordForm"  ><i class="fa fa-plus"></i> Create New Project Detail </button>
            </div>
            <div class="col-xs-4"></div>
            <div class="col-xs-5 input-group" style="padding-left:50px;">
                <span class="input-group-addon" id="basic-addon1">Switch Project</span>            
                <select id="projectTypeCtrl" class="form-control">
                </select>
            </div>
            <div class="col-xs-1"></div>
        </div>

        
    
    <div class="panel panel-visible">
        <div class="panel-heading">
            <div class="panel-title hidden-xs" ><span class="glyphicon glyphicon-tags"></span><b class="text-primary" id="PDName" ></b> Project Details</div>
        </div>

        <div class="panel-body pn">
            <form name="table" method="POST" action="projectdetails.php">
                <table class="table table-striped table-hover" id="datatable3" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>New</th>

                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>New</th>

                        <th>Action</th>
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

    <!-- Select2 Plugin Plugin -->
    <script src="vendor/plugins/select2/select2.min.js"></script>

    <!-- plugins -->
    <script src="vendor/plugins/toaster/toastr.min.js"></script>
    <script src="vendor/plugins/modal/remodal.js"></script>
    <script src="vendor/plugins/jqueryFormValidator/form-validator/jquery.form-validator.js"></script>

    <!-- Theme Javascript -->
    <script src="assets/js/utility/utility.js"></script>
    <script src="assets/js/demo/demo.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/controllers/projectDetails.js"></script>

    <!-- END: PAGE SCRIPTS -->


    </body>

    </html>
