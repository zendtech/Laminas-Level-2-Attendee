<?php
namespace Login\Security;

use Laminas\Crypt\Password\Bcrypt;

class PasswordSecurity
{
    public static function createHash($plainText)
    {
        $bcrypt = new Bcrypt();
        return $bcrypt->create($plainText);
    }
    public static function verify($plainText, $hash)
    {
        $bcrypt = new Bcrypt();
        return $bcrypt->verify($plainText, $hash);
    }
}
