<?php
namespace Login\Security;
use Laminas\Crypt\Password\Bcrypt;

class PasswordSecurity
{
    public static function createHash($plainText)
    {
        return (new Bcrypt())->create($plainText);
    }

    public static function verify($plainText, $hash)
    {
        return (new Bcrypt())->verify($plainText, $hash);
    }
}