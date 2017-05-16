<?php
include_once('../../axispanel/includes/connect.php');

    if( isset($_POST['prdetailsTitle']) && isset($_POST['prdetailsName']) && !empty($_POST['prdetailsName']) && isset($_POST['prdetailsType']) && !empty($_POST['prdetailsType']) && isset($_POST['projectDate'])  && isset($_FILES['projectImage']) ) {



        $prdetailsTitle = $_POST['prdetailsTitle'];
        $prdetailsName = $_POST['prdetailsName'];
        $prdetailsType = $_POST['prdetailsType'];
        $projectImage = $_FILES['projectImage'];

        $prdetailsSubtype   =  isset($_POST['prdetailsSubtype']) ? $_POST['prdetailsSubtype'] :'' ;
        $location           =  isset($_POST['location']) ? $_POST['location'] :'' ;
        $projectDate        =  isset($_POST['projectDate']) ? $_POST['projectDate'] : date('Y-m-d H:i:s') ;
        $description        =  isset($_POST['description']) ? $_POST['description'] :'' ;
        $new                =  isset($_POST['new']) ? $_POST['new'] : 0 ;
        $notes              =  isset($_POST['notes']) ? $_POST['notes'] : '' ;

        $tmp_name = $projectImage["tmp_name"];
        $name = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR . 'axispanel'.DIRECTORY_SEPARATOR . 'projectImages' . DIRECTORY_SEPARATOR .basename($projectImage["name"]);
        $projectImage_ = $projectImage["name"];
        if(move_uploaded_file($tmp_name, $name)){

            $sqlnew = "INSERT INTO tblprojectdetails (prdetailsTitle, prdetailsName, prdetailsType, prdetailsSubtype, location, projectDate, description, new, notes, projectImage)
                                            VALUES ('$prdetailsTitle', '$prdetailsName', '$prdetailsType', '$prdetailsSubtype', '$location', '$projectDate', '$description', ".($new?1:0).", '$notes','$projectImage_')";

            if (mysqli_query($conn, $sqlnew)) {

                $record = array(
                                'prdetailsId' => $conn->insert_id,
                                'prdetailsTitle' => $prdetailsTitle,
                                'prdetailsName' => $prdetailsName,
                                'prdetailsType' => $prdetailsType,
                                'prdetailsSubtype' => $prdetailsSubtype,
                                'location' => $location,
                                'projectDate' => $projectDate,
                                'description' => $description,
                                'new' => $new?1:0,
                                'notes' => $notes,
                                'projectImage' => $projectImage_,
                            );
                $response = json_encode($record);

                  header("HTTP/1.0 200 OK");
                  echo $response;
            }else {
                // echo mysqli_error($conn);
                //QUERY FAILED
                header("HTTP/1.0 500 Internal Server Error");
                echo "An error occurred";
                }
        }else{
            // FILED TO MOVE THE FILE
            header("HTTP/1.0 500 Internal Server Error");
            echo "Unable to upload the file";
        }
    }else{

        header("HTTP/1.0 400 Bad Request");
        echo "Some fields are required";
    }

    

?>