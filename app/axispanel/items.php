<?php if (!isset($_SESSION)) {
    session_start();
} ?>
<?php include_once('includes/auth.php'); ?>
<?php include_once('includes/logout.php'); ?>
<?php include_once('includes/connect.php'); ?>
<?php
function uploadimages() {
    $target_dir = "../images/items/";
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
    // Check if $uploadOk is set to 0 by an error.
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
//Brands Query
$sqlbrand = "SELECT * FROM tblbrands ORDER BY brandName ASC";
$resultbrand = mysqli_query($conn, $sqlbrand);


//Categories Query
$sqlcategory = "SELECT * FROM tblcategories ORDER BY categoryName ASC";
$resultcategory = mysqli_query($conn, $sqlcategory);


// Items Query
if(isset($_GET['type']) || isset($type)) {
    $_SESSION['type'] = $_GET['type'];
}
    $type = $_SESSION['type'];
    $sql = sprintf("SELECT * FROM tblitems WHERE itemType Like '%s' ORDER BY itemId DESC", $type);
    $result = mysqli_query($conn, $sql);

//query for Additional Images
if(isset($_GET['action']) && $_GET['action']=='addimage' && isset($_GET['itemId'])) {
    $itemid = $_GET['itemId'];

    $sqladd = sprintf("SELECT * FROM tblitems WHERE itemId = %u",$itemid);
    $resultadd = mysqli_query($conn, $sqladd);
    $row_add = mysqli_fetch_assoc($resultadd);
}

//insert additional Item images
if(isset($_POST['submitadd'])) {
    $itemid = $_POST['itemId'];
    $itemname = $_POST['itemName'];
    $itemimage = $_POST['itemImage'];
    uploadimages();

    if($_SESSION['uploadOk']==1){

        $sqlnewimage = "INSERT INTO tblitemimages (itemName, imageName)
           VALUES ('$itemname', '$itemimage')";

        if (mysqli_query($conn, $sqlnewimage)) {
            $text = "Record Inserted successfully.";
            $color = "blue";
        }
        else {
            $text = 'Error: ' . mysqli_error($conn);
            $color = "red";
        }

        $insertGoTo = sprintf("items.php?action=addimage&itemId=%s&text=%s&color=%s",$itemid, $text, $color);
        header(sprintf("Location: %s", $insertGoTo));
    }
    else
    {
        $text = 'Error: Image Error ';
        $color = "red";
        $insertGoTo = sprintf("items.php?action=addimage&itemId=%s&text=%s&color=%s",$itemid, $text, $color);
        header(sprintf("Location: %s", $insertGoTo));
    }
}

//insert record
if(isset($_POST['submitnew'])) {
    $itemtype = $_POST['itemType'];
    $itemname = $_POST['itemName'];
    $brandname = $_POST['brandName'];
    $categoryname = $_POST['categoryName'];
    $model = $_POST['model'];
    $itemsize = $_POST['itemSize'];
    $color = $_POST['color'];
    $price = (int)$_POST['price'];
    $description = $_POST['description'];
    $new = $_POST['new'];
    $offer = $_POST['offer'];
    $offerprice = (int)$_POST['offerPrice'];
    $itemimage = $_POST['itemImage'];

        $sqlnew = "INSERT INTO tblitems (itemType, itemName, brandName, categoryName, model, itemSize, color, price, description, new, offer, offerPrice, itemImage)
           VALUES ('$itemtype', '$itemname', '$brandname', '$categoryname', '$model', '$itemsize', '$color', '$price', '$description', ".($new?1:0).", ".($offer?1:0).", '$offerprice', '$itemimage')";

        if (mysqli_query($conn, $sqlnew)) {
            $text = "Record Inserted successfully.";
            $color = "blue";
            uploadimages();
        }
        else {
            $text = 'Error: ' . mysqli_error($conn);
            $color = "red";
        }

        $insertGoTo = sprintf("items.php?action=new&text=%s&color=%s",$text,$color);
        header(sprintf("Location: %s", $insertGoTo));

}

//query for edit form
if(isset($_GET['action']) && $_GET['action']=='edit' && isset($_GET['itemId'])) {
    $itemid = $_GET['itemId'];

    $sqledit = sprintf("SELECT * FROM tblitems WHERE itemId = %u",$itemid);
    $resultedit = mysqli_query($conn, $sqledit);
    $row_edit = mysqli_fetch_assoc($resultedit);
}

//Updating Record
if(isset($_POST['submitedit']))	{
    $itemid = $_POST['itemId'];
    $itemtype = $_POST['itemType'];
    $itemname = $_POST['itemName'];
    $brandname = $_POST['brandName'];
    $categoryname = $_POST['categoryName'];
    $model = $_POST['model'];
    $itemsize = $_POST['itemSize'];
    $color = $_POST['color'];
    $price = (int)$_POST['price'];
    $description = $_POST['description'];
    $new = $_POST['new'];
    $offer = $_POST['offer'];
    $offerprice = (int)$_POST['offerPrice'];
    $itemimage = $_POST['itemImage'];
    uploadimages();

    $sqlupdate = sprintf("UPDATE tblitems SET itemType='%s', itemName='%s', brandName='%s', categoryName='%s', model='%s',
                             itemSize='%s', color='%s', price=%u, description='%s', new='%s', offer='%s',
                             offerPrice=%u, itemImage='%s' WHERE itemId=%u", $itemtype, $itemname, $brandname, $categoryname,
                            $model, $itemsize, $color, $price, $description, $new?1:0, $offer?1:0, $offerprice, $itemimage, $itemid);

    if($_SESSION['uploadOk']==1){
        if (mysqli_query($conn, $sqlupdate)) {
            $text = "Record updated successfully.";
            $color = "orange";
        } else {
            $text = "Image Uploaded but Error updating record: " . mysqli_error($conn);
            $color = "red";
        }
        $insertGoTo = sprintf("items.php?text=%s&color=%s",$text,$color);
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
        $insertGoTo = sprintf("items.php?text=%s&color=%s",$text,$color);
        header(sprintf("Location: %s", $insertGoTo));
    }
}

//query for delete form
if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['itemId'])) {
    $itemid = $_GET['itemId'];

    $sqldelete = sprintf("SELECT * FROM tblitems WHERE itemId = %u",$itemid);
    $resultdelete = mysqli_query($conn, $sqldelete);
    $row_delete = mysqli_fetch_assoc($resultdelete);
}

//Deleting record
if(isset($_POST['submitdelete']) && isset($_POST['deleteitemId'])) {
    $itemid = $_POST['deleteitemId'];
    $itemimage = $_POST['deleteitemImage'];

    $sqldelete = sprintf("DELETE FROM tblitems WHERE itemId = %u",$itemid);

    if (file_exists("../images/items/".$itemimage)) {
        unlink("../images/items/".$itemimage);
    }

    if (mysqli_query($conn, $sqldelete)) {
        $text = "Record deleted successfully";
        $color = "#660000";
    } else {
        $text = "Error deleting record: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("items.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}

//Delete selected record
if(isset($_POST['submitalldelete']) && isset($_POST['checknum'])) {
    $list = $_POST['checknum'];

    foreach($list as $name) {
        $sqldeleteall = sprintf("SELECT itemImage FROM tblitems WHERE itemName = '%s'",$name);
        $resultdeleteall = mysqli_query($conn, $sqldeleteall);
        $row_deleteall = mysqli_fetch_assoc($resultdeleteall);
        $itemimage = $row_deleteall['itemImage'];

        if (file_exists("../images/items/".$itemimage)) {
            unlink("../images/items/".$itemimage);
        }

        $sqlalldelete = sprintf("DELETE FROM tblitems WHERE itemName = '%s'",$name);
        $resultalldelete = mysqli_query($conn, $sqlalldelete);
    }

    if (mysqli_query($conn, $sqlalldelete)) {
        $text = "All Records deleted successfully";
        $color = "#660000";
    } else {
        $text = "Error deleting records: " . mysqli_error($conn);
        $color = "red";
    }
    $insertGoTo = sprintf("items.php?text=%s&color=%s",$text,$color);
    header(sprintf("Location: %s", $insertGoTo));
}
?>

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
                                        <span>Adding New Item</span>
                                    </div>

                                    <div class="panel-body">
                                        <span class="text-danger-darker">Fields with * are required</span>
                                        <form class="form-horizontal" name="newform" method="POST" action="items.php" enctype="multipart/form-data" role="form">

                                            <div class="form-group admin-form">
                                                <div class="col-sm-2">
                                                    <label class="control-label">Item Type*</label>
                                                    <select name="itemType" class="form-control" required>
                                                        <option><?php echo $_SESSION['type'] ?></option>
                                                        <option><?php if($_SESSION['type']=='Hardware'){echo 'Appliances';} else echo 'Hardware'; ?></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="control-label">Item Name*</label>
                                                    <input type="text" name="itemName" class="form-control" placeholder="Item Name..." required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Brand*</label>
                                                    <select name="brandName" class="select2-single form-control" required>
                                                        <option value="">Select Brand</option>
                                                        <?php while($rowbrand = mysqli_fetch_assoc($resultbrand)) { ?>
                                                            <option value="<?php echo $rowbrand['brandName']; ?>"><?php echo $rowbrand['brandName']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Category*</label>
                                                    <select name="categoryName" class="select2-single form-control" required>
                                                        <option value="">Select Category</option>
                                                        <?php while($rowcategory = mysqli_fetch_assoc($resultcategory)) { ?>
                                                            <option value="<?php echo $rowcategory['categoryName']; ?>"><?php echo $rowcategory['categoryName']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group admin-form">
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Model</label>
                                                    <input type="text" name="model" class="form-control" placeholder="Item Model..." >
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Size</label>
                                                    <input type="text" name="itemSize" class="form-control" placeholder="Item Size..." >
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Color</label>
                                                    <input type="text" name="color" class="form-control" placeholder="Item Color..." >
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Price*</label>
                                                  <div class="input-group">
                                                    <input type="number" name="price" class="form-control" placeholder="Item Price..." required>
                                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="form-group admin-form">
                                                <div class="col-sm-12">
                                                    <label class="control-label">Item Description</label>
                                                    <textarea name="description" class="form-control textarea-grow" rows="4" placeholder="Write Description Here..."></textarea>
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
                                                        <input type="checkbox" id="offered" name="offer">
                                                        <label for="offered"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Offer Price</label>
                                                   <div class="input-group">
                                                    <input type="number" name="offerPrice" class="form-control" id="offerprice" placeholder="Offer Price..." required disabled>
                                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                                   </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="control-label">Upload Image Item*</label>
                                                    <label class="field prepend-icon file">
                                                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                                                        <input type="file" class="gui-file" name="fileToUpload" id="fileToUpload" onChange="document.getElementById('imagename').value = this.value.substr(12);" required>
                                                        <input type="text" class="gui-input" name="itemImage" id="imagename" placeholder="Please Select An Image">
                                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="clearfix"><br/></div>
                                            <div align="right" class="">
                                                <a href="items.php" class="btn btn-default " role="button"> Cancel </a>
                                                <button type="submit" name="submitnew" class="btn btn-primary"> Save Item </button>
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
                                        <span class="panel-title">Edit Item <?php if(isset($row_edit['itemName'])) {echo $row_edit['itemName'];} ?></span>
                                    </div>

                                    <div class="panel-body">
                                        <span class="text-danger-darker">Fields with * are required</span>
                                        <form class="form-horizontal" name="editform" method="POST" action="items.php" enctype="multipart/form-data" role="form">
                                            <div class="form-group admin-form">
                                                <div class="col-sm-2">
                                                    <label class="control-label">Item Type*</label>
                                                    <select name="itemType" class="form-control" required>
                                                        <option><?php echo $row_edit['itemType']; ?></option>
                                                        <option><?php if($row_edit['itemType']=='Hardware') {echo 'Appliances';}
                                                                      else {echo 'Hardware';} ?></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="control-label">Item Name*</label>
                                                    <input type="text" name="itemName" value="<?php echo $row_edit['itemName']; ?>" class="form-control" placeholder="Item Name..." required>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Brand*</label>
                                                    <select name="brandName" class="select2-single form-control" required>
                                                        <option><?php echo $row_edit['brandName']; ?></option>
                                                        <?php while($rowbrand = mysqli_fetch_assoc($resultbrand)) { ?>
                                                            <option value="<?php echo $rowbrand['brandName']; ?>"><?php echo $rowbrand['brandName']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Category*</label>
                                                    <select name="categoryName" class="select2-single form-control" required>
                                                        <option><?php echo $row_edit['categoryName']; ?></option>
                                                        <?php while($rowcategory = mysqli_fetch_assoc($resultcategory)) { ?>
                                                            <option value="<?php echo $rowcategory['categoryName']; ?>"><?php echo $rowcategory['categoryName']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group admin-form">
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Model</label>
                                                    <input type="text" name="model" value="<?php echo $row_edit['model']; ?>" class="form-control" placeholder="Item Model..." >
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Size</label>
                                                    <input type="text" name="itemSize" value="<?php echo $row_edit['itemSize']; ?>" class="form-control" placeholder="Item Size..." >
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Color</label>
                                                    <input type="text" name="color" value="<?php echo $row_edit['color']; ?>" class="form-control" placeholder="Item Color..." >
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Item Price*</label>
                                                    <div class="input-group">
                                                        <input type="number" name="price" value="<?php echo $row_edit['price']; ?>" class="form-control" placeholder="Item Price..." required>
                                                        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group admin-form">
                                                <div class="col-sm-12">
                                                    <label class="control-label">Item Description</label>
                                                    <textarea name="description" class="form-control textarea-grow" rows="4" placeholder="Write Description Here..."><?php echo $row_edit['description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group admin-form">
                                                <div class="col-sm-2">
                                                    <label class="control-label" for="new">Item New?</label>
                                                    <div class="checkbox-custom checkbox-primary mb10">
                                                        <input type="checkbox" id="new" name="new" <?php if($row_edit['new']) {echo 'checked';} ?> >
                                                        <label for="new"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <label class="control-label">Offered</label>
                                                    <div class="checkbox-custom checkbox-warning">
                                                        <input type="checkbox" id="offered" name="offer" <?php if($row_edit['offer']) {echo 'checked';} ?>>
                                                        <label for="offered"></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Offer Price</label>
                                                    <div class="input-group">
                                                        <input type="number" name="offerPrice" value="<?php if(!($row_edit['offerPrice']==0)) {echo $row_edit['offerPrice'];} ?>" <?php if($row_edit['offerPrice']==0) {echo 'disabled';} ?> class="form-control" id="offerprice" placeholder="Offer Price..." required>
                                                        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="control-label">Upload Image Item*</label>
                                                    <label class="field prepend-icon file">
                                                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                                                        <input type="file" class="gui-file" name="fileToUpload" id="fileToUpload" onchange="document.getElementById('imagename').value = this.value.substr(12);" >
                                                        <input type="text" name="itemImage" value="<?php echo $row_edit['itemImage']; ?>" class="gui-input" id="imagename" placeholder="Please Select An Image" >
                                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="clearfix"><br/></div>
                                            <div align="right" class="">
                                                <a href="items.php" class="btn btn-default " role="button"> Cancel </a>
                                                <button type="submit" name="submitedit" class="btn btn-primary">Edit Item</button>
                                                <input type="hidden" name="itemId" value="<?php echo $row_edit['itemId']; ?>">
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
                            <div class="col-md-5">

                                <!-- Input Fields -->
                                <div class="panel">
                                    <div class="panel-heading">
                                        <span class="panel-title">Additional Images for <b class="text-info"><?php if(isset($row_add['itemName'])) {echo $row_add['itemName'];} ?></b></span>
                                    </div>

                                    <div class="panel-body">
                                        <form class="form-horizontal" name="addform" method="POST" action="items.php" enctype="multipart/form-data" role="form">

                                            <a href="#" class="btn btn-rounded btn-sm btn-info"><i class="fa fa-zoom"></i> View All Images </a>

                                            <div class="form-group admin-form">
                                                <div class="col-sm-10">
                                                    <label class="control-label">Upload Image Item*</label>
                                                    <label class="field prepend-icon file">
                                                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                                                        <input type="file" class="gui-file" name="fileToUpload" id="fileToUpload" onChange="document.getElementById('imagename').value = this.value.substr(12);" required>
                                                        <input type="text" class="gui-input" name="itemImage" id="imagename" placeholder="Please Select An Image">
                                                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="clearfix"><br/></div>
                                            <div align="right" class="">
                                                <a href="items.php" class="btn btn-default " role="button"> Cancel </a>
                                                <button type="submit" name="submitadd" class="btn btn-primary">Submit</button>
                                                <input type="hidden" name="itemId" value="<?php echo $row_add['itemId']; ?>">
                                                <input type="hidden" name="itemName" value="<?php echo $row_add['itemName']; ?>" >
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>

                    <?php if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['itemId'])) { ?>
                        <div class="row">
                            <div class="col-md-6">

                                <!-- Input Fields -->
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <span class="panel-title">Are you sure you want to Delete <?php if(isset($row_delete['itemName'])) {echo $row_delete['itemName'];} ?>?</span>
                                    </div>

                                    <div class="panel-body">
                                        <form class="form-horizontal" name="deleteform" method="POST" action="items.php" role="form">
                                            <div class="form-group">
                                                <input type="hidden" name="deleteitemId" value="<?php if(isset($row_delete['itemId'])){ echo $row_delete['itemId'];} ?>" >
                                                <input type="hidden" name="deleteitemImage" value="<?php if(isset($row_delete['itemImage'])){ echo $row_delete['itemImage'];} ?>" >
                                                <h4>&emsp;&emsp;<?php if(isset($row_delete['itemName'])){ echo $row_delete['itemName'];} ?></h4>
                                            </div>
                                            <div align="right" class="">
                                                <a href="items.php" class="btn btn-default " role="button"> Cancel </a>
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
                                        <form class="form-horizontal" name="deleteallform" method="POST" action="items.php" role="form">
                                            <div class="form-group">

                                                <?php
                                                $list = $_POST['checknum'];
                                                foreach($list as $name) { ?>
                                                    <input type="hidden" name="checknum[]" value="<?php echo $name; ?>" checked >
                                                    <p>&emsp;&emsp;<?php echo $name; ?></p>
                                                <?php } ?>

                                            </div>
                                            <div align="right" class="">
                                                <a href="items.php" class="btn btn-default " role="button"> Cancel  </a>
                                                <button type="submit" name="submitalldelete" class="btn btn-danger"> Delete </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>

                    <a href="items.php?action=new" class="btn btn-default btn-gradient"><i class="fa fa-plus"></i> Add New Item </a>

                    <div class="panel panel-visible">
                        <div class="panel-heading">
                            <div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tags"></span><b class="text-primary"><?php echo strtoupper($_SESSION['type']); ?></b> Item Details</div>
                        </div>

                        <div class="panel-body pn">
                            <form name="table" method="POST" action="items.php">
                                <table class="table table-striped table-hover" id="datatable3" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Select</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>New</th>
                                        <th>Offer</th>
                                        <th>Price</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Select</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>New</th>
                                        <th>Offer</th>
                                        <th>Price</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php if (mysqli_num_rows($result) > 0) {
                                        $i=1;
                                        while($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td>&emsp;<input type="checkbox" name="checknum[]" value="<?php echo $row['itemName']; ?>"></td>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['itemName']; ?></td>
                                                <td><?php echo $row['brandName']; ?></td>
                                                <td><?php echo $row['categoryName']; ?></td>
                                                <td>&emsp;<input type="checkbox" <?php if($row['new']){echo 'checked';} ?> disabled></td>
                                                <td>&emsp;<input type="checkbox" <?php if($row['offer']){echo 'checked';} ?> disabled></td>
                                                <td><?php if(!$row['offerPrice']==0) {echo $row['offerPrice'];} else {echo $row['price'];} ?></td>
                                                <td><?php echo $row['itemImage']; ?></td>
                                                <td>
                                                    <a href="items.php?action=addimage&itemId=<?php echo $row['itemId']; ?>" class="btn btn-info btn-xs btn-rounded btn-gradient"><i class="fa fa-plus"></i> Images </a>
                                                    <a href="items.php?action=edit&itemId=<?php echo $row['itemId']; ?>" class="btn btn-warning btn-xs btn-rounded btn-gradient"><i class="fa fa-pencil"></i> Edit </a>
                                                    <a href="items.php?action=delete&itemId=<?php echo $row['itemId']; ?>" class="btn btn-danger btn-xs btn-rounded btn-gradient"><i class="fa fa-times-circle"></i> Delete </a>
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

            //Enable, Disable checkbox
            $("#offered").click(function () {
                if ($(this).is(":checked")) {
                    $("#offerprice").removeAttr("disabled");
                    $("#offerprice").focus();
                } else {
                    $("#offerprice").attr("disabled", "disabled");
                }
            });

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
mysqli_free_result($resultbrand);
mysqli_free_result($resultcategory);
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