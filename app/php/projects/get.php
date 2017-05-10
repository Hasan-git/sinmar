<?php 
include_once('../../axispanel/includes/connect.php');

$sql = "SELECT projectId, projectName FROM tblprojects ORDER BY projectId DESC";
$result = mysqli_query($conn, $sql);



if ($result) {

	if (mysqli_num_rows($result) > 0) { 

		 while($row = mysqli_fetch_assoc($result)) {

			 	$projectId=$row['projectId'];
				$projectName=$row['projectName'];

				$_projects['data'][] = array(
				'projectId' => $projectId,
				'projectName' => $projectName );
		  }

		  $projects = json_encode($_projects);
		  header("HTTP/1.0 200 OK");
		  echo $projects;
		}

    }else{
        header("HTTP/1.0 500 Internal Server Error");
    }
?> 