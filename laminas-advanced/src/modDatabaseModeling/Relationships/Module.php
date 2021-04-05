<?php
/**
 * Module
 */
namespace src\modDatabaseModeling\Relationships;
class Module
{
    public function getServiceConfig() {
        return [
            'factories' => [
                EventTable::class => function ($container, $requestedName) {
                    return new $requestedName(
                        $container->get('events-db-adapter'), $container->get(EventEntity::class));
                },
                RegistrationTable::class => function ($container, $requestedName) {
                    return new $requestedName(
                        $container->get('events-db-adapter'), $container->get(RegistrationEntity::class));
                },
                AttendeeTable::class => function ($container, $requestedName) {
                    return new $requestedName(
                        $container->get('events-db-adapter'), $container->get(AttendeeEntity::class));
                },
            ]
        ];
        // ...
    }
}