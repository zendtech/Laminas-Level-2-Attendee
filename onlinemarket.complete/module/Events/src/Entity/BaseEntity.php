<?php
namespace Events\Entity;

abstract class BaseEntity implements EntityInterface
{
    const DATE_FORMAT = 'Y-m-d H:i:s';
    public $id;

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
}
