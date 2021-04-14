<?php
namespace Events\Entity;

use Laminas\Form\Annotation as ABC;
use Laminas\Form\Factory as FormFactory;
use Laminas\Hydrator\ClassMethodsHydrator;

/**
 * @ABC\Name("attendee")
 * @ABC\Hydrator("Laminas\Hydrator\ClassMethodsHydrator")
 */
class AttendeeEntity extends BaseEntity
{
    /**
     * @ABC\Name("name_on_ticket[]")
     * @ABC\Attributes({"type":"text","placeholder":"Name on Ticket","class":"input-xlarge"})
     * @ABC\Options({"label":"Name:"})
     * @ABC\Filter({"name":"StringTrim"})
     * @ABC\Filter({"name":"StripTags"})
     */
    public $name_on_ticket;

    /**
     * @return mixed
     */
    public function getNameOnTicket() {
        return $this->name_on_ticket;
    }

    /**
     * @param mixed $name_on_ticket
     */
    public function setNameOnTicket(string $name_on_ticket): void {
        $this->name_on_ticket = $name_on_ticket;
    }

    /**
     * Builds form for this entity
     *
     * @return Laminas\Form\Form $form
     */
    public static function buildForm()
    {
        $factory = new FormFactory();
        return $factory->createForm([
            'attributes' => ['name' => 'attendee'],
            'hydrator' => ClassMethodsHydrator::class,
            'elements' => [
                [
                    'spec' => [
                        'name' => 'name_on_ticket',
                        'attributes' => [
                            'class' => 'input-xlarge',
                            'placeholder' => 'Name on Ticket',
                        ],
                        'options' => ['label' => 'Name on Ticket'],
                        'type'  => 'text',
                    ],
                ],
            ],
            'input_filter' => [
                [
                    'name' => 'name_on_ticket',
                    'required' => TRUE,
                    'filters' => [
                        ['name' => 'StringTrim'],
                        ['name' => 'StripTags'],
                    ],
                ],
            ],
        ]);
    }
}
