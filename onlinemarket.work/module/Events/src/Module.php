<?php
namespace Events;
use AccessControl\Acl\MarketAcl;
use Events\Model\{AttendeeTableModel,
    EventTableModel,
    Factory\TableAbstractFactory,
    RegistrationTableModel};
use Events\Controller\{
    IndexController,
    AdminController,
    AjaxController,
    SignUpController
};
use Events\Entity\{
    RegistrationEntity,
    AttendeeEntity
};
use Events\Form\{
    AttendeeFieldset,
    RegistrationFieldset
};
use Laminas\Filter\{
    FilterChain,
    StringTrim,
    StripTags
};
use Interop\Container\ContainerInterface;
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
                        $container->get(MarketAcl::class),
                        $container->get('login-auth-service')
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
                        $container->get('events-registration-form')
                    );
                },
            ],
        ];
    }
    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'events-db-adapter' => 'model-primary-adapter',
            ],
            'factories' => [
                'events-registration-data-filter' => function () {
                    $filter = new FilterChain();
                    $filter->attach(new StringTrim())
                           ->attach(new StripTags());
                    return $filter;
                },
                'events-registration-form' => function (ContainerInterface $container) {
					$registrationForm = (new AnnotationBuilder())->createForm($container->get(RegistrationEntity::class));
					$attendeeForm = $container->get('events-attendee-form');
                    // $attendeeFieldset = $container->get('events-attendee-fieldset');
                    // $registrationFieldset = $container->get('events-registration-fieldset');

					for ($x = 0; $x < self::MAX_NAMES_PER_TICKET; $x++) {
                        $registrationForm->add(clone $attendeeForm, ['name' => 'attendee_' . $x]);
                        // The below is used if fieldsets are desired.
                        // $registrationForm->add(clone $attendeeFieldset);
                        // $registrationForm->add(clone $registrationFieldset);

                    }

					return $registrationForm;
				},
                'events-attendee-form' => function (ContainerInterface $container) {
					return (new AnnotationBuilder())->createForm($container->get(AttendeeEntity::class));
				},
                // This service assumes a fieldset class definition.
//                'events-registration-fieldset' => function (ContainerInterface $container){
//                    return new RegistrationFieldset(
//                        'registration',
//                        new ObjectPropertyHydrator(),
//                        $container->get(RegistrationEntity::class)
//                    );
//                },

                // This service assumes a fieldset class definition
//                'events-attendee-fieldset' => function (ContainerInterface $container){
//                    return new AttendeeFieldset(
//                        'registration',
//                        new ObjectPropertyHydrator(),
//                        $container->get(AttendeeEntity::class)
//                    );
//                },

                'events-service-container' => function (ContainerInterface $container) {
                    return $container;
                },
                //*** DELEGATING HYDRATOR LAB: define a service which returns an instance of Laminas\Hydrator\DelegatingHydrator
                'events-delegating-hydrator' => function (ContainerInterface $container) {
                    //*** DELEGATING HYDRATOR LAB: assign a "ObjectProperty" hydrator to the "RegistrationEntity" entity and "ClassMethods" to the others
                },

				'events-navigation' => function (ContainerInterface $container) {
	                $factory = new ConstructedNavigationFactory($container->get('events-nav-Config'));
                    return $factory->createService($container);
				},
            ],
        ];
    }
}

