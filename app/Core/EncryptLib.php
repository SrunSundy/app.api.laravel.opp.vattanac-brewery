<?php

namespace App\Core;

class EncryptLib
{
    private static $password;
    private static $iv;

    public static function encryptString($plaintext, $password = null, $iv = null)
    {
        self::setPasswordAndIv($password, $iv);
        $ciphertext = openssl_encrypt($plaintext, "AES-256-CBC", self::$password, OPENSSL_RAW_DATA, self::$iv);

        return base64_encode($ciphertext);
    }

    public static function decryptString($ciphertext, $password = null, $iv = null)
    {
        self::setPasswordAndIv($password, $iv);
        $str = openssl_decrypt(base64_decode($ciphertext), 'AES-256-CBC', self::$password, OPENSSL_RAW_DATA, self::$iv);
        return $str;
    }

    protected static function setPasswordAndIv($password, $iv)
    {
        if ($password) {
            self::$password = $password;
        } else {
            self::$password = config('erp.credential.cipher.password');
        }

        if ($iv) {
            self::$iv = $iv;
        } else {
            self::$iv = config('erp.credential.cipher.iv');
        }
    }
}
