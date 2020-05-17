<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DecryptPhoto
 *
 * @author Alcohealism
 */
class DecryptPhoto {
    private $priv2, $pub2, $secKey2, $image;
    private $db1, $db2;
    private $id;
     
    function __construct($id, $image) {
        $this->id = $id;
        $this->image = $image;
        $db = new DataBase();
        $this->db1 = $db->NefosDB();
        $this->db2 = $db->PrivateKeys();
        $this->loadPrivateKey();
        $this->loadPublicKey();
        $this->DecryptSecKey2();
        $this->DecryptWithPrivate();
//        echo 'priv2: ', $this->priv2;
//        echo '</br></br>pub2: ', $this->pub2;
//        echo '</br></br>sec2: ', base64_encode($this->secKey2);
    }
    
    function DecryptWithPrivate(){
                # --- DECRYPTION ---

        $this->image = base64_decode($this->image);
        openssl_private_decrypt($this->image, $this->image, $this->priv2);
        
        # --- DECRYPTION ---
    
        $iv_size = 16;
        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
        $iv_dec = substr($this->image, 0, $iv_size);

        # retrieves the cipher text (everything except the $iv_size in the front)
        $this->image = substr($this->image, $iv_size);

        # may remove 00h valued characters from end of plain text
        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->secKey2,
                                        $this->image, MCRYPT_MODE_CBC, $iv_dec);
        $this->image = $plaintext_dec;
    }
    
    /**
     * Methodos pou kanw Decrypt kapoio SecKey
     */
    private function DecryptSecKey2(){
        $secKey = base64_decode($this->secKey2);
        openssl_private_decrypt($secKey, $secKey, $this->priv2);
        $this->secKey2 = $secKey;
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

    
    function getPriv2() {
        return $this->priv2;
    }

    function getPub2() {
        return $this->pub2;
    }

    function getSecKey2() {
        return $this->secKey2;
    }

    function getImage() {
        return $this->image;
    }

    function getDb1() {
        return $this->db1;
    }

    function getDb2() {
        return $this->db2;
    }

    function getId() {
        return $this->id;
    }

    function setPriv2($priv2) {
        $this->priv2 = $priv2;
    }

    function setPub2($pub2) {
        $this->pub2 = $pub2;
    }

    function setSecKey2($secKey2) {
        $this->secKey2 = $secKey2;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setDb1($db1) {
        $this->db1 = $db1;
    }

    function setDb2($db2) {
        $this->db2 = $db2;
    }

    function setId($id) {
        $this->id = $id;
    }


}
