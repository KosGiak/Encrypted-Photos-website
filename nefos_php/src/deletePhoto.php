<?php
include ('DataBase.php');
if ($_GET['fn'] == "photoID"){
    $tempID = $_GET['id'];
    $db = new DataBase();
    $conn = $db->NefosDB();
    $sql = "DELETE FROM photos WHERE id = '$tempID'";
    if (mysqli_query($conn, $sql)) {
        header("Location: ../home.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
