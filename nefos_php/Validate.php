<?php
include ('src/DataBase.php');
if(isset($_GET['token']) && isset($_GET['user'])){
    $token = trim($_GET['token']);
    $username = trim($_GET['user']);
    $db = new DataBase();
    $db1 = $db->NefosDB();
    $sql = "SELECT * FROM users WHERE username = '$username' AND token = '$token'";
    $result = $db1->query($sql);
    echo "gg";
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $_SESSION["validate"] = $row["validate"];
                $validate = $_SESSION["validate"];
        }
        $sql = "UPDATE users SET validate='1' WHERE username='$username'";

        if ($db1->query($sql) === TRUE) {
            header("Location: home.php");
//            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $db1->error;
        }

        $db1->close();
    }
    
}
else{
    echo trim($_GET['token']);
    echo trim($_GET['user']);
    
}
    

