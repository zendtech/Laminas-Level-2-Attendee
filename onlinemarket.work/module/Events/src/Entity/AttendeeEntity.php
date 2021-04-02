<?php
namespace Events\Entity;

/**
 * @ABC\Name("attendee")
 * @ABC\Hydrator("Laminas\Hydrator\ArraySerializableHydrator")
 */
class AttendeeEntity extends BaseEntity
{
	/**
	 * @ABC\Exclude()
     */
    public $registration_id;

	/**
	 * @ABC\Name("name_on_ticket[]")
	 * @ABC\Attributes({"type":"text","placeholder":"Name on Ticket","class":"input-xlarge"})
     * @ABC\Options({"label":"Name:"})
     * @ABC\Filter({"name":"StringTrim"})
     * @ABC\Filter({"name":"StripTags"})
     */
    public $name_on_ticket;
}
