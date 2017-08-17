<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_POST['projectImageId']) ) {

    $projectImageId = $_POST['projectImageId'];

    $sql = "SELECT * FROM tblprojectimages WHERE projectImageId='$projectImageId' ";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        $imageAfter=$row['imageAfter'];

        $file = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR . 'axispanel'.DIRECTORY_SEPARATOR . 'projectImages'.DIRECTORY_SEPARATOR .basename($imageAfter);

            unlink($file);

            $deleteQuery = "DELETE FROM tblprojectimages WHERE projectImageId = '$projectImageId'";

            if (mysqli_query($conn, $deleteQuery)) {

                  header("HTTP/1.0 200 OK");
                  echo 'deleted';
            }
            else {
                header("HTTP/1.0 500 Internal Server Error");
                echo "An error occurred";
            }

    }






}else{

    header("HTTP/1.0 400 Bad Request");
    echo "Something went wrong";
}

mysqli_close($conn);
?>
