<?php
/**
 * Description of CreateKeys
 *
 * @author Alcohealism
 */
class CreateKeys {
    private $priv, $pub, $secKey;
    
    function CreatePrivateAndPublicKey(){
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 8192,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );

        // Create the private and public key
        $res = openssl_pkey_new($config);

        // Extract the private key from $res to $privKey
        openssl_pkey_export($res, $privKey);

        // Extract the public key from $res to $pubKey
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];

//        $data = 'plaintext data goes here';
//
//        // Encrypt the data to $encrypted using the public key
//        openssl_public_encrypt($data, $encrypted, $pubKey);
//
//        // Decrypt the data using the private key and store the results in $decrypted
//        openssl_private_decrypt($encrypted, $decrypted, $privKey);
//
//echo $decrypted;
        $this->priv=$privKey;
        $this->pub=$pubKey;
//        echo "123",$this->priv;
//        echo $this->pub;
    }
    
    /**
     * Generate Secret Key
     * @param type $length
     */
    function CreateSecKey($length) {
        # --- ENCRYPTION ---

        # the key should be random binary, use scrypt, bcrypt or PBKDF2 to
        # convert a string into a key
        # key is specified using hexadecimal
        $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

        # show key size use either 16, 24 or 32 byte keys for AES-128, 192
        # and 256 respectively
        $key_size =  strlen($key);
        $this->secKey = $key;

//        $plaintext = "This string was AES-256 / CBC / ZeroBytePadding encrypted.";
//
//        # create a random IV to use with CBC encoding
//        //$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
//        $iv_size = 16;
//        //echo "iv size: ", $iv_size;
//        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
//
//        # creates a cipher text compatible with AES (Rijndael block size = 128)
//        # to keep the text confidential 
//        # only suitable for encoded input that never ends with value 00h
//        # (because of default zero padding)
//        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
//                                     $plaintext, MCRYPT_MODE_CBC, $iv);
//
//        # prepend the IV for it to be available for decryption
//        $ciphertext = $iv . $ciphertext;
//
//        # encode the resulting cipher text so it can be represented by a string
//        $ciphertext_base64 = base64_encode($ciphertext);
//
//        $this->secKey = $ciphertext_base64;
//
//        # === WARNING ===
//
//        # Resulting cipher text has no integrity or authenticity added
//        # and is not protected against padding oracle attacks.
//
//        # --- DECRYPTION ---
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
//        $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
//                                        $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
//
//        //echo  $plaintext_dec . "\n";
      }

    function getPriv() {
        return $this->priv;
    }

    function getPub() {
        return $this->pub;
    }

    function getSecKey() {
        return $this->secKey;
    }

    function setPriv($priv) {
        $this->priv = $priv;
    }

    function setPub($pub) {
        $this->pub = $pub;
    }

    function setSecKey($secKey) {
        $this->secKey = $secKey;
    }


}
