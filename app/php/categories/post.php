<?php
include_once('../../axispanel/includes/connect.php');

if(isset($_POST['categoryName']) ) {

    $categoryName = $_POST['categoryName'];

    $sqlnew = "INSERT INTO tblcategories (categoryName) VALUES ('$categoryName')";

    if (mysqli_query($conn, $sqlnew)) {

        //Get Project ID
        $object = array(
                        'categoryId' => $conn->insert_id,
                        'categoryName' => $categoryName 
                    );
        $category_ = json_encode($object);

          header("HTTP/1.0 200 OK");
          echo $category_;
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