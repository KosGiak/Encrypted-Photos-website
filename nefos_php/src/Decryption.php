<?php

class Decryption {
    private $secKey1, $secKey2;
    private $priv1, $priv2;
    private $givenPass, $passFromDB;
    
    function __construct() {}

    function ConstructorUser($secKey1, $priv1, $givenPass, $passFromDB) {
        $this->secKey1 = $secKey1;
        $this->priv1 = $priv1;
        $this->givenPass = $givenPass;
        $this->passFromDB = $passFromDB;
    }
    
    /**
     * Methodos pou kanw decrypt to password pu edwse o xristis.
     */
    function Decrypt(){
        $this->HashPass();
    }
    
    /**
     * Methodos pou epilego poio sec key tha ginei decrypt.
     */
    function ChooseSecKeyToDec($whoIs){
        if($whoIs == "1"){
            //Decrypt SecKey1
            $this->DecryptSecKey($this->secKey1);
        }
        else if($whoIs == "2"){
            //Decrypt SecKey2
            $this->DecryptSecKey($this->secKey2);
        }
    }
    
    function DecryptPass(){
        //$this->passFromDB = base64_decode($this->passFromDB);
        //echo '$this->passFromDB: ', $this->passFromDB;
        $this->passFromDB = base64_decode($this->passFromDB);
        openssl_private_decrypt($this->passFromDB, $this->passFromDB, $this->priv1);
        
        # --- DECRYPTION ---
    
        $iv_size = 16;
        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
        $iv_dec = substr($this->passFromDB, 0, $iv_size);

        # retrieves the cipher text (everything except the $iv_size in the front)
        $this->passFromDB = substr($this->passFromDB, $iv_size);

        # may remove 00h valued characters from end of plain text
        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->secKey1,
                                        $this->passFromDB, MCRYPT_MODE_CBC, $iv_dec);
    
        $plaintext_dec = substr($plaintext_dec, 0, -8);
//        echo strlen($plaintext_dec);
//        echo "</br>",strlen($this->givenPass);
//        echo "</br>",$plaintext_dec;
//        echo "</br>",$this->givenPass,"</br>";
        if($plaintext_dec == $this->givenPass){
//            echo "</br></br>true";
            return true;
        }
        else{
//            echo "</br></br>false";
            return false;
        }
        
    }
    
    /**
     * Methodos pou kanw Decrypt kapoio SecKey
     */
    private function DecryptSecKey($secKey){
//        echo $secKey;
        $secKey = base64_decode($secKey);
        
        openssl_private_decrypt($secKey, $secKey, $this->priv1);
        //echo "</br></br>sec key:  ", $secKey;
        $this->secKey1 = $secKey;
//        $this->secKey1 = base64_encode($this->secKey1);
//        echo "</br></br> Sec Key: ", $this->secKey1;
//        $this->secKey1 = base64_decode($this->secKey1);
    }
    /**
     * Methodos pou hasharw to password();
     */
    function HashPass(){
        $this->givenPass = sha1($this->givenPass);
    }
    
    function toString(){
        echo $this->secKey1, $this->priv1;
        echo "</br></br>", $this->givenPass;
        echo "</br></br>", $this->passFromDB;
    }

}
