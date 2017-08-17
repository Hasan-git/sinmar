<?php
include_once('../../axispanel/includes/connect.php');

    if(isset($_POST['categoryName']) && isset($_POST['categoryId']) ) {

        $categoryName = $_POST['categoryName'];
        $categoryId = $_POST['categoryId'];

        $sql = "SELECT * FROM tblcategories WHERE categoryId = '$categoryId' ";
        $result = mysqli_query($conn, $sql);

        if ($result) {

            if (mysqli_num_rows($result) > 0) { 

                $updateQuery = "UPDATE tblcategories SET categoryName='$categoryName' WHERE categoryId='$categoryId'";
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
mysqli_free_result($result);
mysqli_close($conn);
?>