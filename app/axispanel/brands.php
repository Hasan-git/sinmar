<?php if (!isset($_SESSION)) {
    session_start();
} ?>
<?php include_once('includes/auth.php'); ?>
<?php include_once('includes/logout.php'); ?>
<?php include_once('includes/connect.php'); ?>
<?php
//Brands Query
$sql = "SELECT brandId, brandName FROM tblbrands ORDER BY brandId DESC";
$result = mysqli_query($conn, $sql);

//insert record
if(isset($_POST['newbrand']) && isset($_POST['submitnew'])) {
	$new = $_POST['newbrand'];

	$sqlnew = "INSERT INTO tblbrands (brandName) VALUES ('$new')";

	if (mysqli_query($conn, $sqlnew)) {
        $text = "Record Inserted successfully.";
        $color = "blue";
    }
    else {
		$text = 'Error: ' . mysqli_error($conn);
        $color = "red";
	}
    $insertGoTo = sprintf("brands.php?action=new&text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}

//query for edit form
if(isset($_GET['action']) && $_GET['action']=='edit' && isset($_GET['brandId'])) {
	$brandid = $_GET['brandId'];
	
	$sqledit = sprintf("SELECT brandId, brandName FROM tblbrands WHERE brandId = %u",$brandid);
	$resultedit = mysqli_query($conn, $sqledit);
    $row_edit = mysqli_fetch_assoc($resultedit);
}

//Updating Record
if(isset($_POST['submitedit']) && isset($_POST['editbrandName']) && isset($_POST['editbrandId']))	{
    $brandname = $_POST['editbrandName'];
    $brandid = $_POST['editbrandId'];

    $sqlupdate = sprintf("UPDATE tblbrands SET brandName='%s' WHERE brandId=%u", $brandname, $brandid);

    if (mysqli_query($conn, $sqlupdate)) {
        $text = "Record updated successfully.";
        $color = "orange";
    } else {
        $text = "Error updating record: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("brands.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}

//query for delete form
if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['brandId'])) {
    $brandid = $_GET['brandId'];

    $sqldelete = sprintf("SELECT brandId, brandName FROM tblbrands WHERE brandId = %u",$brandid);
    $resultdelete = mysqli_query($conn, $sqldelete);
    $row_delete = mysqli_fetch_assoc($resultdelete);
}

//Deleting record
if(isset($_POST['submitdelete']) && isset($_POST['deletebrandId'])) {
    $brandid = $_POST['deletebrandId'];

    $sqldelete = sprintf("DELETE FROM tblbrands WHERE brandId = %u",$brandid);

    if (mysqli_query($conn, $sqldelete)) {
        $text = "Record deleted successfully";
        $color = "#660000";
    } else {
        $text = "Error deleting record: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("brands.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}

//Delete selected record
if(isset($_POST['submitalldelete']) && isset($_POST['checknum'])) {
    $list = $_POST['checknum'];

    foreach($list as $name) {
        $sqlalldelete = sprintf("DELETE FROM tblbrands WHERE brandName = '%s'",$name);
        $resultalldelete = mysqli_query($conn, $sqlalldelete);
    }

    if (mysqli_query($conn, $sqlalldelete)) {
        $text = "All Records deleted successfully";
        $color = "#660000";
    } else {
        $text = "Error deleting records: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("brands.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}
?>

<?php $pagename="Item Brands"; ?>
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

            <?php if(isset($_GET['text'])){ echo '<h2 style="color:'. $_GET['color'] .';">' . $_GET['text'] . '</h2>';} ?>

			<?php if(isset($_GET['action']) && $_GET['action']=='new'){ ?>
			<div class="row">
			  <div class="col-md-6">

				<!-- Input Fields -->
				<div class="panel">
				  <div class="panel-heading">
					<span class="panel-title">Add New Brand</span>
				  </div>
				  
				  <div class="panel-body">
					<form class="form-horizontal" name="newform" method="POST" action="brands.php" role="form">
					  <div class="form-group">
						<label for="inputStandard" class="col-lg-3 control-label">Brand Name</label>
						<div class="col-lg-8">
						  <input type="text" name="newbrand" class="form-control" placeholder="Type Brand Name Here..." required>
						</div>
					  </div>
					  <div align="right" class="">
					    <a href="brands.php" class="btn btn-default " role="button"> Cancel </a>
                        <button type="submit" name="submitnew" class="btn btn-primary">Save Brand</button>
                      </div>
					</form>
				  </div>
				</div>
				
			  </div>
			</div>			  
			<div class="clearfix"></div>
			<?php } ?>	

			<?php if(isset($_GET['action']) && $_GET['action']=='edit'){ ?>	
			<div class="row">
			  <div class="col-md-6">

				<!-- Input Fields -->
				<div class="panel">
				  <div class="panel-heading">
					<span class="panel-title">Edit Brand <?php if(isset($row_edit['brandName'])) {echo $row_edit['brandName'];} ?></span>
				  </div>
				  
				  <div class="panel-body">
					<form class="form-horizontal" name="editform" method="POST" action="brands.php" role="form">
					  <div class="form-group">
						<label class="col-lg-3 control-label">Brand Name</label>
						<div class="col-lg-8">
                            <input type="hidden" name="editbrandId" value="<?php if(isset($row_edit['brandId'])){ echo $row_edit['brandId'];} ?>" >
							<input type="text" name="editbrandName" class="form-control" value="<?php if(isset($row_edit['brandName'])){ echo $row_edit['brandName'];} ?>" required>
						</div>
					  </div>
					  <div align="right" class="">
					    <a href="brands.php" class="btn btn-default " role="button"> Cancel </a>
                        <button type="submit" name="submitedit" class="btn btn-primary">Edit Brand</button>
                      </div>
					</form>
				  </div>
				</div>
				
			  </div>
			</div>
			<div class="clearfix"></div>
			<?php } ?>

            <?php if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['brandId'])) { ?>
                <div class="row">
                    <div class="col-md-6">

                        <!-- Input Fields -->
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <span class="panel-title">Are you sure you want to Delete <?php if(isset($row_delete['brandName'])) {echo $row_delete['brandName'];} ?>?</span>
                            </div>

                            <div class="panel-body">
                                <form class="form-horizontal" name="deleteform" method="POST" action="brands.php" role="form">
                                    <div class="form-group">
                                        <input type="hidden" name="deletebrandId" value="<?php if(isset($row_delete['brandId'])){ echo $row_delete['brandId'];} ?>" >
                                        <h4>&emsp;&emsp;<?php if(isset($row_delete['brandName'])){ echo $row_delete['brandName'];} ?></h4>
                                    </div>
                                    <div align="right" class="">
                                        <a href="brands.php" class="btn btn-default " role="button"> Cancel Delete </a>
                                        <button type="submit" name="submitdelete" class="btn btn-danger">Delete Brand</button>
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
                                <form class="form-horizontal" name="deleteallform" method="POST" action="brands.php" role="form">
                                    <div class="form-group">

                                        <?php
                                            $list = $_POST['checknum'];
                                            foreach($list as $name) { ?>
                                                <input type="hidden" name="checknum[]" value="<?php echo $name; ?>" checked >
                                                <p>&emsp;&emsp;<?php echo $name; ?></p>
                                        <?php } ?>

                                    </div>
                                    <div align="right" class="">
                                        <a href="brands.php" class="btn btn-default " role="button"> Cancel Delete </a>
                                        <button type="submit" name="submitalldelete" class="btn btn-danger">Delete Brand</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="clearfix"></div>
            <?php } ?>

			  <a href="brands.php?action=new" class="btn btn-default btn-gradient"><i class="fa fa-plus"></i> Add New Brand </a>

              <div class="panel panel-visible">
                <div class="panel-heading">
                  <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tags"></span>Item Brands</div>
                </div>

                <div class="panel-body pn">
                 <form name="table" method="POST" action="brands.php">
                  <table class="table table-striped table-hover" id="datatable3" cellspacing="0" width="100%">
                    <thead>
                      <tr>
						<th>Select</th>
                        <th>ID</th>
                        <th>Brand Name</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
						<th>Select</th>
                        <th>ID</th>
                        <th>Brand Name</th>
                        <th>Actions</th>
                      </tr>
                    </tfoot>
                    <tbody>
					<?php if (mysqli_num_rows($result) > 0) {
						 $i=1;
						 while($row_brands = mysqli_fetch_assoc($result)) { ?>
					  <tr>
						<td>&emsp;<input type="checkbox" name="checknum[]" value="<?php echo $row_brands['brandName']; ?>"></td>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row_brands['brandName']; ?></td>
						<td>
						  <a href="brands.php?action=edit&brandId=<?php echo $row_brands['brandId']; ?>" class="btn btn-warning btn-sm btn-rounded btn-gradient"><i class="fa fa-pencil"></i> Edit </a>
						  <a href="brands.php?action=delete&brandId=<?php echo $row_brands['brandId']; ?>" class="btn btn-danger btn-sm btn-rounded btn-gradient"><i class="fa fa-times-circle"></i> Delete </a>
						</td>
                      </tr>
					<?php $i++; }/*whileend*/ 
						}/*ifend*/ ?>
                    </tbody>
                  </table>
                    <button type="submit" name="deleteall" class="btn btn-danger btn-md dark">Delete Selected</button>
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
 
  <!-- Theme Javascript -->
  <script src="assets/js/utility/utility.js"></script>
  <script src="assets/js/demo/demo.js"></script>
  <script src="assets/js/main.js"></script>
  
  <script type="text/javascript">
  jQuery(document).ready(function() {

    "use strict";

    // Init Theme Core      
    Core.init();

    // Init Demo JS
    Demo.init();

    // Init Widget Demo JS
    // demoHighCharts.init();

    // Because we are using Admin Panels we use the OnFinish 
    // callback to activate the demoWidgets. It's smoother if
    // we let the panels be moved and organized before 
    // filling them with content from various plugins

    // Init plugins used on this page
    // HighCharts, JvectorMap, Admin Panels

    // Init Admin Panels on widgets inside the ".admin-panels" container
 //   $('.admin-panels').adminpanel({
 //     grid: '.admin-grid',
 //     draggable: true,
 //     preserveGrid: true,
 //     mobile: false,
 //     onStart: function() {
 //       // Do something before AdminPanels runs
 //     },
 //    onFinish: function() {
 //       $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload');

        // Init the rest of the plugins now that the panels
        // have had a chance to be moved and organized.
        // It's less taxing to organize empty panels
       
  //    },
  //    onSave: function() {
  //      $(window).trigger('resize');
  //    }
  //  });
	
    // MISC DATATABLE HELPER FUNCTIONS
	$('#datatable3').dataTable({
      "aoColumnDefs": [{
        'bSortable': false,
        'aTargets': [-1]
      }],
      "oLanguage": {
        "oPaginate": {
          "sPrevious": "",
          "sNext": ""
        }
      },
      "iDisplayLength": 10,
      "aLengthMenu": [
        [5, 10, 25, 50, -1],
        [5, 10, 25, 50, "All"]
      ],
      "sDom": '<"dt-panelmenu clearfix"Tfr>t<"dt-panelfooter clearfix"ip>',
      "oTableTools": {
        "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
      }
    });

    // Add Placeholder text to datatables filter bar
    $('.dataTables_filter input').attr("placeholder", "Enter Terms...");
	
	
  });
  </script>

  <!-- END: PAGE SCRIPTS -->

  
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