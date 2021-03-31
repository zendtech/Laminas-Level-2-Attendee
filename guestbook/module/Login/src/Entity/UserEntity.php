<?php
namespace Login\Entity;
use Application\Model\AbstractModel;
class UserEntity extends AbstractModel
{
    const DEFAULT_LOCALE = 'en';
    protected $mapping = [
        'id' => 'id',
        'email' => 'email',
        'username' => 'username',
        'password' => 'password',
        'securityquestion' => 'security_question',
        'securityanswer' => 'security_answer',
        'locale' => 'locale',
    ];
}
