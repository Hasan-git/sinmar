<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_POST['projectName']) ) {

    $projectName = $_POST['projectName'];

    $sqlnew = "INSERT INTO tblprojects (projectName) VALUES ('$projectName')";

    if (mysqli_query($conn, $sqlnew)) {

        //Get Project ID
        $project = array(
                        'projectId' => $conn->insert_id,
                        'projectName' => $projectName 
                    );
        $project_ = json_encode($project);

          header("HTTP/1.0 200 OK");
          echo $project_;
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