<?php
namespace Events\TableModule\Model;
use Laminas\Db\Sql\Sql;
class RegistrationModel extends BaseModel
{
    public static $tableName = 'registration';
    // produces this SQL statement:
    // SELECT `r`.*, `a`.* FROM `registration` AS `r`
    // INNER JOIN `attendee` AS `a`
    // ON `a`.`registration_id` = `r`.`id` WHERE `r`.`event_id` = '{$eventId}'
    public function findAllForEvent($eventId)
    {
        $adapter = $this->tableGateway->getAdapter();
        $sql     = new Sql($adapter);
        $select  = $sql->select();
        $select->from(['r' => self::$tableName])
               ->join(['a' => AttendeeModel::$tableName],
                       'a.registration_id = r.id')
               ->where(['r.event_id' => $eventId]);
        // log SQL statement
        error_log(__METHOD__ . ' : ' . $sql->buildSqlString($select));
        $result = $adapter->query($sql->buildSqlString($select))->execute();
        return iterator_to_array($result);
    }
    public function persist($eventId, $firstName, $lastName)
    {
        $this->tableGateway->insert(
            ['event_id' => $eventId,
             'first_name' => $firstName,
             'last_name' => $lastName,
             'registration_time' => date('Y-m-d H:i:s')
             ]
        );
        return $this->tableGateway->getLastInsertValue();
    }
}
