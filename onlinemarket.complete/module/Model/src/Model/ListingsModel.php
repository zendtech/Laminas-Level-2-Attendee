<?php
namespace Model\Model;
use Model\Entity\ListingEntity;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\TableGateway;

class ListingsModel extends TableGateway
{
    public const TABLE_NAME = 'listings';
    public function findByCategory($category)
    {
        return $this->select(['category' => $category]);
    }
    public function findById($id)
    {
        return $this->select(['listings_id' => $id])->current();
    }
    public function findLatest()
    {
        $select = (new Sql($this->getAdapter()))->select();
        $select->from(self::TABLE_NAME)
               ->order('listings_id desc')
               ->limit(1);
        return $this->selectWith($select)->current();
    }
    public function save(ListingEntity $listing)
    {
         $data = $this->getResultSetPrototype()->getHydrator()->extract($listing);
        return $this->insert($data);
    }
}
