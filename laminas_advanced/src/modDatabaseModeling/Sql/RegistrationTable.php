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
    public function findAllForEvent($id) {
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from(['r' => static::REGISTRATION_TABLE])->join(['a' => static::ATTENDEE_TABLE],
                'a.id = r.id')->where(['r.event_id' => $id]);
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();
        return $result->current();
    }
}
