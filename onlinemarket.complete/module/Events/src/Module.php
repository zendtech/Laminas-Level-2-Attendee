<?php
namespace Events;
use AccessControl\Acl\MarketAcl;
use Events\Model\{
    AttendeeTableModel,
    EventTableModel,
    RegistrationTableModel
};
use Events\Controller\{
    IndexController,
    AdminController,
    AjaxController,
    SignUpController
};
use Events\Entity\{
    EventEntity,
    RegistrationEntity,
    AttendeeEntity
};
use Events\Fieldset\{
    AttendeeFieldset,
    RegistrationFieldset
};
use Laminas\Filter\{
    FilterChain,
    StringTrim,
    StripTags
};
use Laminas\Db\ {ResultSet\HydratingResultSet,
    TableGateway\TableGateway
};
use Interop\Container\ContainerInterface;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\Form\Annotation\AnnotationBuilder;
//*** DELEGATING HYDRATOR LAB: add the correct "use" statements
//*** NAVIGATION LAB: add "use" statement for the ConstructedNavigationFactory
use Laminas\Navigation\Service\ConstructedNavigationFactory;

class Module
{
    const MAX_NAMES_PER_TICKET = 6;
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                IndexController::class => function ($container, $requestedName) {
                    return new $requestedName(
                        // ACL added by future lab, then will be the first param
                        $container->get('login-auth-service'),
                        $container->get(MarketAcl::class),
                    );
                },
                AdminController::class  => function ($container, $requestedName) {
                    return new $requestedName(
                        $container->get(EventTableModel::class),
                        $container->get(RegistrationTableModel::class)
                    );
                },
                AjaxController::class  => function ($container, $requestedName) {
                    return new $requestedName(
                        $container->get(RegistrationTableModel::class),
                        $container->get(AttendeeTableModel::class)
                    );
                },
                SignUpController::class => function ($container, $requestedName) {
                    return new $requestedName(
                        $container->get(EventTableModel::class),
                        $container->get(RegistrationTableModel::class),
                        $container->get(AttendeeTableModel::class),
                        $container->get('events-registration-data-filter'),
                        $container->get('events-registration-form'),
                        new ClassMethodsHydrator()
                    );
                },
            ],
        ];
    }
    public function getServiceConfig()
    {
        return [
            'abstract_factories' => [
                //*** ABSTRACT FACTORIES LAB: define a single abstract factory to build these usersModelTableGateway classes
                /*
                Model\EventTableModel::class => function ($container, $requestedName) {
                    return new $requestedName($container->get('events-db-adapter'),
                                              $container->get(EventEntity::class),
                                              $container);
                },
                Model\RegistrationTableModel::class => function ($container, $requestedName) {
                    return new $requestedName($container->get('events-db-adapter'),
                                              $container->get(RegistrationEntity::class),
                                              $container);
                },
                Model\AttendeeTableModel::class => function ($container, $requestedName) {
                    return new $requestedName($container->get('events-db-adapter'),
                                              $container->get(AttendeeEntity::class),
                                              $container);
                },
                */
            ],
            'factories' => [
                'events-registration-data-filter' => function () {
                    $filter = new FilterChain();
                    $filter->attach(new StringTrim())
                           ->attach(new StripTags());
                    return $filter;
                },
                'events-registration-form' => function (ContainerInterface $container) {
                    $registrationForm = RegistrationEntity::buildForm();
                    //$registrationForm = (new AnnotationBuilder())->createForm(RegistrationEntity::class);
                    $attendeeForm = $container->get('events-attendee-form');
                    $attendeeFieldset = $container->get('events-attendee-fieldset');
                    $registrationFieldset = $container->get('events-registration-fieldset');

                    for ($x = 0; $x < self::MAX_NAMES_PER_TICKET; $x++) {
                        $registrationForm->add(clone $attendeeForm, ['name' => 'attendee_' . $x]);
                        // The below is used if fieldsets are desired.
                        // $registrationForm->add(clone $attendeeFieldset);
                        // $registrationForm->add(clone $registrationFieldset);
                    }

                    return $registrationForm;
                },
                'events-attendee-form' => function (ContainerInterface $container) {
                    return AttendeeEntity::buildForm();
                },
                // This service assumes a fieldset class definition.
                'events-registration-fieldset' => function (ContainerInterface $container){
                    return new RegistrationFieldset(
                        'registration',
                        new ObjectPropertyHydrator(),
                        $container->get(RegistrationEntity::class)
                    );
                },

                // This service assumes a fieldset class definition
                'events-attendee-fieldset' => function (ContainerInterface $container){
                    return new AttendeeFieldset(
                        'registration',
                        new ObjectPropertyHydrator(),
                        $container->get(AttendeeEntity::class)
                    );
                },

                'events-service-container' => function (ContainerInterface $container) {
                    return $container;
                },
                'events-table-resultSet' => function (ContainerInterface $container){
                    return new HydratingResultSet(
                        new ClassMethodsHydrator(),
                        $container->get(EventEntity::class)
                    );
                },
                'events-events-tableGateway' => function (ContainerInterface $container){
                    return new TableGateway(
                        EventTableModel::TABLE_NAME,
                        $container->get('model-primary-adapter'),
                        NULL,
                        $container->get('events-table-resultSet')
                    );
                },
                'events-registration-tableGateway' => function (ContainerInterface $container){
                    return new TableGateway(
                        RegistrationTableModel::TABLE_NAME,
                        $container->get('model-primary-adapter'),
                        NULL,
                        $container->get('reg-table-resultSet')
                    );
                },
                'events-attendee-tableGateway' => function (ContainerInterface $container){
                    return new TableGateway(
                        AttendeeTableModel::TABLE_NAME,
                        $container->get('model-primary-adapter'),
                        NULL,
                        $container->get('attendee-table-resultSet')
                    );
                },
                //*** DELEGATING HYDRATOR LAB: define a service which returns an instance of Laminas\Hydrator\DelegatingHydrator
                'events-delegating-hydrator' => function (ContainerInterface $container) {
                    //*** DELEGATING HYDRATOR LAB: assign a "ObjectProperty" hydrator to the "RegistrationEntity" entity and "ClassMethods" to the others
                },

                'events-navigation' => function (ContainerInterface $container) {
                    $factory = new ConstructedNavigationFactory($container->get('events-nav-config'));
                    return $factory->createService($container);
                },
                'reg-table-resultSet' => function (ContainerInterface $container){
                    return new HydratingResultSet(
                        new ClassMethodsHydrator(),
                        $container->get(RegistrationEntity::class)
                    );
                },
                'attendee-table-resultSet' => function (ContainerInterface $container){
                    return new HydratingResultSet(
                        new ClassMethodsHydrator(),
                        $container->get(AttendeeEntity::class)
                    );
                },
            ],
        ];
    }
}

