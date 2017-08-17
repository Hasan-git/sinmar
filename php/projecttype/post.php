<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_POST['projectTypeName']) ) {

    $projectTypeName = $_POST['projectTypeName'];

    $sqlnew = "INSERT INTO tblprojecttype (projectTypeName) VALUES ('$projectTypeName')";

    if (mysqli_query($conn, $sqlnew)) {

        //Get Project type ID
        $projectType = array(
                        'projectTypeId' => $conn->insert_id,
                        'projectTypeName' => $projectTypeName 
                    );
        $project = json_encode($projectType);

          header("HTTP/1.0 200 OK");
          echo $project;
    }
    else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "An error occurred";
    }
}else{

    header("HTTP/1.0 400 Bad Request");
    echo "Some fields are required";
}

mysqli_close($conn);
?>