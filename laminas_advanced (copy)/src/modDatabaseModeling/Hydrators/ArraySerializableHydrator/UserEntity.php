<?php
/**
 * UserEntity
 */
namespace src\modDatabaseModeling\Hydrators\ArraySerializableHydrator;
class UserEntity {
    protected $id, $firstName, $lastName, $email, $password;

    public function exchangeArray($data) {
        foreach (get_object_vars($this) as $varName => $value) {
            if (isset($data[$varName]))
                $this->$varName = $data[$varName];
        }
    }
}