<?php 
include_once('../../axispanel/includes/connect.php');
if(isset($_GET['projecttype'])){

$projecttype = $_GET['projecttype'];

$sql = "SELECT * FROM tblprojectdetails WHERE prdetailsType = '$projecttype' ORDER BY prdetailsId DESC";
$result = mysqli_query($conn, $sql);

if ($result) {

	if (mysqli_num_rows($result) > 0) { 

		 while($row = mysqli_fetch_assoc($result)) {

			    $prdetailsId = $row['prdetailsId'];
			    $prdetailsTitle = $row['prdetailsTitle'];
			    $prdetailsName = $row['prdetailsName'];
			    $prdetailsType = $row['prdetailsType'];
			    $prdetailsSubtype = $row['prdetailsSubtype'];
			    $location = $row['location'];
			    $projectDate = $row['projectDate'];
			    $description = $row['description'];
			    $notes = $row['notes'];
			    $new = $row['new'];
			    $projectImage = $row['projectImage'];

				$_record['data'][] = array(
				'prdetailsId' => $prdetailsId,
				'prdetailsTitle' => $prdetailsTitle,
				'prdetailsName' => $prdetailsName,
				'prdetailsType' => $prdetailsType,
				'prdetailsSubtype' => $prdetailsSubtype,
				'location' => $location,
				'projectDate' => $projectDate,
				'description' => $description,
				'notes' => $notes,
				'new' => $new,
				'projectImage' => $projectImage,
				 );
		  }

		  $response = json_encode($_record);
		  header("HTTP/1.0 200 OK");
		  echo $response;

		}else{
			// echo mysqli_error($conn);
			$_record['data'] = array();
			$response = json_encode($_record);
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