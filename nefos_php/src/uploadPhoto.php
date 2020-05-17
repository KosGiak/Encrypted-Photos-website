<?php

include ('Encryption.php');
class uploadPhoto {
    private $email, $id;
    private $db1, $db2;
    private $priv2, $secKey2, $pub2;
    
    function __construct() {
        $db = new DataBase();
        $this->db1 = $db->NefosDB();
        $this->db2 = $db->PrivateKeys();
    }
    
    function Constructor_Email($email){
        $this->email = $email;
        $client = new registeredUser();
        $client->Constructor_Mail($this->email);
        $client->FindUser();
        $this->id = $client->getId();    
    }
    
    function InsertPhotoToDB($image, $name){
        $this->loadPublicKey();
        $this->loadPrivateKey();
        
//        $image = base64_encode($image);
        //Decrypt SecKey2:
        $this->secKey2 = base64_decode($this->secKey2);
        openssl_private_decrypt($this->secKey2, $this->secKey2, $this->priv2);
//
        //Encrypt with Sec Key:
        $iv_size = 16;
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->secKey2, $image, MCRYPT_MODE_CBC, $iv);
        $ciphertext = $iv . $ciphertext;
        
        $image = $ciphertext;
        //Encrypt with Pub:
       openssl_public_encrypt($image, $image, $this->pub2);
       $image = base64_encode($image);
       

        mysqli_query(
            $this->db1,
                "INSERT INTO photos (user_fk, name, image) VALUES ('$this->id', '$name', '$image')"
        );
        $result = mysqli_affected_rows($this->db1);
        if($result){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    /**
     * Methodos pou kanw load to public keys apo tin DB:
     */
    function loadPublicKey(){
        $sql = "SELECT * FROM users WHERE id = '$this->id'";
        $result = $this->db1->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                    $this->pub2 = $row["PubKey2"];
                    $this->secKey2 = $row["SecKey2"];  
            }
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
                    $this->priv2 = $row["PrivateKey2"];
            }
        }
    }
    
    
}
