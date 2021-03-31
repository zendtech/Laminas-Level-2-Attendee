<?php
namespace Application\Event\Listener;
use Application\Traits\LogFileTrait;
class ErrorLog
{
    use LogFileTrait;
    public function __construct(string $dir, string $file) {
        $this->setLogFileName($dir, $file);
    }

    public function logMessage($e)
    {
        $whoTriggered = get_class($e->getTarget());
        $optMessage   = $e->getParam('message') ?? 'No MessageModel';
        $fullMessage  = '[' . date('d-M-Y H:i:s') . ']  | ' . $whoTriggered . ' | ' . $optMessage . PHP_EOL;
        file_put_contents($this->logFile, $fullMessage, FILE_APPEND);
    }
}
