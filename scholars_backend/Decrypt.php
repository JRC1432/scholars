<?php


class Decrypt {
    
    public static function Decode(string $input, string $key, string $enc_method = 'AES-256-CBC')
    {
        $enc_iv = self::_generateIV($key, openssl_cipher_iv_length($enc_method));

        return openssl_decrypt(base64_decode($input), $enc_method, $key, 0, $enc_iv);
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

// Developed By: CASTAÑARES, JONATHAN R.