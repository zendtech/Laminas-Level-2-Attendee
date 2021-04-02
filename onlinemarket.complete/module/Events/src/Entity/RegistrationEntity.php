<?php
namespace Events\Entity;
use Laminas\Form\Annotation as ABC;
/**
 * @ABC\Name("registration")
 * @ABC\Hydrator("Laminas\Hydrator\ClassMethodsHydrator")
 */
class RegistrationEntity extends BaseEntity
{
	/**
	 * @ABC\Exclude()
     */
    protected $id;

	/**
	 * @ABC\Attributes({"type":"text", "placeholder":"First Name", "class":"input-xlarge"})
     * @ABC\Options({"label":"First Name: "})
     * @ABC\Filter({"name":"StringTrim", "name":"StripTags"})
     */
    protected $first_name;

	/**
	 * @ABC\Attributes({"type":"text", "placeholder":"Last Name", "class":"input-xlarge"})
     * @ABC\Options({"label":"Last Name:"})
     * @ABC\Filter({"name":"StringTrim", "name":"StripTags"}))
     */
    protected $last_name;

	/**
	 * @ABC\Exclude()
     */
    protected $registration_time;

	/**
	 * @ABC\Exclude()
     */
    protected $attendees = [];

    /**
     * @return mixed
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return RegistrationEntity
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
     * @return RegistrationEntity
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
