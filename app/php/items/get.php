<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM tblitems WHERE itemId = '$id'";
    $result = mysqli_query($conn, $sql);
}
elseif(isset($_GET['itemType'])){

	$itemType = $_GET['itemType'];

	$sql = "SELECT * FROM tblitems WHERE itemType = '$itemType' ORDER BY itemId DESC";
	$result = mysqli_query($conn, $sql);
}
	if ($result) {

		if (mysqli_num_rows($result) > 0) {

			 while($row = mysqli_fetch_assoc($result)) {

					$itemId = $row['itemId'];
					$itemType = $row['itemType'];
					$itemName = $row['itemName'];
					$brandName = $row['brandName'];
					$categoryName = $row['categoryName'];
					$model = $row['model'];
					$itemSize = $row['itemSize'];
					$color = $row['color'];
					$price = (int)$row['price'];
					$description = $row['description'];
					$new = $row['new'];
					$offer = $row['offer'];
					$offerPrice = (int)$row['offerPrice'];
					$itemImage = $row['itemImage'];

					$_item['data'][] = array(
					'itemId' => $itemId,
					'itemType' => $itemType,
					'itemName' => $itemName,
					'brandName' => $brandName,
					'categoryName' => $categoryName,
					'model' => $model,
					'itemSize' => $itemSize,
					'color' => $color,
					'price' => $price,
					'description' => $description,
					'new' => !!$new,
					'offer' => !!$offer,
					'offerPrice' => $offerPrice,
					'itemImage' => $itemImage,
					 );
			  }

			  $items = json_encode($_item);
			  header("HTTP/1.0 200 OK");
			  echo $items;
			}else{
				$_item['data'] = array();
				$items = json_encode($_item);
				echo $items;
			}
			mysqli_free_result($result);
			mysqli_close($conn);
		}else{
			header("HTTP/1.0 500 Internal Server Error");
		}



?>
