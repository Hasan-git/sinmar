<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_GET['projectTitle'])){

$projectTitle = $_GET['projectTitle'];

$sql = "SELECT * FROM tblprojectimages WHERE projectTitle='$projectTitle' ORDER BY projectImageId DESC";
$result = mysqli_query($conn, $sql);

if ($result) {

	if (mysqli_num_rows($result) > 0) {

		 while($row = mysqli_fetch_assoc($result)) {

			 	$projectImageId=$row['projectImageId'];
				$projectTitle=$row['projectTitle'];
				$imageBefore=$row['imageBefore'];
				$imageAfter=$row['imageAfter'];

				$_object['data'][] = array(
				'projectImageId' => $projectImageId,
				'projectTitle' => $projectTitle,
				'imageBefore' => $imageBefore,
				'imageAfter' => $imageAfter
				 );
		  }

		  $response = json_encode($_object);
		  header("HTTP/1.0 200 OK");
		  echo $response;
		}else{

		 	header("HTTP/1.0 200 OK");
			$_object['data'] = array();
			$response = json_encode($_object);
			echo $response;
		}

    }else{
        header("HTTP/1.0 500 Internal Server Error");
    }

}else{
	header("HTTP/1.0 400 Bad Request");
}

mysqli_free_result($result);
mysqli_close($conn);
?>
