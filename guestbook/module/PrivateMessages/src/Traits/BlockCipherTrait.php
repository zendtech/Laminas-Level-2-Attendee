<?php
namespace PrivateMessages\Traits;

trait BlockCipherTrait
{
    protected $blockCipher;
    public function setBlockCipher($blockCipher)
    {
        $this->blockCipher = $blockCipher;
    }
}
