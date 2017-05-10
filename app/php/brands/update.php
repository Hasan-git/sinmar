<?php

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
?>