<?php

class Encryption {
    private $pub, $secKey, $encrypted, $enSecKey;
    
    function __construct() {
    }
    
    function Constroctor_Pub_Sec_EnMSG_EnSec($pub, $secKey, $encrypted, $enSecKey) {
        $this->pub = $pub;
        $this->secKey = $secKey;
        $this->encrypted = $encrypted;
        $this->enSecKey = $enSecKey;
    }

    function Constructor_Pub_Sec_Msg($pub, $secKey, $encrypted){
        $this->pub = $pub;
        $this->secKey = $secKey;
        $this->encrypted = $encrypted;
//        echo 'pub: ', $this->pub;
//        echo '</br>sec: ', $this->secKey;
//        echo '<img height="600" width="800" src="data:image;base64,'.$this->encrypted.'">';
    }
    
    function Constructor_Pub_Sec($pub, $secKey){
        $this->pub = $pub;
        $this->secKey = $secKey;
    }
    /**
     * Hybrid encryption $encrypted
     */
    function Encrypt(){
        $this->HashPass();//hashing password
        $this->SecKeyEncryption();//encrypt pass with SecKey
        $this->publicEncryption();//Encrypt pass with pub key
    }
    
    /**
     * Methodos pou kriptografw me to SecKey
     */
    function SecKeyEncryption(){
//        $this->secKey = base64_encode($this->secKey);
//        echo "</br></br> Sec Key: ", $this->secKey;
//        $this->secKey = base64_decode($this->secKey);
        $iv_size = 16;
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->secKey, $this->encrypted, MCRYPT_MODE_CBC, $iv);
        $ciphertext = $iv . $ciphertext;
        

        $this->encrypted = $ciphertext;
//        echo "SecKeyEncryption:  ", $this->encrypted;
        
//                # --- DECRYPTION ---
//
//        $ciphertext_dec = base64_decode($ciphertext_base64);
//
//        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
//        $iv_dec = substr($ciphertext_dec, 0, $iv_size);
//
//        # retrieves the cipher text (everything except the $iv_size in the front)
//        $ciphertext_dec = substr($ciphertext_dec, $iv_size);
//
//        # may remove 00h valued characters from end of plain text
//        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->secKey,
//                                        $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
//
//        echo  "             ", $plaintext_dec . "\n";
    }
    /**
     * Methodos pou kriptografw me to public key
     */
    function publicEncryption(){ 
        openssl_public_encrypt($this->encrypted, $this->encrypted, $this->pub);
        $this->encrypted = base64_encode($this->encrypted);
    }
    
    /**
     * Methodos pou kriptografw to SecKey me to public:
     */
    function SecKeyWithPubKey(){
//        echo "arxi: ",$this->secKey;
        openssl_public_encrypt($this->secKey, $this->enSecKey, $this->pub);
        $this->enSecKey = base64_encode($this->enSecKey);
//        echo "</br>----------------SecKey START-------------------------------</br>";
//        echo $this->enSecKey;
//        echo "</br>----------------SecKey END-------------------------------</br>";
    }

    /**
     * Methodos pou hasharw to password();
     */
    function HashPass(){
        $this->encrypted = sha1($this->encrypted);
    }
    
    //Getters && Setters:
    function getPub() {
        return $this->pub;
    }

    function getSecKey() {
        return $this->secKey;
    }

    function getEncrypted() {
        return $this->encrypted;
    }

    function getEnSecKey() {
        return $this->enSecKey;
    }

    function setPub($pub) {
        $this->pub = $pub;
    }

    function setSecKey($secKey) {
        $this->secKey = $secKey;
    }

    function setEncrypted($encrypted) {
        $this->encrypted = $encrypted;
    }

    function setEnSecKey($enSecKey) {
        $this->enSecKey = $enSecKey;
    }
}
