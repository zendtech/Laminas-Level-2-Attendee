<?php
namespace Login\Model;

use Model\Entity\User;
use Login\Security\Password;
use Application\Model\AbstractTable;

class UsersModel extends AbstractTable
{
    public static $tableName = 'users';
    public static $identityCol = 'email';
    public static $passwordCol = 'password';
}
