<?php
namespace Events\Model;
use Events\Entity\RegistrationEntity;
use Laminas\Db\Sql\{Sql,Where};

// Model Structure:
/*
CREATE TABLE `registration` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `registration_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8
 */

class RegistrationTableModel extends BaseTableModel
{
    public const TABLE_NAME = 'registration';
    public function findAllForEvent($eventId)
    {
        return $this->findUsingTwoQueries($eventId);
    }

    public function findRegistrationByEventId($eventId)
    {
        return $this->tableGateway->select(['event_id' => $eventId]);
    }

    protected function findUsingTwoQueries($eventId)
    {
        $final = [];
        $redIds = [];
        $registrations = $this->findRegistrationByEventId($eventId);
        $attendeeTable = $this->container->get(AttendeeTableModel::class);
        foreach ($registrations as $reg) {
            $reg->attendees = iterator_to_array($attendeeTable->findByRegistrationId($reg->getId()));
            $final[$reg->getId()] = $reg;
        }
        return $final;
    }

    public function save(RegistrationEntity $registrationEntity)
    {
        $registrationEntity->setRegistrationTime(date('Y-m-d H:i:s'));
        $hydrator = $this->tableGateway->getResultSetPrototype()->getHydrator();
        $data = $hydrator->extract($registrationEntity);
        // need to get rid of this property as it's not a column in the "registration" usersModelTableGateway
        unset($data['attendees']);
        $this->tableGateway->insert($data);
        return $this->tableGateway->getLastInsertValue();
    }
}
