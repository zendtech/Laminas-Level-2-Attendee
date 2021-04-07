<?php
/**
 * RegistrationTable
 */
namespace src\modDatabaseModeling\Sql;
use Laminas\Db\{Sql\Sql, Adapter\Adapter};

class RegistrationTable {
    public const REGISTRATION_TABLE = 'registration';
    public const ATTENDEE_TABLE = 'attendee';
    protected $adapter;
    public function __construct(Adapter $adapter){
        $this->adapter = $adapter;
    }
    /*
    SELECT `r`.*, `a`.* FROM `registration` AS `r`
    INNER JOIN `attendee` AS `a`
    ON `a`.`id` = `r`.`id` WHERE `r`.`event_id` = '{$eventId}'
    */
    public function findAllForEvent($id) {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from(['r' => static::REGISTRATION_TABLE])
               ->join(['a' => static::ATTENDEE_TABLE], 'a.registration_id = r.id')
               ->where(['r.event_id' => $id]);
        $selectString = $sql->buildSqlString($select);
        return $this->adapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
    }
}
