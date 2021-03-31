<?php
namespace Application\Event\Listener;
use Application\Event\Filter\MaskCcnum;
class ErrorLogWithFilter extends ErrorLog
{
    use FilterTrait;
    public function __construct(string $dir, string $file, MaskCcnum $filter) {
        parent::__construct($dir, $file);
        $this->attachFilter($filter, 'filter');
    }
}
