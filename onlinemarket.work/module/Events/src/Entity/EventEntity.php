<?php
declare(strict_types=1);
namespace Events\Entity;

class EventEntity extends BaseEntity
{
    protected $name, $max_attendees, $date;
    public function getName()
    {
        return $this->name;
    }
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }
    public function getMaxAttendees()
    {
        return $this->max_attendees;
    }
    public function setMaxAttendees(int $num)
    {
        $this->max_attendees = $num;
        return $this;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function setDate(string $date)
    {
        $this->date = $date;
        return $this;
    }
}
