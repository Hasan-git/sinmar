<?php
include_once('../../axispanel/includes/connect.php');

    if(isset($_POST['id']) ) {

        $id = $_POST['id'];
        $xpYears = $_POST['xpYears'];
        $projects = $_POST['projects'];
        $clients = $_POST['clients'];
        $employees = $_POST['employees'];

        $sql = "SELECT * FROM tblhome WHERE id = '$id' ";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            if (mysqli_num_rows($result) > 0) { 

                $updateQuery = "UPDATE tblhome SET xpYears='$xpYears',projects='$projects',clients='$clients',employees='$employees' WHERE id='$id'";
                if(mysqli_query($conn, $updateQuery)){

                    header("HTTP/1.0 200 OK");
                    echo "Updated successfully";
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