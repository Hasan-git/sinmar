<?php 
include_once('../../axispanel/includes/connect.php');

$sql = "SELECT * FROM tblcategories ORDER BY categoryId DESC";
$result = mysqli_query($conn, $sql);

if ($result) {

	if (mysqli_num_rows($result) > 0) { 

		 while($row = mysqli_fetch_assoc($result)) {

			 	$categoryId=$row['categoryId'];
				$categoryName=$row['categoryName'];

				$_object['data'][] = array(
				'categoryId' => $categoryId,
				'categoryName' => $categoryName );
		  }

		  $categories = json_encode($_object);
		  header("HTTP/1.0 200 OK");
		  echo $categories;
		}

    }else{
        header("HTTP/1.0 500 Internal Server Error");
    }
mysqli_free_result($result);
mysqli_close($conn);
?> 