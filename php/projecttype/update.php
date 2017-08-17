<?php
include_once('../../axispanel/includes/connect.php');

    if(isset($_POST['projectTypeName']) && isset($_POST['projectTypeId']) ) {


        $projectTypeName = $_POST['projectTypeName'];
        $projectTypeId = $_POST['projectTypeId'];

        $sql = "SELECT * FROM tblprojecttype WHERE projectTypeId = '$projectTypeId' ";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            if (mysqli_num_rows($result) > 0) { 

                $updateQuery = "UPDATE tblprojecttype SET projectTypeName='$projectTypeName' WHERE projectTypeId='$projectTypeId'";
                if(mysqli_query($conn, $updateQuery)){

                    header("HTTP/1.0 200 OK");
                    echo "Project type updated successfully";
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