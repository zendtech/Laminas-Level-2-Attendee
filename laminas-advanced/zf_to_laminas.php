<?php
// updates source code from "Zend\" to "Laminas\"
// updates source code from "zend-" to "laminas-"
$iter = new RecursiveDirectoryIterator('/home/ned/Repos/zend/Laminas-Level-2-Instructor/Course_Materials');
$list = new RecursiveIteratorIterator($iter);
$filt = new class ($list) extends FilterIterator {
    public function accept()
    {
        return (strpos($this->current()->getBasename(), 'module') === 0);
    }
};
$rep  = [['Zend\\','zend-'], ['Laminas\\', 'laminas-']];
foreach ($filt as $fn => $obj) {
    if ($obj->isFile()) {
        echo "Processing $fn\n";
        $body = file_get_contents($fn);
        $body = str_replace($rep[0], $rep[1], $body);
        file_put_contents($fn, $body);
    }
}
