<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_POST['newproject']) ) {

    $new = $_POST['newproject'];

    $sqlnew = "INSERT INTO tblprojects (projectName) VALUES ('$new')";

    if (mysqli_query($conn, $sqlnew)) {

        header("HTTP/1.0 200 OK");
        echo "Project created successfully";
    }
    else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "An error occurred";
    }
}else{

    header("HTTP/1.0 400 Bad Request");
    echo "Some fields are required";
}
    

?>