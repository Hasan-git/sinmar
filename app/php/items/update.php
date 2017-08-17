<?php
include_once('../../axispanel/includes/connect.php');

  if(isset($_POST['brandName']) && isset($_POST['itemType']) && isset($_POST['itemName']) && isset($_POST['categoryName']) && isset($_POST['price']) && isset($_POST['itemImageName']) ) {

        $itemId = $_POST['itemId'];
        $itemtype = $_POST['itemType'];
        $itemname = $_POST['itemName'];
        $brandname = $_POST['brandName'];
        $categoryname = $_POST['categoryName'];

        $price =    (int)$_POST['price'];

        $model =        isset($_POST['model']) ? $_POST['model'] :'' ;
        $itemsize =     isset($_POST['itemSize']) ? $_POST['itemSize'] :'' ;
        $color =        isset($_POST['color']) ? $_POST['color'] :'z' ;
        $description =  isset($_POST['description']) ? $_POST['description'] :'' ;
        $new =          isset($_POST['new']) ? $_POST['new'] : 0 ;
        $offer      =   isset($_POST['offer']) ? $_POST['offer'] : 0 ;
        $offerprice =   isset($_POST['offerPrice']) ? (int)$_POST['offerPrice'] : 0;

        if(isset($_FILES['itemImage']) && $_FILES['itemImage']['size'] > 0){
            $itemimage  =   $_FILES['itemImage'] ;
            $tmp_name = $itemimage["tmp_name"];
            $guid = uniqid();
            $path = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR . 'axispanel'.DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR .basename( $guid.'@'.$itemimage["name"]);
            $itemImageName =  $guid.'@'.$itemimage["name"];
            move_uploaded_file($tmp_name, $path);
        }else{
            $itemImageName =$_POST['itemImageName'];
        }

            $updateQuery = "UPDATE tblitems SET itemtype='$itemtype',itemname='$itemname',brandname='$brandname',categoryname='$categoryname',price='$price',model='$model',itemsize='$itemsize',color='$color',description='$description',new=".($new?1:0).",offer=".($offer?1:0).",offerprice='$offerprice',itemImage='$itemImageName' WHERE itemId='$itemId'";
            if(mysqli_query($conn, $updateQuery)){


                $record['data'] = array(
                    'itemId' => $itemId,
                    'itemType' => $itemtype,
                    'itemName' => $itemname,
                    'brandName' => $brandname,
                    'categoryName' => $categoryname,
                    'model' => $model,
                    'itemSize' => $itemsize,
                    'color' => $color,
                    'price' => $price,
                    'description' => $description,
                    'new' => $new?true:false,
                    'offer' => $offer?true:false,
                    'offerPrice' => $offerprice,
                    'itemImageName' => $itemImageName,
                     );

                    $response = json_encode($record);
                    header("HTTP/1.0 200 OK");
                    echo $response;
            }else{
                // echo mysqli_error($conn);                
                header("HTTP/1.0 500 Internal Server Error");
                echo "An error occurred";
            }
    }else{

            header("HTTP/1.0 400 Bad Request");
            echo "Some fields are required";
    }


mysqli_close($conn);
?>