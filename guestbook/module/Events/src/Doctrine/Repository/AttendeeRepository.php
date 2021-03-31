<?php
namespace Events\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Events\Doctrine\Entity\AttendeeEntity;

class AttendeeRepository extends EntityRepository
{

    /**
     * @param Events\Doctrine\Entity\Registration $regEntity
     * @param string $nameOnTicket
     * @return Events\Doctrine\Entity\Attendee
     */
    public function persist($regEntity, $nameOnTicket)
    {
        $attendee = new AttendeeEntity();
        $attendee->setRegistration($regEntity);
        $attendee->setName($nameOnTicket);
        $em = $this->getEntityManager();
        $em->persist($attendee);
        $em->flush();
        return $attendee;
    }
}
