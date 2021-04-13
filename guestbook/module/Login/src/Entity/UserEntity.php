<?php
namespace Login\Entity;
use Application\Model\AbstractModel;
class UserEntity extends AbstractModel
{
    const DEFAULT_LOCALE = 'en';
    const DEFAULT_USER = 'guest';
    protected $mapping = [
        'id' => 'id',
        'email' => 'email',
        'username' => 'username',
        'password' => 'password',
        'securityquestion' => 'security_question',
        'securityanswer' => 'security_answer',
        'locale' => 'locale',
        'role' => 'role'
    ];
}
