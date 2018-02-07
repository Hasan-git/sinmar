<?php 
include_once('../../axispanel/includes/connect.php');

$sql = "SELECT * FROM tblhome";
$result = mysqli_query($conn, $sql);

if ($result) {

	if (mysqli_num_rows($result) > 0) { 

				$row = mysqli_fetch_assoc($result);

			 	$id=$row['id'];
			 	$xpYears=$row['xpYears'];
				$projects=$row['projects'];
				$clients=$row['clients'];
				$employees=$row['employees'];

				$_record['data'] = array(
				'id' => $id,
				'xpYears' => $xpYears,
				'projects' => $projects,
				'clients' => $clients,
				'employees' => $employees
				 );

		  $categories = json_encode($_record);
		  header("HTTP/1.0 200 OK");
		  echo $categories;
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