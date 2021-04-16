<?php
namespace Events\Entity;

/**
 * @ABC\Name("registration")
 * @ABC\Hydrator("Laminas\Hydrator\ClassMethodsHydrator")
 */
class RegistrationEntity extends BaseEntity
{
    /**
     * @ABC\Exclude()
     */
    public $event_id;

    /**
     * @ABC\Attributes({"type":"text","placeholder":"First Name","class":"input-xlarge"})
     * @ABC\Options({"label":"First Name:"})
     * @ABC\Filter({"name":"StringTrim"})
     * @ABC\Filter({"name":"StripTags"})
     */
    public $first_name;

    /**
     * @ABC\Attributes({"type":"text","placeholder":"Last Name","class":"input-xlarge"})
     * @ABC\Options({"label":"Last Name:"})
     * @ABC\Filter({"name":"StringTrim"})
     * @ABC\Filter({"name":"StripTags"})
     */
    public $last_name;

    /**
     * @ABC\Exclude()
     */
    public $registration_time;

    /**
     * @ABC\Exclude()
     */
    public $attendees = [];

    /**
     * @return mixed
     */
    public function getEventId() {
        return $this->event_id;
    }

    /**
     * @param mixed $event_id
     */
    public function setEventId($event_id) {
        $this->event_id = $event_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name) {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegistrationTime() {
        return $this->registration_time;
    }

    /**
     * @param mixed $registration_time
     */
    public function setRegistrationTime($registration_time) {
        $this->registration_time = $registration_time;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void {
        $this->last_name = $last_name;
    }

    /**
     * @return array
     */
    public function getAttendees(): array {
        return $this->attendees;
    }

    /**
     * @param array $attendees
     */
    public function setAttendees(array $attendees): void {
        $this->attendees = $attendees;
    }
}
