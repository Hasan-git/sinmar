<?php 
include_once('../../axispanel/includes/connect.php');

$sql = "SELECT * FROM tblbrands ORDER BY brandId DESC";
$result = mysqli_query($conn, $sql);



if ($result) {

	if (mysqli_num_rows($result) > 0) { 

		 while($row = mysqli_fetch_assoc($result)) {

			 	$brandId=$row['brandId'];
				$brandName=$row['brandName'];

				$_brand['data'][] = array(
				'brandId' => $brandId,
				'brandName' => $brandName );
		  }

		  $brands = json_encode($_brand);
		  header("HTTP/1.0 200 OK");
		  echo $brands;
		}

    }else{
        header("HTTP/1.0 500 Internal Server Error");
    }

mysqli_free_result($result);
mysqli_close($conn);
?> 