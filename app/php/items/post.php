<?php
include_once('../../axispanel/includes/connect.php');

    if( isset($_POST['brandName']) && isset($_POST['itemType']) && isset($_POST['itemName']) && isset($_POST['categoryName']) && isset($_POST['price']) && isset($_FILES['itemImage']) ) {

        $itemtype = $_POST['itemType'];
        $itemname = $_POST['itemName'];
        $brandname = $_POST['brandName'];
        $categoryname = $_POST['categoryName'];
        $itemimage  =   $_FILES['itemImage'];
        $price =    (int)$_POST['price'];

        $model =        isset($_POST['model']) ? $_POST['model'] :'' ;
        $itemsize =     isset($_POST['itemSize']) ? $_POST['itemSize'] :'' ;
        $color =        isset($_POST['color']) ? $_POST['color'] :'z' ;
        $description =  isset($_POST['description']) ? $_POST['description'] :'' ;
        $new =          isset($_POST['new']) ? $_POST['new'] : 0 ;
        $offer      =   isset($_POST['offer']) ? $_POST['offer'] : 0 ;
        $offerprice =   isset($_POST['offerPrice']) ? (int)$_POST['offerPrice'] : 0 ;


        $tmp_name = $itemimage["tmp_name"];
        $name = dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR . 'axispanel'.DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR .basename($itemimage["name"]);
        $itemImage_ = $itemimage["name"];
        if(move_uploaded_file($tmp_name, $name)){

            $sqlnew = "INSERT INTO tblitems (itemType, itemName, brandName, categoryName, model, itemSize, color, price, description, new, offer, offerPrice, itemImage)
                   VALUES ('$itemtype', '$itemname', '$brandname', '$categoryname', '$model', '$itemsize', '$color', '$price', '$description', ".($new?1:0).", ".($offer?1:0).", '$offerprice', '$itemImage_')";

            if (mysqli_query($conn, $sqlnew)) {

                $item = array(
                                'itemId' => $conn->insert_id,
                                'itemType' => $itemtype,
                                'itemName' => $itemname,
                                'brandName' => $brandname,
                                'categoryName' => $categoryname,
                                'model' => $model,
                                'itemSize' => $itemsize,
                                'color' => $color,
                                'price' => $price,
                                'description' => $description,
                                'new' => $new,
                                'offer' => $offer,
                                'offerprice' => $offerprice,
                            );
                $item_ = json_encode($item);

                  header("HTTP/1.0 200 OK");
                  echo $item_;
            }else {
                //QUERY FAILED
                header("HTTP/1.0 500 Internal Server Error");
                echo "An error occurred";
                }
        }else{
            // FILED TO MOVE THE FILE
            header("HTTP/1.0 500 Internal Server Error");
            echo "Unable to upload the file";
        }
    }else{

        header("HTTP/1.0 400 Bad Request");
        echo "Some fields are required";
    }

    

?>