<?php
/**
 * FooDelegator
 */
namespace src\modServices\Delegators;
use Foo;
class FooDelegator extends Foo
{
    public function __construct($bar)
    {
        $this->bar = $bar;
        // Do required things
    }
}