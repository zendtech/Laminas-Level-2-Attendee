<?php
namespace PrivateMessages\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Debug\Debug;
use Zend\Hydrator\HydratorInterface;

class MessagesModel
{
    public static $tableName = 'messages';
    protected $hydrator, $tableGateway;
    public function __construct(
        HydratorInterface $hydrator,
        TableGateway $tableGateway
    )
    {
        $this->hydrator = $hydrator;
        $this->tableGateway = $tableGateway;
    }
    public function findMessagesSent($email)
    {
        return $this->tableGateway->select(['from_email' => $email]);
    }
    public function findMessagesReceived($email)
    {
        return $this->tableGateway->select(['to_email' => $email]);
    }
    public function save(MessageEntity $message)
    {
        $message->setDateTime(date('Y-m-d H:i:s'));
        $data = $this->hydrator->extract($message);
        Debug::dump($data, __METHOD__);
        return $this->tableGateway->insert($data);
    }
}
