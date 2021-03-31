<?php
namespace Model\Model;
use Login\Security\PasswordSecurity;
use Model\Entity\UserEntity;
use Application\Model\AbstractTableGateway;

class UsersModel extends AbstractTableGateway
{

    public const TABLE_NAME = 'users';
    public function findAll()
    {
        return $this->tableGateway->select();
    }
    public function findById($id)
    {
        return $this->tableGateway->select(['id' => $id])->current();
    }
    public function save(UserEntity $user)
    {
        $data = $this->tableGateway->getResultSetPrototype()->getHydrator()->extract($user);
        //*** PASSWORD LAB: modify this to use the Login\Security\PasswordSecurity class to hash the password
        $data['password'] = PasswordSecurity::createHash($data['password']);
        return $this->tableGateway->insert($data);
    }
}
