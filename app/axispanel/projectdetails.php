<?php if (!isset($_SESSION)) {
    session_start();
} ?>
<?php include_once('includes/auth.php'); ?>
<?php include_once('includes/logout.php'); ?>
<?php include_once('includes/connect.php'); ?>
<?php
function uploadimages() {
    $target_dir = "../images/projects/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submitnew"])||isset($_POST["submitedit"])||isset($_POST["submitadd"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $_SESSION['uploadimage'] = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $_SESSION['uploadimage'] =  "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION['uploadimage'] =  "Sorry, image already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 350000) {
        $_SESSION['uploadimage'] =  "Sorry, your image is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
        $_SESSION['uploadimage'] =  "Sorry, only JPG, JPEG & PNG files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['uploadOk'] = 0;
        $_SESSION['uploaderror'] =  "Sorry, your image was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $_SESSION['uploadOk'] = 1;
            $_SESSION['uploaderror'] =  "The image ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        } else {
            $_SESSION['uploadOk'] = 0;
            $_SESSION['uploaderror'] =  "Sorry, there was an error uploading your image.";
        }
    }
}
?>
<?php
// Projects Query
if(isset($_GET['projecttype']) || isset($type)) {
    $_SESSION['projecttype'] = $_GET['projecttype'];
}
$type = $_SESSION['projecttype'];
$sql = sprintf("SELECT * FROM tblprojectdetails WHERE prdetailsType Like '%s' ORDER BY prdetailsId DESC", $type);
$result = mysqli_query($conn, $sql);


//Projects Names Query
$sqlprojects = "SELECT * FROM tblprojects ORDER BY projectName ASC";
$resultprojects = mysqli_query($conn, $sqlprojects);


//project types Query
$sqltypes = "SELECT * FROM tblprojecttype ORDER BY projectTypeName ASC";
$resulttypes = mysqli_query($conn, $sqltypes);


//insert record
if(isset($_POST['submitnew'])) {
    $title = $_POST['prdetailsTitle'];
    $projectname = $_POST['prdetailsName'];
    $projecttype = $_POST['prdetailsType'];
    $projectsubtype = $_POST['prdetailsSubtype'];
    $location = $_POST['location'];
    $projectdate = $_POST['projectDate'];
    $description = $_POST['description'];
    $notes = $_POST['notes'];
    $new = $_POST['new'];
    $projectimage = $_POST['projectImage'];

    $sqlnew = "INSERT INTO tblprojectdetails (prdetailsTitle, prdetailsName, prdetailsType, prdetailsSubtype, location, projectDate, description, notes, new, projectImage)
           VALUES ('$title', '$projectname', '$projecttype', '$projectsubtype', '$location', '$projectdate', '$description', '$notes', ".($new?1:0).", '$projectimage')";

    if (mysqli_query($conn, $sqlnew)) {
        $text = "Record Inserted successfully.";
        $color = "blue";
        uploadimages();
    }
    else {
        $text = 'Error: ' . mysqli_error($conn);
        $color = "red";
    }

    $insertGoTo = sprintf("projectdetails.php?action=new&text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));

}

//query for edit form
if(isset($_GET['action']) && $_GET['action']=='edit') {
    $prdetailsid = $_GET['prdetailsId'];

    $sqledit = sprintf("SELECT * FROM tblprojectdetails WHERE prdetailsId = %u",$prdetailsid);
    $resultedit = mysqli_query($conn, $sqledit);
    $row_edit = mysqli_fetch_assoc($resultedit);
}

//Updating Record
if(isset($_POST['submitedit']))	{
    $projectdetailid = $_POST['prdetailsId'];
    $title = $_POST['prdetailsTitle'];
    $projectname = $_POST['prdetailsName'];
    $projecttype = $_POST['prdetailsType'];
    $projectsubtype = $_POST['prdetailsSubtype'];
    $location = $_POST['location'];
    $projectdate = $_POST['projectDate'];
    $description = $_POST['description'];
    $notes = $_POST['notes'];
    $new = $_POST['new'];
    $projectimage = $_POST['projectImage'];
    uploadimages();

    $sqlupdate = sprintf("UPDATE tblprojectdetails SET prdetailsTitle='%s', prdetailsName='%s', prdetailsType='%s', prdetailsSubtype='%s', location='%s',
                              projectDate='%s', description='%s', notes='%s', new='%s', projectImage='%s'
                         WHERE prdetailsId=%u", $title, $projectname, $projecttype, $projectsubtype, $location, $projectdate,
                                $description, $notes, $new?1:0, $projectimage, $projectdetailid);

    if($_SESSION['uploadOk']==1){
        if (mysqli_query($conn, $sqlupdate)) {
            $text = "Record updated successfully.";
            $color = "orange";
        } else {
            $text = "Image Uploaded but Error updating record: " . mysqli_error($conn);
            $color = "red";
        }
        $insertGoTo = sprintf("projectdetails.php?text=%s&color=%s",$text,$color);
        header(sprintf("Location: %s", $insertGoTo));
    }
    else
    {
        if (mysqli_query($conn, $sqlupdate)) {
            $text = "Record updated successfully, But Image Error.";
            $color = "orange";
        } else {
            $text = "Error updating record: " . mysqli_error($conn);
            $color = "red";
        }
        $insertGoTo = sprintf("projectdetails.php?text=%s&color=%s",$text,$color);
        header(sprintf("Location: %s", $insertGoTo));
    }
}

//query for delete form
if(isset($_GET['action']) && $_GET['action']=='delete') {
    $projectdetailid = $_GET['prdetailsId'];

    $sqldelete = sprintf("SELECT * FROM tblprojectdetails WHERE prdetailsId = %u",$projectdetailid);
    $resultdelete = mysqli_query($conn, $sqldelete);
    $row_delete = mysqli_fetch_assoc($resultdelete);
}

//Deleting record
if(isset($_POST['submitdelete']) && isset($_POST['deleteprojectId'])) {
    $projectdetailid = $_POST['deleteprojectId'];
    $projectimage = $_POST['deleteprojectImage'];

    $sqldelete = sprintf("DELETE FROM tblprojectdetails WHERE prdetailsId = %u",$projectdetailid);

    if (file_exists("../images/projects/".$projectimage)) {
        unlink("../images/projects/".$projectimage);
    }

    if (mysqli_query($conn, $sqldelete)) {
        $text = "Record deleted successfully";
        $color = "#660000";
    } else {
        $text = "Error deleting record: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("projectdetails.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}

//Delete selected record
if(isset($_POST['submitalldelete']) && isset($_POST['checknum'])) {
    $list = $_POST['checknum'];

    foreach($list as $name) {
        $sqldeleteall = sprintf("SELECT projectImage FROM tblprojectdetails WHERE prdetailsTitle = '%s'",$name);
        $resultdeleteall = mysqli_query($conn, $sqldeleteall);
        $row_deleteall = mysqli_fetch_assoc($resultdeleteall);
        $projectimage = $row_deleteall['projectImage'];

        if (file_exists("../images/projects/".$projectimage)) {
            unlink("../images/projects/".$projectimage);
        }

        $sqlalldelete = sprintf("DELETE FROM tblprojectdetails WHERE prdetailsTitle = '%s'",$name);
        $resultalldelete = mysqli_query($conn, $sqlalldelete);
    }

    if (mysqli_query($conn, $sqlalldelete)) {
        $text = "All Records deleted successfully";
        $color = "#660000";
    } else {
        $text = "Error deleting records: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("projectdetails.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}


//query for Additional Images
if(isset($_GET['action']) && $_GET['action']=='addimage' && isset($_GET['prdetailsId'])) {
    $prdetailsId = $_GET['prdetailsId'];

    $sqladd = sprintf("SELECT * FROM tblprojectdetails WHERE prdetailsId = %u",$prdetailsId);
    $resultadd = mysqli_query($conn, $sqladd);
    $row_add = mysqli_fetch_assoc($resultadd);
}

//insert additional Item images
if(isset($_POST['submitadd'])) {
    $projectImageId = $_POST['prdetailsId'];
    $projectTitle = $_POST['projectTitle'];
    $imageName = $_POST['imageName'];
    $imageType = $_POST['imageType'];
    $imageSort = $_POST['imageSort'];
    uploadimages();

    if($_SESSION['uploadOk']==1){

        $sqlnewimage = "INSERT INTO tblprojectimages (imageType, projectTitle, imageName, imageSort)
           VALUES ('$imageType', '$projectTitle', '$imageName', '$imageSort')";

        if (mysqli_query($conn, $sqlnewimage)) {
            $text = "Record Inserted successfully.";
            $color = "blue";
        }
        else {
            $text = 'Error: ' . mysqli_error($conn);
            $color = "red";
        }

        $insertGoTo = sprintf("projectdetails.php?action=addimage&prdetailsId=%s&text=%s&color=%s",$projectImageId, $text, $color);
        header(sprintf("Location: %s", $insertGoTo));
    }
    else
    {
        $text = 'Error: Image Error ';
        $color = "red";
        $insertGoTo = sprintf("projectdetails.php?action=addimage&prdetailsId=%s&text=%s&color=%s",$projectImageId, $text, $color);
        header(sprintf("Location: %s", $insertGoTo));
    }
}

?>

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
                        <span>Create New Title</span>
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
                                <button type="button" name="submitnew" class="btn btn-primary" id="saveNewForm" > Create Brand</button>
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
                                    <div class="checkbox-custom checkbox-primary mb10">
                                        <input type="checkbox" id="new" name="new" >
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
            <div class="col-xs-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Additional Images for <b class="text-info" id='iboxname'></b></span>
                    </div>

                    <div class="panel-body">

                    <!-- SHOW IMAGES -->
                    <button type="button" style="margin:10px;" class="btn btn-info" data-toggle="collapse" data-target="#images-viewer">Images Panel</button>
                    
                    <!-- IMAGES CONTAINER -->
                    <div class="image-viewer collapse" id="images-viewer">
                        <!-- <div class="col--2 ">
                            <i class="fa fa-trash btn btn-warning btn-xs"></i>
                            <div class="image-wrapper" >
                                <img src="projectImages/Desert.jpg" class="img-thumbnail" alt="Cinque Terre" width="100" height="236"> 
                                    <p class=''> Before </p>
                            </div>
                            <div class="image-wrapper" >
                                <img src="projectImages/Penguins.jpg" class="img-thumbnail" alt="Cinque Terre" width="100" height="236"> 
                                    <p class=''> After </p>
                            </div>
                        </div> -->
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
                                <!-- <input type="hidden" name="prdetailsId" id="prdetailsId" value=""> -->
                                <input type="hidden" name="projectTitle" id="projectTitle" value="" >
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>

    <button class="btn btn-default btn-gradient" scrollto="#newFormContainer" id="openNewRecordForm"  ><i class="fa fa-plus"></i> Create New Project Detail </button>

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
                        <!-- <th>Image</th> -->
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
                        <!-- <th>Image</th> -->
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                 
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

<?php
unset($_SESSION['uploaderror']);
unset($_SESSION['uploadimage']);

mysqli_free_result($result);
mysqli_free_result($resultprojects);
mysqli_free_result($resulttypes);
if(isset($_GET['action']) && $_GET['action']=='edit') {
    mysqli_free_result($resultedit);
}
if(isset($_GET['action']) && $_GET['action']=='delete') {
    mysqli_free_result($resultdelete);
}
if(isset($_GET['action']) && $_GET['action']=='addimage') {
    mysqli_free_result($resultadd);
}
mysqli_close($conn);
?>