<?php
/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author         Haroon
 *
 * */
trait erpEncryption {

    function dataEncryption($inputData){ 
        
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '12345678910111212222222';
        $encryption_key = "wosa";
        return $encryption = openssl_encrypt($inputData, $ciphering, $encryption_key, $options, $encryption_iv);       
    }

    function dataDecryption($inputData){
        
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = '12345678910111212222222';
        $decryption_key = "wosa";
        return $decryption = openssl_decrypt($inputData, $ciphering, $decryption_key, $options, $decryption_iv);
    }
}