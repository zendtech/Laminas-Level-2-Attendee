<?php
/**
 * GuestbookAcl
 */
namespace src\modSecurity\Acl\UseCase;
use Zend\Permissions\Acl\Acl;
class GuestbookAcl extends Acl
{
    public function __construct($config, $container) {
        // add roles w/ inheritance
        foreach ($config['roles'] as $role => $inherits) {
            if ($inherits) {
                $this->addRole($role, $inherits);
            } else {
                $this->addRole($role);
            }
        }

        // add resources
        $resources = $config['resources'];
        foreach ($resources as $key => $class) {
            $this->addResource($class);
        }

        foreach ($config['rights'] as $role => $assignment) {
            foreach ($assignment as $key => $rights) {
                if (array_key_exists('allow', $rights)) {
                    $assert = (isset($rights['assert']))
                        ? $container->get($rights['assert']) : NULL;
                    $this->allow($role, $resources[$key], $rights['allow'], $assert);
                }
                if (array_key_exists('deny', $rights)) {
                    $assert = (isset($rights['assert']))
                        ? $container->get($rights['assert']) : NULL;
                    $this->deny($role, $resources[$key], $rights['deny'], $assert);
                }
            }
        }
        return $this;
    }
}