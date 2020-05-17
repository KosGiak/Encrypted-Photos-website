<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of viewPhoto
 *
 * @author Alcohealism
 */
class viewPhoto {
    private $db1, $db2, $id, $image;
    function __construct() {
        $db = new DataBase();
        $this->db1 = $db->NefosDB();
        $this->db2 = $db->PrivateKeys();
    }

    function Display($id){
        $this->id = $id;
        $sql = "SELECT * FROM photos where user_fk = '$this->id'";
        $result = $this->db1->query($sql);
        return $result;
//        while($row = $result->fetch_assoc()){
//            $this->id = $row["id"];
//            $this->image = $row["image"];
//            $this->image = base64_encode($this->image);
////            echo '<img height="300" width="300" src="data:image;base64,'.$image.'">';
////            echo '<img height="300" width="300" src="data:image;base64,'.$image.'">';
//            
//             ;
//        }
    }
}
