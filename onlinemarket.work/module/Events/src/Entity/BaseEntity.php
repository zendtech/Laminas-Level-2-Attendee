<?php
namespace Events\Entity;

class BaseEntity
{
    const DATE_FORMAT = 'Y-m-d H:i:s';
    public $id;

    public function getArrayCopy():array{
        return get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }
}
