<?php

include ('CreateKeys.php');
include ('Decryption.php');
include ('User.php');

class registeredUser extends User{
    private $password, $passFromDB;
    private $secKey1, $secKey2;
    private $pub1, $pub2;
    private $priv1, $priv2;
    private $db1, $db2;
    private $validate;
    
            //Consturctos:
    function __construct() {$this->DataBaseConnection();}

    function Constructor_Mail_Pass($email, $password) {
        $this->email = $email;
        $this->password = $password; 
    }
    
    function Constructor_Mail($email){
        $this->email = $email;
    }
    
                //Methods:
    
    //Methodos pou kanw connection me tis DB:
    function DataBaseConnection(){
        $db = new DataBase();
        $this->db1 = $db->NefosDB();
        $this->db2 = $db->PrivateKeys();
    }
    
    /**
     * Checkarw an o user yparxei stin DB
     */
    function FindUser(){
        $sql = "SELECT * FROM users WHERE email = '$this->email'";
        $result = $this->db1->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $_SESSION["id"] = $row["id"];
                    $this->id = $_SESSION["id"];
                $_SESSION["password"] = $row["password"];
                    $this->passFromDB = $_SESSION["password"];
                $_SESSION["name"] = $row["name"];
                    $this->name = $_SESSION["name"];
                $_SESSION["surname"] = $row["surname"];
                    $this->surname = $_SESSION["surname"];
                $_SESSION["username"] = $row["username"];
                    $this->username = $_SESSION["username"];
                $_SESSION["SecKey1"] = $row["SecKey1"];
                    $this->secKey1 = $_SESSION["SecKey1"];
                $_SESSION["SecKey2"] = $row["SecKey2"];
                    $this->secKey2 = $_SESSION["SecKey2"];
                 $_SESSION["PubKey1"] = $row["PubKey1"];
                    $this->pub1 = $_SESSION["PubKey1"];
                $_SESSION["PubKey2"] = $row["PubKey2"];
                    $this->pub2 = $_SESSION["PubKey2"];
                $_SESSION["validate"] = $row["validate"];
                    $this->validate = $_SESSION["validate"];
            }
            return true;
        }
        else{
            return false;
        }
    }
    
    /**
     * Methodos pou enas register user kanei login stn selida.
     */
    function Login(){
        $validate = $this->FindUser();
        if($validate == true){
            $this->loadPrivateKey();
            /**
             * Se auto to simeio exoume vrei oti o user yparxei
             * stin ypiresia mas ara auto pou mas lipei einai na 
             * kanoume validate an to password pou edwse einai
             * to swsto.
             */
            $dec = new Decryption();
            $dec->ConstructorUser($this->secKey1, $this->priv1, $this->password, $this->passFromDB);
            $dec->Decrypt();
            $dec->ChooseSecKeyToDec("1");
            $login = $dec->DecryptPass();
            return $login;
        }
        else{
            echo 'wrong email';
        }
    }
    
    /**
     * Methodos pou kanw load to private keys apo tin DB:
     */
    function loadPrivateKey(){
        $sql = "SELECT * FROM privatekeys WHERE user_fk = '$this->id'";
        $result = $this->db2->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $_SESSION["PrivateKey1"] = $row["PrivateKey1"];
                    $this->priv1 = $_SESSION["PrivateKey1"];
                    $this->priv2 = $_SESSION["PrivateKey2"];
            }
        }
    }
    
    function toString(){
        echo "</br>---------------------------------------------------</br>";
        echo$this->id, "</br>---------------------------------------------------</br>",
            $this->email,"</br>---------------------------------------------------</br>",
            $this->passFromDB,"</br>---------------------------------------------------</br>",
            $this->name,"</br>---------------------------------------------------</br>",
            $this->surname, "</br>---------------------------------------------------</br>",
            $this->secKey1,"</br>---------------------------------------------------</br>",
            $this->pub1,"</br>---------------------------------------------------</br>",
            $this->secKey2,"</br>---------------------------------------------------</br>",
            $this->pub2, "</br>---------------------------------------------------</br>",
            $this->priv1, "</br>---------------------------------------------------</br>",
            $this->priv2, "</br>---------------------------------------------------</br>",
            "Validate: ",$this->validate;
    }
    
    function getPassword() {
        return $this->password;
    }

    function getPassFromDB() {
        return $this->passFromDB;
    }

    function getSecKey1() {
        return $this->secKey1;
    }

    function getSecKey2() {
        return $this->secKey2;
    }

    function getPub1() {
        return $this->pub1;
    }

    function getPub2() {
        return $this->pub2;
    }

    function getPriv1() {
        return $this->priv1;
    }

    function getPriv2() {
        return $this->priv2;
    }

    function getDb1() {
        return $this->db1;
    }

    function getDb2() {
        return $this->db2;
    }

    function getValidate() {
        return $this->validate;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setPassFromDB($passFromDB) {
        $this->passFromDB = $passFromDB;
    }

    function setSecKey1($secKey1) {
        $this->secKey1 = $secKey1;
    }

    function setSecKey2($secKey2) {
        $this->secKey2 = $secKey2;
    }

    function setPub1($pub1) {
        $this->pub1 = $pub1;
    }

    function setPub2($pub2) {
        $this->pub2 = $pub2;
    }

    function setPriv1($priv1) {
        $this->priv1 = $priv1;
    }

    function setPriv2($priv2) {
        $this->priv2 = $priv2;
    }

    function setDb1($db1) {
        $this->db1 = $db1;
    }

    function setDb2($db2) {
        $this->db2 = $db2;
    }

    function setValidate($validate) {
        $this->validate = $validate;
    }
}
