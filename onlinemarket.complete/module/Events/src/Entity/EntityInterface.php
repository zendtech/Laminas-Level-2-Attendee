<?php
/**
 * EntityInterface
 */
namespace Events\Entity;
interface EntityInterface {
    public function getId();
    public function setId(int $id);
}