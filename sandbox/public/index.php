<?php

class PolicyEntity {
    protected $id, $type;
    public function __construct($id, $type){
        $this->id= $id;
        $this->type = $type;
es
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void {
        $this->id = $id;
    }
}

$lib1 = new PolicyEntity(1, 'liability');
$cat1 = new PolicyEntity(2, 'cat');

echo 'This is a liability policy of type ' . $lib1->getType();

