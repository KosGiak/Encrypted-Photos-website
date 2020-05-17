<?php
include ('CreateKeys.php');
include ('Encryption.php');
include ('User.php');

class registerNewUser extends User{
    private $pass1, $pass2;
    private $db1, $db2;
    //Constructors: 
    function __construct($username, $name, $surname, $email, $pass1, $pass2) {
        $this->username = $username;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->pass1 = $pass1;
        $this->pass2 = $pass2;
        $db = new DataBase();
        $this->db1 = $db->NefosDB();
        $this->db2 = $db->PrivateKeys();
    }
    
    /**
     * Methodos pou checkarw an ta passwords pou edwse o client einai idia.
     * @return boolean
     */
    function CheckPass(){
        if($this->pass1 == $this->pass2)
            return true;
        return false;
    }
    
    /**
     * Methodos pou vriskw an yparxei to username
     * @return boolean
     */
    function CheckUsername(){
        $sql = "SELECT * FROM users WHERE username = '$this->username'";
        $result = $this->db1->query($sql);
        if($result->num_rows == 0)
            return true;
        return false;
    }
    
    /**
     * Methodos pou vriskw an yparxei to email
     * @return boolean
     */
    function CheckEmail(){
        $sql = "SELECT * FROM users WHERE email = '$this->email'";
        $result = $this->db1->query($sql);
        if($result->num_rows == 0)
            return true;
        return false;
    }

    /**
     * Methodos pou checkarw an yparxei o user idi stn DB.
     * @return boolean
     */
    function AllChecked(){
        if($this->CheckEmail() && $this->CheckUsername() && $this->CheckPass())
            return true;
        return false;
    }
    
    /**
     * Methodos pou kanw insert neo client stn DB
     */
    function InsertToDB(){
        if($this->AllChecked()){
            $key1 = new CreateKeys();
            $key1->CreatePrivateAndPublicKey();
            $key1->CreateSecKey(128);
            $priv = $key1->getPriv();
            $pub = $key1->getPub();
            $secKey = $key1->getSecKey();
            $en = new Encryption();
            $en->Constructor_Pub_Sec_Msg($pub, $secKey, $this->pass1);
            $en->Encrypt();
            $en->SecKeyWithPubKey();
            
            //2o zeugari klidiwn pou einai gia tis photo:
            $key2 = new CreateKeys();
            $key2->CreatePrivateAndPublicKey();//Dimiourgw to zeugari priv pub.
            $key2->CreateSecKey(128);//dimiourgw to sec key.
            $en2 = new Encryption();//gia na kanw encrypt to sec key me to pub.
            $en2->Constructor_Pub_Sec($key2->getPub(), $key2->getSecKey());
            $en2->SecKeyWithPubKey();//encrypt sec key with pub.
            
            $password = $en->getEncrypted();
            $priv1 = $key1->getPriv();             
            $pub1 = $key1->getPub();                
            $secKey1 = $en->getEnSecKey();          
            $priv2 = $key2->getPriv();
            $pub2 = $key2->getPub();
            $secKey2 = $en2->getEnSecKey();
//            echo "</br>---------------------------------------------------</br>";
//            echo "email: ", $this->email, "</br>---------------------------------------------------</br>";
//            echo "password: ", $password, "</br>---------------------------------------------------</br>";
//            echo "name: ", $this->name, "</br>---------------------------------------------------</br>";
//            echo "surname: ",$this->surname, "</br>---------------------------------------------------</br>";
//            echo "username: ",$this->username, "</br>---------------------------------------------------</br>";
//            echo "seckey1: ",$secKey1, "</br>---------------------------------------------------</br>";
//            echo "pub1: ", $pub1, "</br>---------------------------------------------------</br>";
//            echo "seckey2: ", $secKey2, "</br>---------------------------------------------------</br>";
//            echo "pub2: ", $pub2, "</br>---------------------------------------------------</br>";
            $email1 = $this->email;
            $name1 = $this->name;
            $surname1 = $this->surname;
            $username1 = $this->username;

            mysqli_query(
                $this->db1,
                    "INSERT INTO users (email, password, name, surname, username, SecKey1, PubKey1, SecKey2, PubKey2) VALUES
                    ('$email1', '$password', '$name1', '$surname1', '$username1', '$secKey1', '$pub1', '$secKey2', '$pub2')"
            );
            $sql = "SELECT id FROM users WHERE email = '$this->email'";
            $result = $this->db1->query($sql);
            $tempid = -1;
            while($row = $result->fetch_assoc()){
                $_SESSION["id"] = $row["id"];
                $tempid = $_SESSION["id"];
            }

            mysqli_query(
                $this->db2,
                    "INSERT INTO privatekeys (user_fk, PrivateKey1, PrivateKey2) VALUES
                    ('$tempid', '$priv1', '$priv2')"
            );
            
            $registered = mysqli_affected_rows($this->db1);
            $registered1 = mysqli_affected_rows($this->db2);
            if ($registered == 1 && $registered1 == 1) {
//                echo "welcome";
                return true;
//                mysqli_close($this->db1);
            } else {
                printf("Errormessage: %s\n", mysqli_error($this->db1));
                printf("</br></br>Errormessage: %s\n", mysqli_error($this->db2));
                return false;
            }
            
        }
        else
            echo 'failed to insert the new client.';
        return false;
    }

    //Getters & Setters: 
    function getUsername() {
        return $this->username;
    }

    function getName() {
        return $this->name;
    }

    function getSurname() {
        return $this->surname;
    }

    function getEmail() {
        return $this->email;
    }

    function getPass1() {
        return $this->pass1;
    }

    function getPass2() {
        return $this->pass2;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSurname($surname) {
        $this->surname = $surname;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPass1($pass1) {
        $this->pass1 = $pass1;
    }

    function setPass2($pass2) {
        $this->pass2 = $pass2;
    }
}
