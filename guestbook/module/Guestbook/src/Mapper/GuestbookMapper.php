<?php
namespace Guestbook\Mapper;

use Guestbook\Model\GuestbookModel;
use Zend\Db\Sql\{Sql, Expression};
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\EventManager\EventManagerInterface;

class GuestbookMapper
{
    const TABLE_NAME   = 'guestbook';
    const IDENTIFIER   = 'guestbook-mapper';
    const ADD_EVENT_PRE    = 'guestbook-mapper-add-event-pre';
    const ADD_EVENT_POST    = 'guestbook-mapper-add-event-post';

    protected $tableGateway, $adapter, $eventManager;

    public function __construct(AdapterInterface $adapter, EventManagerInterface $eventManager, TableGatewayInterface $tableGateway)
    {
        $this->adapter = $adapter;
        $this->eventManager = $eventManager;
        $this->tableGateway = $tableGateway;
    }
    public function findAll()
    {
        return $this->tableGateway->select();
    }
    public function getCount()
    {
        $sql = new Sql($this->tableGateway->getAdapter());
        $select = $sql
            ->select()->from(self::TABLE_NAME)
            ->columns([
                'val' => new Expression('COUNT(id)')
            ]);
        return $this->tableGateway->selectWith($select);
    }
    public function add(GuestbookModel $model)
    {
        $hydrator = $this->tableGateway->getResultSetPrototype()->getHydrator();
		$data = $hydrator->extract($model);
        unset($data['submit']);
        $data['dateSigned'] = date('Y-m-d H:i:s');
        $this->eventManager->trigger(self::ADD_EVENT_PRE, $this, ['model' => $model]);
        $result = $this->tableGateway->insert($data);
        $this->eventManager->trigger(self::ADD_EVENT_POST, $this, ['model' => $model]);
        return $result;
    }
    public function getEventManager()
    {
        return $this->eventManager;
    }
}
