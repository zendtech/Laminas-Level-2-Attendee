<?php
namespace Events\Model;
use Events\Entity\RegistrationEntity;
use Zend\Db\Sql\{Sql,Where};

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

class RegistrationTableModel extends BaseEventsTableModel
{
    public static $tableName = 'registration';
    public function findAllForEvent($eventId)
    {
        return $this->findUsingTwoQueries($eventId);
    }
    public function findRegistrationByEventId($eventId)
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql->select();
        $select->from(['r' => self::$tableName])->where(['r.event_id' => $eventId])->order('r.registration_time DESC');
        return $this->tableGateway->selectWith($select);
    }
    protected function findUsingTwoQueries($eventId)
    {
        $final = [];
        $redIds = [];
        $registrations = $this->findRegistrationByEventId($eventId);
        foreach ($registrations as $reg) {
            // the iteration $registrations is "forward-only" which means we need to store it into an array
            $final[$reg->id] = $reg;
        }
        // use Zend\Db\Sql\Sql to pull attendees for list of registrations in registration_id order 
        $attendeeTable = $this->container->get(AttendeeTableModel::class);
        $adapter = $this->tableGateway->getAdapter();
        $sql = new Sql($adapter);
        $where = (new Where())->in('registration_id', array_keys($final));
        $select = $sql->select();
        $select->from(AttendeeTableModel::$tableName)
               ->order('registration_id ASC')
               ->where($where);
        $attendees = $attendeeTable->tableGateway->selectWith($select);
        // match registrations against attendees
        foreach ($attendees as $attendee) {
			$final[$attendee->registration_id]->attendees[] = $attendee;
		}
        return $final;
    }
    public function save(RegistrationEntity $registrationEntity)
    {
		$registrationEntity->registration_time = date('Y-m-d H:i:s');
        $hydrator = $this->tableGateway->getResultSetPrototype()->getHydrator();
        $data = $hydrator->extract($registrationEntity);
        // need to get rid of this property as it's not a column in the "registration" usersModelTableGateway
        unset($data['attendees']);
        $this->tableGateway->insert($data);
        return $this->tableGateway->getLastInsertValue();
    }
}
