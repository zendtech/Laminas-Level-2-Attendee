<?php
namespace PrivateMessages\Model;
use Application\Model\AbstractModel;
class MessageModel extends AbstractModel
{
    protected $mapping = ['id' => 'id', 'toEmail' => 'to_email', 'fromEmail' => 'from_email', 'message' => 'message', 'dateTime' => 'date_time'];
}
