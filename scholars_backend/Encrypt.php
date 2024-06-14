<?php

class Encrypt
{

    public static function Encode(string $input, string $key, string $enc_method = 'AES-256-CBC')
    {
        $enc_iv = self::_generateIV($key, openssl_cipher_iv_length($enc_method));

        return base64_encode(openssl_encrypt($input, $enc_method, $key, 0, $enc_iv));
    }


    public static function _generateIV($key, $size)
    {
        $hash = base64_encode(md5($key));
        while (strlen($hash) < $size) {
            $hash = $hash . $hash;
        }
        return substr($hash, 0, $size);
    }
}
