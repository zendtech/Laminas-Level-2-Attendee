<?php
namespace RestApi\Service;
use Events\TableModule\Model\ {EventModel, RegistrationModel, AttendeeModel};
class ApiService
{

    const STATUS_OK     = 'SUCCESS: OK';
    const STATUS_NOT_OK = 'ERROR: Not OK';

    protected $identifiers = [
        'id'               => 'id',
        'name'             => 'name',
        'max_attendees'    => 'max_attendees',
        'date'             =>'date',
        'event_id'         =>'event_id',
        'first_name'       =>'first_name',
        'last_name'        =>'last_name',
        'registration_time'=>'registration_time',
        'registration_id'  =>'registration_id',
        'name_on_ticket'   =>'name_on_ticket',
    ];
    protected $attendeeModel, $eventModel, $regModel, $sql, $where;
    public function __construct(
        $eventModel,
        $regModel,
        $attendeeModel,
        $sql,
        $where
    ) {
        $this->eventModel = $eventModel;
        $this->attendeeModel = $attendeeModel;
        $this->regModel = $regModel;
        $this->sql = $sql;
        $this->where = $where;
    }

    protected function getSelect()
    {
        $select = $this->sql->getSelect();
        $select->from(['e' => EventModel::$tableName])
               ->join(['r' => RegistrationModel::$tableName], 'e.id = r.event_id')
               ->join(['a' => AttendeeModel::$tableName], 'r.id = a.registration_id');
        return $select;
    }

    public function find($id = NULL)
    {
        $select = $this->getSelect();
        if ($id) {
            $this->where->equalTo('e.id', $id);
            $select->where($this->where);
        }
        return $this->eventModel->getTableGateway()->selectWith($select)->toArray();
    }

    public function search(array $params)
    {
        $condition = 0;
        $select = $this->getSelect();
        foreach ($params as $key => $value) {
            if (isset($this->identifiers[$key])) {
                $this->where->like($key, '%' . $value . '%');
                $condition++;
            }
        }
        if ($condition) $select->where($this->where);
        return $this->eventModel->getTableGateway()->selectWith($select)->toArray();
    }

    public function add($data)
    {
        try {
            $this->eventModel->getTableGateway()->insert($data);
            $result = $this->eventModel->getTableGateway()->getLastInsertId();
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }

    public function save($id, $data)
    {
        try {
            $result = $this->eventModel->getTableGateway()->update(['id' => $id], $data);
        } catch (Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }
}
