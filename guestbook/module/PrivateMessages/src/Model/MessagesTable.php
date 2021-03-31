<?php
namespace PrivateMessages\Model;
use PrivateMessages\Hydrator\PrivateHydrator;
use Application\Model\ {AbstractModel, AbstractTable};
use Zend\Db\TableGateway\TableGatewayInterface;

class MessagesTable extends AbstractTable
{
    public static $tableName = 'guest_messages';
    protected $hydrator, $tableGateway;
    public function __construct(
        TableGatewayInterface $tableGateway,
        PrivateHydrator $hydrator
    ) {
       $this->tableGateway = $tableGateway;
       $this->hydrator = $hydrator;
    }

    public function findMessagesSent($email)
    {
        return $this->tableGateway->select(['from_email' => $email]);
    }
    public function findMessagesReceived($email)
    {
        return $this->tableGateway->select(['to_email' => $email]);
    }
    public function save(AbstractModel $message)
    {
        $data = $this->hydrator->extract($message);
        return $this->tableGateway->insert($data);
    }
}
