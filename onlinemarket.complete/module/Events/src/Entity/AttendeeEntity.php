<?php
namespace Events\Entity;

/**
 * @ABC\Name("attendee")
 * @ABC\Hydrator("Zend\Hydrator\ClassMethodsHydrator")
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
    protected $name_on_ticket;

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
}
