<?php
/**
 * UserEntity
 */
namespace src\modDatabaseModeling\HydratingResultSet;
class UserEntity {
    protected $id, $username, $security_question, $security_answer, $role, $provider, $locale;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = (int)$id;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getSecurityQuestion()
    {
        return $this->security_question;
    }

    public function setSecurityQuestion($security_question): void
    {
        $this->security_question = $security_question;
    }

    public function getSecurityAnswer()
    {
        return $this->security_answer;
    }

    public function setSecurityAnswer($security_answer): void
    {
        $this->security_answer = $security_answer;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role): void
    {
        $this->role = $role;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function setProvider($provider): void
    {
        $this->provider = $provider;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }
}