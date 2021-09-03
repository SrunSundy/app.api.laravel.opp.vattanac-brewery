<?php

namespace App\Core;

class EncryptLib
{
    private static $password;
    private static $iv;

    public static function encryptString($plaintext)
    {
        self::$password = config('erp.credential.cipher.password');
        self::$iv = config('erp.credential.cipher.iv');
        $ciphertext = openssl_encrypt($plaintext, "AES-256-CBC", self::$password, OPENSSL_RAW_DATA, self::$iv);

        return base64_encode($ciphertext);
    }

    public static function decryptString($ciphertext)
    {
        self::$password = config('erp.credential.cipher.password');
        self::$iv = config('erp.credential.cipher.iv');
        $str = openssl_decrypt(base64_decode($ciphertext), 'AES-256-CBC', self::$password, OPENSSL_RAW_DATA, self::$iv);
        return $str;
    }
}
