<?php
/**
 * DateTimeAssertion
 */
namespace src\modSecurity\Acl;
use DateTime;
use DateTimeInterface;
use Throwable;
use Zend\Permissions\Acl\ {
    AclInterface,
    Assertion\AssertionInterface,
    Resource\ResourceInterface,
    Role\RoleInterface
};
class DateTimeAssertion implements AssertionInterface
{
    protected $startTime, $stopTime;
    public function __construct(DateTimeInterface $start, DateTimeInterface $stop) {
        $this->startTime = $start;
        $this->stopTime = $stop;
    }

    public function assert(AclInterface $acl, RoleInterface $role = null, ResourceInterface $resource = null,
       $privilege = null) {
        try {
            $now = new DateTime('now');
        } catch (Throwable $e) {
            // Handle
        }
        return (($this->startTime >= $now) && ($now <= $this->stopTime));
    }
}