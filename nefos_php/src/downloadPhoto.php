<?php
include ('DataBase.php');
session_start();
$image = $_SESSION['image'];
if ($_GET['fn'] == "photoID"){
    $tempID = $_GET['id'];
    $db = new DataBase();
    $conn = $db->NefosDB();
    echo '<img height="600" width="800" src="data:image;base64,'.$image.'">';
//    if (mysqli_query($conn, $sql)) {
//        echo "oo",$tempID;
////        header("Location: ../home.php");
//    }

    mysqli_close($conn);
}
