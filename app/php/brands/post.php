<?php
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
?>