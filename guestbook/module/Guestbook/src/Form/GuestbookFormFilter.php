<?php
/**
 * GuestbookFormFilter
 */
namespace Guestbook\Form;
use Laminas\InputFilter\InputFilter;

class GuestbookFormFilter extends InputFilter {

    public function __construct(
        $fileInput,
        $imageSize,
        $filesSize,
        $isImage,
        $renameUpload
    ){
        $fileInput->getValidatorChain()
            ->attach($imageSize)
            ->attach($filesSize)
            ->attach($isImage);

        $fileInput->getFilterChain()
            ->attach($renameUpload);

        $this->add($fileInput);
    }
}