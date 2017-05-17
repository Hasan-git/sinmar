<?php 
include_once('../../axispanel/includes/connect.php');

if(isset($_GET['itemName'])){
$itemName_ = $_GET['itemName'];
$sql = "SELECT * FROM tblitemimages WHERE itemName = '$itemName_' ORDER BY ImageId DESC";
$result = mysqli_query($conn, $sql);

if ($result) {

	if (mysqli_num_rows($result) > 0) { 

		 while($row = mysqli_fetch_assoc($result)) {

			 	$ImageId=$row['ImageId'];
				$itemName=$row['itemName'];
				$imageName=$row['imageName'];

				$_image[] = array(
				'ImageId' => $ImageId,
				'itemName' => $itemName,
				'imageName' => $imageName
				 );
		  }

		  $images = json_encode($_image);
		  header("HTTP/1.0 200 OK");
		  echo $images;
		}

    }else{
        header("HTTP/1.0 500 Internal Server Error");
        echo "An error occurred";
    }



}else{
	header("HTTP/1.0 400 Bad Request");
    echo "Something went wrong";
}

mysqli_free_result($result);
mysqli_close($conn);
?> 