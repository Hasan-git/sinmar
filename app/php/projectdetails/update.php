<?php
include_once('../../axispanel/includes/connect.php');

  if(isset($_POST['prdetailsTitle']) && isset($_POST['prdetailsId']) && isset($_POST['prdetailsName']) && isset($_POST['prdetailsType']) && isset($_POST['projectDate']) && isset($_POST['projectImageName'])  ) {

        // var_dump($_POST);
        // var_dump($_FILES);

        $prdetailsId = $_POST['prdetailsId'];
        $prdetailsTitle = $_POST['prdetailsTitle'];
        $prdetailsName = $_POST['prdetailsName'];
        $prdetailsType = $_POST['prdetailsType'];
        $projectImage = $_POST['projectImageName'];

        $prdetailsSubtype   =  isset($_POST['prdetailsSubtype']) ? $_POST['prdetailsSubtype'] :'' ;
        $location           =  isset($_POST['location']) ? $_POST['location'] :'' ;
        $projectDate        =  isset($_POST['projectDate']) ? $_POST['projectDate'] : date('Y-m-d H:i:s') ;
        $description        =  isset($_POST['description']) ? $_POST['description'] :'' ;
        $new                =  isset($_POST['new']) ? 1 : 0 ;
        $notes              =  isset($_POST['notes']) ? $_POST['notes'] : '' ;

        if(isset($_FILES['projectImage']) && $_FILES['projectImage']['size'] > 0){
            $itemimage  =   $_FILES['projectImage'] ;
            $guid = uniqid();
            $tmp_name = $itemimage["tmp_name"];
            $path = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR . 'axispanel'.DIRECTORY_SEPARATOR . 'projectImages' . DIRECTORY_SEPARATOR .basename($guid.'@'.$itemimage["name"]);
            $itemImageName = $guid.'@'.$itemimage["name"];
            move_uploaded_file($tmp_name, $path);
        }else{
            $itemImageName =$_POST['projectImageName'];
        }

         $updateQuery = "UPDATE tblprojectdetails SET prdetailsTitle='$prdetailsTitle', prdetailsName='$prdetailsName', prdetailsType='$prdetailsType', prdetailsSubtype='$prdetailsSubtype', location='$location',projectDate='$projectDate', description='$description', notes='$notes', new='$new', projectImage='$itemImageName'
                         WHERE prdetailsId= '$prdetailsId' ";
            if(mysqli_query($conn, $updateQuery)){
                echo mysqli_error($conn);


                 $record['data'] = array(
                                'prdetailsId' => $prdetailsId,
                                'prdetailsTitle' => $prdetailsTitle,
                                'prdetailsName' => $prdetailsName,
                                'prdetailsType' => $prdetailsType,
                                'prdetailsSubtype' => $prdetailsSubtype,
                                'location' => $location,
                                'projectDate' => $projectDate,
                                'description' => $description,
                                'new' => $new?1:0,
                                'notes' => $notes,
                                'projectImage' => $itemImageName,
                            );
                $response = json_encode($record);

                  header("HTTP/1.0 200 OK");
                  echo $response;
                // echo "Project details updated successfully";
            }else{
                echo mysqli_error($conn);
                header("HTTP/1.0 500 Internal Server Error");
                echo "An error occurred";
            }

    }else{

            header("HTTP/1.0 400 Bad Request");
            echo "Some fields are required";
    }

mysqli_close($conn);
?>