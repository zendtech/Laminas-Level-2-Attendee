<?php
/**
 * CustomRbac
 */
namespace src\modSecurity\Rbac;
use Zend\Permissions\Rbac\{Rbac, Role};
class CustomRbac extends Rbac
{
    public function setRole(Role $role){
        $role->addPermission('post-controller');
        $this->addRole($role);
    }
}