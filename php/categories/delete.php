<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_POST['categoryId']) ) {

    $categoryId = $_POST['categoryId'];

    $deleteQuery = "DELETE FROM tblcategories WHERE categoryId = '$categoryId'";

    if (mysqli_query($conn, $deleteQuery)) {

          header("HTTP/1.0 200 OK");
          echo 'deleted';
    }
    else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "An error occurred";
    }
}else{

    header("HTTP/1.0 400 Bad Request");
    echo "Something went wrong";
}

mysqli_close($conn);
?>