<?php
namespace Events\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Events\Doctrine\Entity\RegistrationEntity;
use Events\Doctrine\Entity\EventEntity;

class RegistrationRepository extends EntityRepository
{

    /**
     * @param Events\Doctrine\Entity\Event $eventEntity
     * @param array $regData
     * @return Events\Doctrine\Entity\Registration $registration
     */
    public function persist(EventEntity $eventEntity, $regData)
    {
        $registration = new RegistrationEntity();
        $registration->setFirstName($regData['firstName']);
        $registration->setLastName($regData['lastName']);
        $registration->setRegistrationTime(new \DateTime('now'));
        $registration->setEvent($eventEntity);
        return $this->update($registration);
    }
    public function update($registration)
    {
        $em = $this->getEntityManager();
        $em->persist($registration);
        $em->flush();
        return $registration;
    }
}
