<?php
namespace AccessControl\Assertion;

use DateTime, DateTimeZone;
use Laminas\Permissions\Acl\{
    Acl,
    Role\RoleInterface,
    Resource\ResourceInterface,
    Assertion\AssertionInterface
};

class DateTimeAssert implements AssertionInterface
{
    public const DT_FORMAT = 'Y-m-d H:i:s';
    protected $startTime;
    protected $stopTime;
    public function __construct(DateTime $start, DateTime $stop)
    {
        $this->startTime = $start->format(self::DT_FORMAT);
        $this->stopTime = $stop->format(self::DT_FORMAT);
    }

    public function assert(Acl $acl,
                           RoleInterface $role = null,
                           ResourceInterface $resource = null,
                           $privilege = null)
    {
        $now = (new DateTime('now', new DateTimeZone('UTC')))->format(self::DT_FORMAT);
        return (($this->startTime <= $now) && ($now <= $this->stopTime));
    }
}
