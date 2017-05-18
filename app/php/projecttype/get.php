<?php 
include_once('../../axispanel/includes/connect.php');

$sql = "SELECT * FROM tblprojecttype ORDER BY projectTypeId DESC";
$result = mysqli_query($conn, $sql);

if ($result) {

	if (mysqli_num_rows($result) > 0) { 

		 while($row = mysqli_fetch_assoc($result)) {

			 	$projectTypeId=$row['projectTypeId'];
				$projectTypeName=$row['projectTypeName'];

				$_projects['data'][] = array(
				'projectTypeId' => $projectTypeId,
				'projectTypeName' => $projectTypeName );
		  }

		  $projects = json_encode($_projects);
		  header("HTTP/1.0 200 OK");
		  echo $projects;
		}else{
			$record['data'] = array();
			$response = json_encode($record);
			echo $response;
		}

    }else{
        header("HTTP/1.0 500 Internal Server Error");
    }
mysqli_free_result($result);
mysqli_close($conn);
?> 