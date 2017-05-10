<?php
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