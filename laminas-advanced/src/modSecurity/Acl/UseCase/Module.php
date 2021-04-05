<?php
/**
 * Module
 */
namespace src\modSecurity\Acl\UseCase;
class Module
{
    const DEFAULT_ROLE = 'guest';
    const DEFAULT_ACTION = 'index';
    const DEFAULT_CONTROLLER = 'Guestbook\Controller\GuestbookController';

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }
}