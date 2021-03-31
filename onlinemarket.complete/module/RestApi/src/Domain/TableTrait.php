<?php
namespace RestApi\Domain;

use Model\Model\ListingsModel;

trait TableTrait
{
    protected $table;
    public function getTable()
    {
        return $this->table;
    }
    public function setTable(ListingsModel $table)
    {
        $this->table = $table;
    }
}
