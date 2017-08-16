<?php
include_once('../../axispanel/includes/connect.php');

    if(isset($_POST['projectName']) && isset($_POST['projectId']) ) {


        $projectName = $_POST['projectName'];
        $projectId = $_POST['projectId'];

        $sql = "SELECT * FROM tblprojects WHERE projectId = '$projectId' ";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            if (mysqli_num_rows($result) > 0) { 

                $updateQuery = "UPDATE tblprojects SET projectName='$projectName' WHERE projectId='$projectId'";
                if(mysqli_query($conn, $updateQuery)){

                    header("HTTP/1.0 200 OK");
                    echo "Project updated successfully";
                }else{

                    header("HTTP/1.0 500 Internal Server Error");
                    echo "An error occurred";
                }
            }

        }else{

                header("HTTP/1.0 500 Internal Server Error");
                echo "An error occurred";
        }

    }else{

            header("HTTP/1.0 400 Bad Request");
            echo "Some fields are required";
    }

mysqli_free_result($result);
mysqli_close($conn);
?>