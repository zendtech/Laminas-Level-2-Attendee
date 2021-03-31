<?php
namespace Market\Form;

trait UploadTrait
{
    protected $uploadConfig;

    /**
     * @return  $uploadConfig
     */
    public function getUploadConfig() {
        return $this->uploadConfig;
    }

    /**
     * @param  $uploadConfig
     */
    public function setUploadConfig($uploadConfig) {
        $this->uploadConfig = $uploadConfig;
    }
}
