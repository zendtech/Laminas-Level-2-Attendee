<?php
/**
 * Email
 */
namespace src\modOtherComponents\CrossCuttingConcerns;
class EmailValueObject
{
    protected $email;
    public function __construct(string $email) {
        $this->email = $email;
    }
    public function getEmail() { return $this->email; }
}