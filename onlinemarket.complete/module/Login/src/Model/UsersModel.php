<?php
namespace Login\Model;
use Application\Model\AbstractTableGateway;
use Model\Entity\UserEntity;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Hydrator\HydratorInterface;
use Login\Security\PasswordSecurity;

class UsersModel extends AbstractTableGateway
{
    public const TABLE_NAME = 'users';
    public const IDENTITY_COL = 'email';
    public const PASSWORD_COL = 'password';
    protected $adapter, $userEntity, $hydrator;
    public function __construct(
        AdapterInterface $adapter,
        UserEntity $userEntity,
        HydratorInterface $hydrator,
        TableGatewayInterface $tableGateway)
    {
        parent::__construct($tableGateway);
        $this->adapter = $adapter;
        $this->userEntity = $userEntity;
        $this->hydrator = $hydrator;
    }
    public function save($userEntity){
        $userEntity->setPassword(PasswordSecurity::createHash($userEntity->getPassword()));
        $data = $userEntity->extractForDatabase();
        return $this->tableGateway->insert($data);
    }
}
