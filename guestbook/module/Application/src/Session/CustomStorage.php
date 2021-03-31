<?php
namespace Application\Session;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\StdLib\ArrayObject;
use Zend\Db\Adapter\Adapter;
use Zend\Session\Storage\ArrayStorage;

class CustomStorage extends ArrayStorage
{
    const TABLE_NAME = 'session_storage';
    protected $table, $adapter;
    public function __construct(
        AdapterInterface $adapter,
        array $input,
        int $flags,
        string $iteratorClass,
        TableGatewayInterface $tableGateway
    )
    {
        parent::__construct($input, $flags, $iteratorClass);
        $this->adapter = $adapter;
        $this->table = $tableGateway;
        $this->setRequestAccessTime(microtime(true));
        foreach (iterator_to_array($this->table->select()) as $obj) {
            parent::offsetSet($obj->key, unserialize($obj->value));
        }
    }

    /**
     * Destructor
     * 
     * Wipes out self::TABLE_NAME and re-inserts key/value pairs serialized
     *
     * @return void
     */
    public function __destruct()
    {
        $this->adapter->query('DELETE FROM ' . self::TABLE_NAME, Adapter::QUERY_MODE_EXECUTE);
        if ($this->count()) {
            foreach ($this as $key => $value) {
                if (!$value instanceof ArrayObject) {
                    if (is_array($value)) {
                        $value = new ArrayObject($value);
                    } else {
                        $value = new ArrayObject([$key => $value]);
                    }
                }
                $this->table->insert(['key' => $key, 'value' => serialize($value)]);
            }
        }
    }
}
