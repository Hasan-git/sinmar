<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_POST['projectTypeId']) ) {

    $projectTypeId = $_POST['projectTypeId'];

    $deleteQuery = "DELETE FROM tblprojecttype WHERE projectTypeId = '$projectTypeId'";

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
    

?>