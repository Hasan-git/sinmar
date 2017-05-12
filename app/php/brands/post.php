<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_POST['brandName']) ) {

    $brandName = $_POST['brandName'];

    $sqlnew = "INSERT INTO tblbrands (brandName) VALUES ('$brandName')";

    if (mysqli_query($conn, $sqlnew)) {

        //Get Project ID
        $brand = array(
                        'brandId' => $conn->insert_id,
                        'brandName' => $brandName 
                    );
        $brand_ = json_encode($brand);

          header("HTTP/1.0 200 OK");
          echo $brand_;
    }
    else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "An error occurred";
    }
}else{

    header("HTTP/1.0 400 Bad Request");
    echo "Some fields are required";
}
    

?>