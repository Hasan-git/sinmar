<?php if (!isset($_SESSION)) {
    session_start();
} ?>
<?php include_once('includes/auth.php'); ?>
<?php include_once('includes/logout.php'); ?>

<?php $pagename="Item Details"; ?>
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

        <!-- Tabs -->
        <link rel="stylesheet" type="text/css" href="vendor/plugins/tabs/stylesheets/styles.css">

        <!-- dropzone -->
        <link rel="stylesheet" type="text/css" href="vendor/plugins/dropzone.v2/dropzone.css">

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

                    <!-- NEW ITEM -->
                    <!-- NEW ITEM -->
                    <!-- NEW ITEM -->
                    <div class="row j-hide" id="newFormContainer">
                        <div class="col-md-10">
                            <!-- Input Fields -->
                            <div class="panel">
                                <div class="panel-heading">
                                    <span>Adding New Item</span>
                                </div>

                                <div class="panel-body">
                                    <!-- <span class="text-danger-darker">Fields with * are required</span> -->
                                    <form class="form-horizontal" name="newform" id="newform" method="POST" action="" enctype="multipart/form-data" role="form">

                                        <input type="hidden" name="itemType" value="Appliances">   
                                        <div class="form-group admin-form">
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Name*</label>
                                                <input type="text" data-validation="required" name="itemName" id="itemName" class="form-control" placeholder="Item Name..." required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Brand*</label>
                                                <br/>
                                                <select name="brandName" data-validation="required" id="brandName" class="select2-single form-control" required>
                                                    <option value="">Select Brand</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Category*</label>
                                                <br/>
                                                <select name="categoryName" data-validation="required" id="categoryName" class="select2-single form-control" required>
                                                    <option value="">Select Category</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group admin-form">
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Model</label>
                                                <input type="text" name="model"  id="model" class="form-control" placeholder="Item Model..." >
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Size</label>
                                                <input type="text" name="itemSize" id="itemSize" class="form-control" placeholder="Item Size..." >
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Color</label>
                                                <input type="text" name="color" id="color" class="form-control" placeholder="Item Color..." >
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Price*</label>
                                              <div class="input-group">
                                                <input type="number" data-validation="required" name="price" id="price" class="form-control" placeholder="Item Price..." required>
                                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="form-group admin-form">
                                            <div class="col-sm-12">
                                                <label class="control-label">Item Description</label>
                                                <textarea name="description" id="description" class="form-control textarea-grow" rows="4" placeholder="Write Description Here..."></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group admin-form">
                                            <div class="col-sm-2">
                                                <label class="control-label" for="new">Item New?</label>
                                                <div class="checkbox-custom checkbox-primary mb10">
                                                    <input type="checkbox" id="new" name="new" checked>
                                                    <label for="new"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label">Offered</label>
                                                <div class="checkbox-custom checkbox-warning">
                                                    <input type="checkbox" id="offer" name="offer">
                                                    <label for="offer"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Offer Price</label>
                                               <div class="input-group">
                                                <input type="number" name="offerPrice" id="offerPrice" class="form-control" id="offerprice" placeholder="Offer Price..." required disabled>
                                                <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                               </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="control-label">Upload Image Item*</label>
                                                <label class="field prepend-icon file">
                                                    <span class="button bg-primary" style="color: white;">Choose Image</span>
                                                    <input data-validation="required" type="file" class="gui-file" name="itemImage" id="itemImage" onChange="document.getElementById('imagename').value = this.value.substr(12);" required>
                                                    <input data-validation="required" type="text" class="gui-input" name="imagename" id="imagename" placeholder="Please Select An Image">
                                                    <label class="field-icon"><i class="fa fa-upload"></i></label>
                                                </label>
                                            </div>

                                            <div class="col-xs-12 text-center" style="padding: 30px 15px;">
                                                <div class="col-xs-12">
                                                    <label>Drag your additional Images here</label>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div id="myId" class="dropzone" style="min-height: 200px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"><br/></div>
                                        <input type="hidden" name="itemId" id="itemId" value="">


                                        <div align="right" class="">
                                            <button type="button" class="btn btn-default" role="button" id="cancelNewForm" > Cancel </button>
                                            <button type="button" name="submitnew" class="btn btn-primary" id="saveNewForm" > Create Item</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>


                        <!-- EDIT ITEM -->
                        <!-- EDIT ITEM -->
                        <!-- EDIT ITEM -->
                    <div class="row  j-hide" id="editFormContainer">
                        <div class="col-md-10">
                            <div class="panel">
                                <div class="panel-heading">
                                    <span class="panel-title">Edit <span class="text-info" id="nfBoxName"></span>  Item </span>
                                </div>

                                <div class="panel-body">
                                    <span class="text-danger-darker">Fields with * are required</span>
                                    <form class="form-horizontal" name="editform" id="editForm" method="POST" action="" enctype="multipart/form-data" role="form">
                                        <input type="hidden" name="itemType" value="Appliances"> 
                                        <div class="form-group admin-form">

                                            <!-- <div class="col-sm-3">

                                                <label class="control-label">Item Type*</label>

                                                <select name="itemType" data-validation="required" id="itemType" class="form-control" >
                                                    <option value="Appliances">Appliances</option>
                                                </select>

                                            </div>  -->


                                            <div class="col-sm-3">

                                                <label class="control-label">Item Name*</label>
                                                <input type="text" data-validation="required" name="itemName" id="itemName" value="" class="form-control" placeholder="Item Name..." required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Brand*</label>
                                                <br>
                                                <select data-validation="required" name="brandName" id="brandName" class="select2-single form-control" required>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Category*</label>
                                                <br>
                                                <select data-validation="required" name="categoryName" id="categoryName" class="select2-single form-control" required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group admin-form">
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Model</label>
                                                <input type="text" name="model" id="model" value="" class="form-control" placeholder="Item Model..." >
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Size</label>
                                                <input type="text" name="itemSize" id="itemSize" value="" class="form-control" placeholder="Item Size..." >
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Color</label>
                                                <input type="text" name="color" id="color" value="" class="form-control" placeholder="Item Color..." >
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Item Price*</label>
                                                <div class="input-group">
                                                    <input data-validation="required" type="number" name="price" id="price" value="" class="form-control" placeholder="Item Price..." required>
                                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group admin-form">
                                            <div class="col-sm-12">
                                                <label class="control-label">Item Description</label>
                                                <textarea name="description" id="description" class="form-control textarea-grow" rows="4" placeholder="Write Description Here..."></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group admin-form">
                                            <div class="col-sm-2">
                                                <label class="control-label" for="new">Item New?</label>
                                                <div class="">
                                                    <input type="checkbox" style="width: 40px;" class="form-control" id="new" name="new"  >
                                                    <label for="new"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label">Offered</label>
                                                <div class="">
                                                    <input type="checkbox" style="width: 40px;" class="form-control"  id="offer" name="offer" >
                                                    <label for="offer"></label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Offer Price</label>
                                                <div class="input-group">
                                                    <input type="number" name="offerPrice" id="offerPrice" value=""  class="form-control" id="offerprice" placeholder="Offer Price..." required>
                                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="control-label">Upload Image Item*</label>
                                                <label class="field prepend-icon file">
                                                    <span class="button bg-primary" style="color: white;">Choose Image</span>
                                                    <input type="file" class="gui-file" name="itemImage" id="itemImage" onchange="document.getElementById('imagenameEdit').value = this.value.substr(12);" >
                                                    <input data-validation="required" type="text" name="itemImageName" value="" class="gui-input" id="imagenameEdit" placeholder="Please Select An Image" >
                                                    <label class="field-icon"><i class="fa fa-upload"></i></label>
                                                </label>
                                            </div>

                                            <div class="col-xs-12 text-center" style="padding: 30px 15px;">
                                                <div class="col-xs-12">
                                                    <label>Drag additional Item Images</label>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div id="dropzoneEdit" class="dropzone" style="min-height: 200px;"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clearfix"><br/></div>
                                            <input type="hidden" name="itemId" id="itemId" value="">

                                        <div align="right" class="">
                                            <button type="button" class="btn btn-default " role="button" id="cancelEditForm"> Cancel </button>
                                            <button type="button" name="submitedit" data-row='' class="btn btn-primary" id="saveEditForm">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <button class="btn btn-default btn-gradient" scrollto="#newFormContainer" id="openNewRecordForm"><i class="fa fa-plus"></i> Add New Item </button>

                    <div class="panel panel-visible">
                        <div class="panel-heading">
                            <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tags"></span><b class="text-primary">Appliances</b> Item Details</div>
                        </div>

                        <div class="panel-body pn">
                            <form name="table" method="POST" action="">
                                <table class="table table-striped table-hover" id="datatable3" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>New</th>
                                        <th>Offer</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>New</th>
                                        <th>Offer</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                        <!-- Body table added by jquery code -->
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

        <!-- MODAL TEMPLATE for delete Brand -->
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

    <!-- Plugins -->
    <script src="vendor/plugins/toaster/toastr.min.js"></script>
    <script src="vendor/plugins/modal/remodal.js"></script>
    <script src="vendor/plugins/jqueryFormValidator/form-validator/jquery.form-validator.js"></script>
    <script type="text/javascript" src="vendor/plugins/tabs/javascripts/vendor/jquery.tabslet.min.js"></script>
    <script type="text/javascript" src="vendor/plugins/tabs/javascripts/vendor/rainbow-custom.min.js"></script>
    <script type="text/javascript" src="vendor/plugins/tabs/javascripts/vendor/jquery.anchor.js"></script>
    <script type="text/javascript" src="vendor/plugins/dropzone/dropzone.min.js"></script>

    <!-- Theme Javascript -->
    <script src="assets/js/utility/utility.js"></script>
    <script src="assets/js/demo/demo.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/controllers/appliances.js"></script>


    </body>

    </html>
