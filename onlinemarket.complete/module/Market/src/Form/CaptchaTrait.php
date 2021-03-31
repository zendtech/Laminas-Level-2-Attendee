<?php
namespace Market\Form;

trait CaptchaTrait
{
    protected $captchaOptions;

    /**
     * @return  $captchaOptions
     */
    public function getCaptchaOptions() {
        return $this->captchaOptions;
    }

    /**
     * @param array $captchaOptions
     */
    public function setCaptchaOptions(array $captchaOptions) {
        $this->captchaOptions = $captchaOptions;
    }
}
