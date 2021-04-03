<?php
// updates source code from "Zend\" to "Laminas\"
// updates source code from "zend-" to "laminas-"
$iter = new RecursiveDirectoryIterator(__DIR__ . '/src');
$list = new RecursiveIteratorIterator($iter);
$filt = new class ($list) extends FilterIterator {
    public function accept()
    {
        return ($this->current()->getExtension() === 'php');
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
