<?php
namespace Market\Form;
trait ExpireDaysTrait
{
    protected $expireDays;

    /**
     * @return  $expireDays
     */
    public function getExpireDays() {
            return $this->expireDays;
    }
    /**
     * @param array $expireDays;
     */
    public function setExpireDays($expireDays) {
            $this->expireDays = $expireDays;
    }
}
