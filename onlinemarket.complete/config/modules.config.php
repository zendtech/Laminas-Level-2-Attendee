<?php
return [
    'Zend\Session',
    'Zend\Cache',
    'Zend\Form',
    'Zend\InputFilter',
    'Zend\Filter',
    'Zend\Hydrator',
    'Zend\I18n',
    'Zend\Db',
    'Zend\Log',
    'Zend\Router',
    'Zend\Validator',
    'Zend\Mvc\Plugin\FlashMessenger',
    'Application',
    'Market',
    'Model',
    //*** DATABASE LABS
    'Events',
    //*** DELEGATORS LAB
    'Registration',
    'SecurePost',   // disable this and CSRF element disappears from the form
    //*** CACHE LAB
    'Cache',
    //*** SESSION LAB
    'PhpSession',
    //*** LOGGER LAB
    'Logging',
    //*** EMAIL LAB
    'Zend\Mail',
    'Notification',
    //*** AUTHENTICATION LAB
    'Login',
    //*** ACL Lab
    'AccessControl',
    'PrivateMessages',
    //*** NAVIGATION LAB
    'Zend\Navigation',
    //*** REST LAB
    'RestApi',
];
