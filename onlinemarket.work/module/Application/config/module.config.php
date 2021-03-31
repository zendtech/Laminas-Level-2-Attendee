<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\View\Helper as ViewHelper;
use Zend\Form\View\Helper as FormHelper;
use Zend\ServiceManager\Factory\InvokableFactory;
//*** NAVIGATION LAB: activate the NavigationAbstractServiceFactory
use Zend\Navigation\Service\NavigationAbstractServiceFactory;

return [
    'router' => [
        'routes' => [
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'services' => [
            'expire-days' => [
                0  => 'Never',
                1  => 'Tomorrow',
                7  => 'Week',
                30 => 'Month',
            ],
            'captcha-options' => [
                'expiration' => 300,
                'fontSize'	=> 24,
                'height'	=> 50,
                'width'		=> 200,
                // These two paths are relative to the configuration directory
                'font'		=> __DIR__ . '/../../../public/fonts/FreeSansBold.ttf',
                'imgDir'	=> __DIR__ . '/../../../public/captcha',
                // This URL is relative to the host.
                'imgUrl'	=> '../../public/captcha',
            ],
        ],

        //*** NAVIGATION LAB: activate the default navigation factory
        'abstract_factories' => [
            NavigationAbstractServiceFactory::class
        ],
        'factories' => [
			Event\AppEventAggregate::class => InvokableFactory::class
        ],
    ],
    'listeners' => [
		Event\AppEventAggregate::class
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            Helper\LeftLinks::class => InvokableFactory::class,
            FormHelper\Form::class => InvokableFactory::class,
            FormHelper\FormRow::class => InvokableFactory::class,
            FormHelper\FormLabel::class => InvokableFactory::class,
            FormHelper\FormHidden::class => InvokableFactory::class,
            FormHelper\FormCaptcha::class => InvokableFactory::class,
            FormHelper\FormFile::class => InvokableFactory::class,
            FormHelper\FormEmail::class => InvokableFactory::class,
            FormHelper\FormRadio::class => InvokableFactory::class,
            FormHelper\FormSelect::class => InvokableFactory::class,
            FormHelper\FormSubmit::class => InvokableFactory::class,
            FormHelper\FormText::class => InvokableFactory::class,
            FormHelper\FormTextarea::class => InvokableFactory::class,
            FormHelper\FormPassword::class => InvokableFactory::class,
            FormHelper\FormCollection::class => InvokableFactory::class,
            FormHelper\FormElement::class => InvokableFactory::class,
            FormHelper\FormElementErrors::class => InvokableFactory::class,
            FormHelper\Captcha\Image::class => InvokableFactory::class,
            ViewHelper\FlashMessenger::class => InvokableFactory::class,
        ],
        'aliases' => [
            'leftLinks' => Helper\LeftLinks::class,
            'form' => FormHelper\Form::class,
            'formrow' => FormHelper\FormRow::class,
            'formHidden' => FormHelper\FormHidden::class,
            'formCaptcha' => FormHelper\FormCaptcha::class,
            'formFile' => FormHelper\FormFile::class,
            'formEmail' => FormHelper\FormEmail::class,
            'formRadio' => FormHelper\FormRadio::class,
            'formSelect' => FormHelper\FormSelect::class,
            'formSubmit' => FormHelper\FormSubmit::class,
            'formText' => FormHelper\FormText::class,
            'formTextarea' => FormHelper\FormTextarea::class,
            'formPassword' => FormHelper\FormPassword::class,
            'formcollection' => FormHelper\FormCollection::class,
            'formLabel' => FormHelper\FormLabel::class,
            'form_label' => FormHelper\FormLabel::class,
            'form_element' => FormHelper\FormElement::class,
            'formElementErrors' => FormHelper\FormElementErrors::class,
            'captcha/image' => FormHelper\Captcha\Image::class,
        ],
    ],
    //*** ACL LAB
    'access-control-Config' => [
        'resources' => [
            //*** define a resource 'application-index' which points to 'Application\Controller\IndexController'
            'application-index' => 'Application\Controller\IndexController',
        ],
        'rights' => [
            'guest' => [
                //*** for the 'doctrine-index' resource, guests should be allowed any action
                'application-index' => ['allow' => NULL],
            ],
        ],
    ],
];
