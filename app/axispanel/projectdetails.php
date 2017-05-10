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
    <?php if(isset($_SESSION['uploaderror'])){echo '<h3>' . $_SESSION['uploaderror'] . '</h3>'; } ?>
    <?php if(isset($_SESSION['uploadimage'])){echo '<h3>' . $_SESSION['uploadimage'] . '</h3>'; } ?>

    <?php if(isset($_GET['action']) && $_GET['action']=='new'){ ?>
        <div class="row">
            <div class="col-md-10">

                <!-- Input Fields -->
                <div class="panel">
                    <div class="panel-heading">
                        <span>Adding New Title</span>
                    </div>

                    <div class="panel-body">
                        <span class="text-danger-darker">Fields with * are required</span>
                        <form class="form-horizontal" name="newform" method="POST" action="projectdetails.php" enctype="multipart/form-data" role="form">
                            <div class="form-group admin-form">
                                <div class="col-sm-6">
                                    <label class="control-label">Detail Title*</label>
                                    <input type="text" name="prdetailsTitle" class="form-control" placeholder="Project Detail Title ..." required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Project Name*</label>
                                    <select name="prdetailsName" class="select2-single form-control" required>
                                        <option>Select Project</option>
                                        <?php while($rowproject = mysqli_fetch_assoc($resultprojects)) { ?>
                                            <option><?php echo $rowproject['projectName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-6">
                                    <label class="control-label">Detail Type*</label>
                                    <select name="prdetailsType" class="select2-single form-control" required>
                                        <option><?php echo $_SESSION['projecttype'] ?></option>
                                        <?php while($rowtype = mysqli_fetch_assoc($resulttypes)) { ?>
                                            <option><?php echo $rowtype['projectTypeName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Detail SubType</label>
                                    <input type="text" name="prdetailsSubtype" class="form-control" placeholder="Sub Type If Needed..." >
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-12">
                                    <label class="control-label">Title Description</label>
                                    <textarea name="description" class="form-control textarea-grow" rows="4" placeholder="Write Description Here..."></textarea>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-12">
                                    <label class="control-label">Title Notes</label>
                                    <textarea name="notes" class="form-control textarea-grow" rows="4" placeholder="Write Notes Here..."></textarea>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-3">
                                    <label class="control-label">Location</label>
                                    <input type="text" name="location" class="form-control" placeholder="Location..." >
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Project Date</label>
                                    <input type="date" name="projectDate" class="form-control" placeholder="Date..." required="required" >
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
                                        <input type="file" class="gui-file" name="fileToUpload" id="fileToUpload" onChange="document.getElementById('imagename').value = this.value.substr(12);" required>
                                        <input type="text" class="gui-input" name="projectImage" id="imagename" placeholder="Please Select An Image">
                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                    </label>
                                </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <div align="right" class="">
                                <a href="projectdetails.php" class="btn btn-default " role="button"> Cancel </a>
                                <button type="submit" name="submitnew" class="btn btn-primary"> Save Record </button>
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
            <div class="col-md-10">

                <!-- Input Fields -->
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Edit <?php if(isset($row_edit['prdetailsTitle'])) {echo $row_edit['prdetailsTitle'];} ?></span>
                    </div>

                    <div class="panel-body">
                        <span class="text-danger-darker">Fields with * are required</span>
                        <form class="form-horizontal" name="editform" method="POST" action="projectdetails.php" enctype="multipart/form-data" role="form">
                            <div class="form-group admin-form">
                                <div class="col-sm-6">
                                    <label class="control-label">Detail Title*</label>
                                    <input type="text" name="prdetailsTitle" value="<?php echo $row_edit['prdetailsTitle']; ?>" class="form-control" placeholder="Project Detail Title ..." required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Project Name*</label>
                                    <select name="prdetailsName" class="select2-single form-control" required>
                                        <option><?php echo $row_edit['prdetailsName']; ?></option>
                                        <?php while($rowproject = mysqli_fetch_assoc($resultprojects)) { ?>
                                            <option><?php echo $rowproject['projectName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-6">
                                    <label class="control-label">Detail Type*</label>
                                    <select name="prdetailsType" class="select2-single form-control" required>
                                        <option><?php echo $row_edit['prdetailsType']; ?></option>
                                        <?php while($rowtype = mysqli_fetch_assoc($resulttypes)) { ?>
                                            <option><?php echo $rowtype['projectTypeName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Detail SubType</label>
                                    <input type="text" name="prdetailsSubtype" value="<?php echo $row_edit['prdetailsSubtype']; ?>" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-12">
                                    <label class="control-label">Title Description</label>
                                    <textarea name="description" class="form-control textarea-grow" rows="4"><?php echo $row_edit['description']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-12">
                                    <label class="control-label">Title Notes</label>
                                    <textarea name="notes" class="form-control textarea-grow" rows="4"><?php echo $row_edit['notes']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-3">
                                    <label class="control-label">Location</label>
                                    <input type="text" name="location" value="<?php echo $row_edit['location']; ?>" class="form-control">
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Project Date</label>
                                    <input type="date" name="projectDate" value="<?php echo $row_edit['projectDate']; ?>" class="form-control" required="required" >
                                </div>
                                <div class="col-sm-1">
                                    <label class="control-label" for="new">Is New?</label>
                                    <div class="checkbox-custom checkbox-primary mb10">
                                        <input type="checkbox" id="new" name="new" <?php if($row_edit['new']) {echo 'checked';} ?>>
                                        <label for="new"></label>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <label class="control-label">Upload Image*</label>
                                    <label class="field prepend-icon file">
                                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                                        <input type="file" class="gui-file" name="fileToUpload" id="fileToUpload" onChange="document.getElementById('imagename').value = this.value.substr(12);">
                                        <input type="text" class="gui-input" value="<?php echo $row_edit['projectImage']; ?>" name="projectImage" id="imagename" placeholder="Please Select An Image">
                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                    </label>
                                </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <div align="right" class="">
                                <a href="projectdetails.php" class="btn btn-default " role="button"> Cancel </a>
                                <button type="submit" name="submitedit" class="btn btn-primary">Edit Item</button>
                                <input type="hidden" name="prdetailsId" value="<?php echo $row_edit['prdetailsId']; ?>">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
    <?php } ?>

    <?php if(isset($_GET['action']) && $_GET['action']=='addimage'){ ?>
        <div class="row">
            <div class="col-md-6">

                <!-- Input Fields -->
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Additional Images for <b class="text-info"><?php if(isset($row_add['prdetailsTitle'])) {echo $row_add['prdetailsTitle'];} ?></b></span>
                    </div>

                    <div class="panel-body">

                        <form class="form-horizontal" name="addform" method="POST" action="projectdetails.php" enctype="multipart/form-data" role="form">

                            <a href="#" class="btn btn-rounded btn-sm btn-info"><i class="fa fa-zoom"></i> View All Images </a>

                            <div class="clearfix"><br/></div>
                            <div class="form-group admin-form">
                                <div class="col-sm-10">
                                    <label class="control-label">Upload Image*</label>
                                    <label class="field prepend-icon file">
                                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                                        <input type="file" class="gui-file" name="fileToUpload" id="fileToUpload" onChange="document.getElementById('imagename').value = this.value.substr(12);" required>
                                        <input type="text" class="gui-input" name="imageName" id="imagename" placeholder="Please Select An Image">
                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group admin-form">
                                <div class="col-sm-5">
                                    <label class="control-label">Image Type*</label>
                                    <select name="imageType" class="select2-single form-control" required>
                                        <option>Select Image Type</option>
                                        <option>After</option>
                                        <option>Before</option>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <label class="control-label">Image Sort*</label>
                                    <input type="text" name="imageSort" class="form-control" >
                                </div>
                            </div>

                            <div class="clearfix"><br/></div>
                            <div align="right" class="">
                                <a href="projectdetails.php" class="btn btn-default " role="button"> Cancel </a>
                                <button type="submit" name="submitadd" class="btn btn-primary"> Add Image </button>
                                <input type="hidden" name="prdetailsId" value="<?php echo $row_add['prdetailsId']; ?>">
                                <input type="hidden" name="projectTitle" value="<?php echo $row_add['prdetailsTitle']; ?>" >
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
    <?php } ?>

    <?php if(isset($_GET['action']) && $_GET['action']=='delete') { ?>
        <div class="row">
            <div class="col-md-6">

                <!-- Input Fields -->
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <span class="panel-title">Are you sure you want to Delete <?php if(isset($row_delete['prdetailsTitle'])) {echo $row_delete['prdetailsTitle'];} ?>?</span>
                    </div>

                    <div class="panel-body">
                        <form class="form-horizontal" name="deleteform" method="POST" action="projectdetails.php" role="form">
                            <div class="form-group">
                                <input type="hidden" name="deleteprojectId" value="<?php if(isset($row_delete['prdetailsId'])){ echo $row_delete['prdetailsId'];} ?>" >
                                <input type="hidden" name="deleteprojectImage" value="<?php if(isset($row_delete['projectImage'])){ echo $row_delete['projectImage'];} ?>" >
                                <h4>&emsp;&emsp;<?php if(isset($row_delete['prdetailsTitle'])){ echo $row_delete['prdetailsTitle'];} ?></h4>
                            </div>
                            <div align="right" class="">
                                <a href="projectdetails.php" class="btn btn-default " role="button"> Cancel </a>
                                <button type="submit" name="submitdelete" class="btn btn-danger">Delete</button>
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
                        <form class="form-horizontal" name="deleteallform" method="POST" action="projectdetails.php" role="form">
                            <div class="form-group">

                                <?php
                                $list = $_POST['checknum'];
                                foreach($list as $name) { ?>
                                    <input type="hidden" name="checknum[]" value="<?php echo $name; ?>" checked >
                                    <p>&emsp;&emsp;<?php echo $name; ?></p>
                                <?php } ?>

                            </div>
                            <div align="right" class="">
                                <a href="projectdetails.php" class="btn btn-default " role="button"> Cancel  </a>
                                <button type="submit" name="submitalldelete" class="btn btn-danger"> Delete All </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="clearfix"></div>
    <?php } ?>

    <a href="projectdetails.php?action=new" class="btn btn-default btn-gradient"><i class="fa fa-plus"></i> Add New Project Detail </a>

    <div class="panel panel-visible">
        <div class="panel-heading">
            <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tags"></span><b class="text-primary"><?php echo strtoupper($_SESSION['projecttype']); ?></b> Project Details</div>
        </div>

        <div class="panel-body pn">
            <form name="table" method="POST" action="projectdetails.php">
                <table class="table table-striped table-hover" id="datatable3" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Select</th>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>New</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Select</th>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>New</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php if (mysqli_num_rows($result) > 0) {
                        $i=1;
                        while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td>&emsp;<input type="checkbox" name="checknum[]" value="<?php echo $row['prdetailsTitle']; ?>"></td>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['prdetailsTitle']; ?></td>
                                <td><?php echo $row['prdetailsName']; ?></td>
                                <td><?php echo $row['location']; ?></td>
                                <td><?php echo $row['projectDate']; ?></td>
                                <td>&emsp;<input type="checkbox" <?php if($row['new']){echo 'checked';} ?> disabled></td>
                                <td><?php echo $row['projectImage']; ?></td>
                                <td>
                                    <a href="projectdetails.php?action=addimage&prdetailsId=<?php echo $row['prdetailsId']; ?>" class="btn btn-info btn-xs btn-rounded btn-gradient"><i class="fa fa-plus"></i> Images </a>
                                    <a href="projectdetails.php?action=edit&prdetailsId=<?php echo $row['prdetailsId']; ?>" class="btn btn-warning btn-xs btn-rounded btn-gradient"><i class="fa fa-pencil"></i> Edit </a>
                                    <a href="projectdetails.php?action=delete&prdetailsId=<?php echo $row['prdetailsId']; ?>" class="btn btn-danger btn-xs btn-rounded btn-gradient"><i class="fa fa-times-circle"></i> Delete </a>
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

    <!-- Select2 Plugin Plugin -->
    <script src="vendor/plugins/select2/select2.min.js"></script>

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

            // Init Select2 - Basic Single
            $(".select2-single").select2();

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