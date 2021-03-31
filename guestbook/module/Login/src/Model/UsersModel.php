<?php
namespace Login\Model;
use Application\Model\ {AbstractTable, AbstractModel};
use Login\Security\PasswordSecurity;
use Zend\Db\Adapter\AdapterInterface;

class UsersModel extends AbstractTable
{

    public const TABLE_NAME = 'users';
    public const IDENTITY_COL = 'email';
    public const PASSWORD_COL = 'password';

    public function __construct(AdapterInterface $adapter, AbstractModel $userModel) {
        $this->setTableGateway($adapter, $userModel);
    }

    public function findByEmail($email)
    {
        return $this->tableGateway->select(['email' => $email])->current();
    }
    public function save(AbstractModel $user)
    {
        $user->setPassword(PasswordSecurity::createHash($user->getPassword()));
        return $this->tableGateway->insert($user->extract());
    }
}
