<?php
include_once('../includes/connect.php');

if ( !empty( $_FILES ) && isset($_POST['projectTitle'])  ) {

    $projectTitle = $_POST['projectTitle'];

    foreach ($_FILES["file"]["tmp_name"] as $key => $value)
    {
        $tmp_name = $_FILES["file"]["tmp_name"][$key];
        $guid = uniqid();
        $path = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR . 'axispanel'.DIRECTORY_SEPARATOR . 'projectImages'.DIRECTORY_SEPARATOR .basename($guid.'@'.$_FILES["file"]["name"][$key]);
        // move_uploaded_file($tmp_name, $name);
        if(move_uploaded_file( $tmp_name, $path )){


            $imageAfter= $guid.'@'.$_FILES["file"]["name"][$key];

            $sqlnew = "INSERT INTO tblprojectimages (imageAfter,projectTitle) VALUES ('$imageAfter','$projectTitle')";


            if (mysqli_query($conn, $sqlnew)) {
                header("HTTP/1.0 200 OK");
                echo "uploaded";
            }else{
                echo mysqli_error($conn);
                header("HTTP/1.0 500 Internal Server Error");
                echo "An error occurred";
            }


        }else{
            header("HTTP/1.0 500 Internal Server Error");
            echo "failed to upload";
        }
    }

}else{
    header("HTTP/1.0 400 Bad Request");
    echo "Something went wrong";
}

mysqli_close($conn);

?>
