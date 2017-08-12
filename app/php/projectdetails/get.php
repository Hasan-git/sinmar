<?php
include_once('../../axispanel/includes/connect.php');

	if(isset($_GET['projecttype'])){

		$projecttype = $_GET['projecttype'];
		$sql = "SELECT * FROM tblprojectdetails WHERE prdetailsType = '$projecttype' ORDER BY prdetailsId DESC";
		$result = mysqli_query($conn, $sql);
	}
	else if (isset($_GET['prdetailsId'])){

		$prdetailsId = $_GET['prdetailsId'];
		$sql = "SELECT * FROM tblprojectdetails WHERE prdetailsId = '$prdetailsId' ORDER BY prdetailsId DESC";
		$result = mysqli_query($conn, $sql);

	}else{
	    	header("HTTP/1.0 400 Bad Request");
  }


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

				if(isset($prdetailsTitle)){
            $imagesQuery = "SELECT * FROM tblprojectimages WHERE projectTitle = '$prdetailsTitle' ";
            $imagesResult = mysqli_query($conn, $imagesQuery);
            if (mysqli_num_rows($imagesResult) > 0) {
                while($imagesRow = mysqli_fetch_assoc($imagesResult)) {
                    $images[] = array(
                        'projectImageId' => $imagesRow['projectImageId'],
                        'imageAfter' => $imagesRow['imageAfter'],
                        );
                }
                $_record['data'][0]['images'] = $images;
            }
        }
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
			mysqli_free_result($result);
			mysqli_close($conn);
    }else{
        header("HTTP/1.0 500 Internal Server Error");
    }




?>
