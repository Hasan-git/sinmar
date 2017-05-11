<?php
include_once('../../axispanel/includes/connect.php');

    if(isset($_POST['brandName']) && isset($_POST['brandId']) ) {


        $brandName = $_POST['brandName'];
        $brandId = $_POST['brandId'];

        $sql = "SELECT * FROM tblbrands WHERE brandId = '$brandId' ";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            if (mysqli_num_rows($result) > 0) { 

                $updateQuery = "UPDATE tblbrands SET brandName='$brandName' WHERE brandId='$brandId'";
                if(mysqli_query($conn, $updateQuery)){

                    header("HTTP/1.0 200 OK");
                    echo "Brand updated successfully";
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

?>