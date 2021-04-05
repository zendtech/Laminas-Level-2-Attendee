<?php
/**
 * UserEntity
 */
namespace src\modOtherComponents\CrossCuttingConcerns;
class UserEntity {
    protected $id, $username, $email;
    protected $emailIsValid = false;
    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = (int)$id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->validateEmail($email);
        $this->email = $this->emailIsValid ? $email : false;
    }
    protected function validateEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->emailIsValid = true;
        }
    }
}