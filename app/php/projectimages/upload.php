<?php
include_once('../../axispanel/includes/connect.php');

if (  isset($_FILES['imageBeforeFile']) && $_FILES['imageBeforeFile']['size'] > 0 && isset($_FILES['imageAfterFile']) && $_FILES['imageAfterFile']['size'] > 0 && isset($_POST['projectTitle'])  ) {
    
        $imageBefore = $_FILES['imageBeforeFile'];
        $imageAfter = $_FILES['imageAfterFile'];
        $projectTitle = $_POST['projectTitle'];

        //IMAGE BEFORE
        $tmp_nameBefore = $imageBefore["tmp_name"];
        $nameBefore = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR . 'axispanel'.DIRECTORY_SEPARATOR . 'projectImages' . DIRECTORY_SEPARATOR .basename($imageBefore["name"]);
        $imageBefore_ = $imageBefore["name"];
                
        //IMAGE AFTER
        $tmp_nameAfter = $imageAfter["tmp_name"];
        $nameAfter = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR . 'axispanel'.DIRECTORY_SEPARATOR . 'projectImages' . DIRECTORY_SEPARATOR .basename($imageAfter["name"]);
        $imageAfter_ = $imageAfter["name"];

                //MOVE IMAGE BEFORE
                if(move_uploaded_file($tmp_nameBefore, $nameBefore)){
                    //MOVE IMAGE AFTER
                    if(move_uploaded_file($tmp_nameAfter, $nameAfter)){

                        $sqlnew = "INSERT INTO tblprojectimages (projectTitle,imageBefore,imageAfter) VALUES ('$projectTitle','$imageBefore_','$imageAfter_')";

                            if (mysqli_query($conn, $sqlnew)) {
                                header("HTTP/1.0 200 OK");
                                echo "uploaded";
                            }else{
                                header("HTTP/1.0 500 Internal Server Error");
                                echo "An error occurred";
                            }
                    }else{
                        header("HTTP/1.0 500 Internal Server Error");
                        echo "failed to upload";
                    }
                }else{
                        header("HTTP/1.0 500 Internal Server Error");
                        echo "failed to upload";
                    }

             }else{
                header("HTTP/1.0 500 Internal Server Error");
                echo "failed to upload";
             }


mysqli_close($conn);
?>