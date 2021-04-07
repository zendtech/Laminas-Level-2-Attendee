<?php
require __DIR__ . '/vendor/autoload.php';
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Form\Annotation\AnnotationBuilder;
/**
 * @ABC\Name("attendee")
 * @ABC\Hydrator("Laminas\Hydrator\ClassMethodsHydrator")
 */
class AttendeeEntity {
    /**
    * @ABC\Name("name")
    * @ABC\Attributes({"type":"text","placeholder":"Name on Ticket"})
    * @ABC\Options({"label":"Name:"})
    * @ABC\Filter({"name":"StringTrim"})
    * @ABC\Filter({"name":"StripTags"})
    */
    protected $name;
}
$form = (new AnnotationBuilder())->createForm('AttendeeEntity');
echo get_class($form);
