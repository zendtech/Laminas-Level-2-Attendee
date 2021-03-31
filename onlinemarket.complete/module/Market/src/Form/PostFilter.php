<?php
namespace Market\Form;
use Zend\InputFilter\ {InputFilter,Input};
use Zend\Filter\{Digits, StripTags, StringTrim, Callback};
use Zend\Validator\{Regex, Callback as CallValid};

//*** FILE UPLOAD LAB: add appropriate "use" statements
use Zend\InputFilter\FileInput;
use Zend\Filter\File\RenameUpload;
use Zend\Validator\File\ {FilesSize, IsImage, ImageSize};

class PostFilter extends InputFilter
{
    use CategoryTrait;
    use ExpireDaysTrait;
    use UploadTrait;

    public function __construct(
        array $expireDays,
        array $categories,
        array $uploadConfig
    )
    {
        $this->setExpireDays($expireDays);
        $this->setCategories($categories);
        $this->setUploadConfig($uploadConfig);

        // filter & validate by fields
        $category = new Input('category');
        $category->getFilterChain()
                 ->attachByName('StringToLower');
        $category->getValidatorChain()
                 ->attachByName('InArray', array('haystack' => $this->getCategories()));

        $title = new Input('title');
        $titleRegex = new Regex(array('pattern' => '/^[a-zA-Z0-9 ]*$/'));
        $titleRegex->setMessage('Title should only contain numbers, letters or spaces!');
        $title->getValidatorChain()
              ->attach($titleRegex)
              ->attachByName('StringLength', array('min' => 1, 'max' => 128));

        //*** FILE UPLOAD LAB: convert filters/validators from text to file upload
        $photo = new FileInput('photo_filename');
        $maxImgSize = new ImageSize($this->uploadConfig['img_size']);
        $maxFileSize = new FilesSize($this->uploadConfig['file_size']);
        $isImage = new IsImage();
        $photo->getValidatorChain()
                    ->attach($maxImgSize)
                    ->attach($maxFileSize)
                    ->attach($isImage);

        //*** FILE UPLOAD LAB: NOTE: the "target" will need to have the category appended after form has been submitted
        $rename = new RenameUpload($this->uploadConfig['rename']);
        $photo->getFilterChain()->attach($rename);


        $float = new Callback(function ($val) { return (float) $val; });
        $price = new Input('price');
        $price->setAllowEmpty(TRUE);
        $price->getValidatorChain()
              ->attachByName('GreaterThan', array('min' => 0.00));
        $price->getFilterChain()
              ->attach($float);

        $expires = new Input('expires');
        $expires->setAllowEmpty(TRUE);
        $expires->getValidatorChain()
                ->attachByName('InArray', array('haystack' => array_keys($this->getExpireDays())));
        $expires->getFilterChain()
                ->attach(new Digits());

        // validates "city" field
        $cityCheck = new CallValid(function ($val) {
            [$city, $country] = explode(',', $val);
            if ($city === NULL || $country === NULL) return FALSE;
            if (strlen($country) != 2) return FALSE;
            if ($country !== strtoupper($country)) return FALSE;
            return TRUE;
        });
        $cityCheck->setMessage('What you entered did take this form: NNNN,CC where NNNN = the city name, and CC = 2 digit ISO country code');
        $cityCode = new Input('cityCode');
        $cityCode->getValidatorChain()
                 ->attach($cityCheck);

        $name = new Input('contact_name');
        $name->setAllowEmpty(TRUE);
        $name->getValidatorChain()
              ->attachByName('Regex', array('pattern' => '/^[a-z0-9., -]{1,255}$/i'));
        $name->setErrorMessage('Name should only contain letters, numbers, and some punctuation.');

        $phone = new Input('contact_phone');
        $phone->setAllowEmpty(TRUE);
        $phone->getValidatorChain()
              ->attachByName('Regex', array('pattern' => '/^\+?\d{1,4}(-\d{3,4})+$/'));
        $phone->setErrorMessage('Phone number must be in this format: +nnnn-nnn-nnn-nnnn');

        $email = new Input('contact_email');
        $email->setAllowEmpty(TRUE);
        $email->getValidatorChain()
              ->attachByName('EmailAddress');

        $description = new Input('description');
        $description->setAllowEmpty(TRUE);
        $description->getValidatorChain()
                    ->attachByName('StringLength', array('min' => 1, 'max' => 4096));

        $delCode = new Input('delete_code');
        $delCode->setRequired(TRUE);
        $delCode->getValidatorChain()
                ->addByName('Digits');

        $this->add($category)
             ->add($title)
             ->add($photo)
             ->add($price)
             ->add($expires)
             ->add($cityCode)
             ->add($name)
             ->add($phone)
             ->add($email)
             ->add($description)
             ->add($delCode);

        // add StripTags + StringTrim to all
        $stripTags = new StripTags();
        $stringTrim = new StringTrim();
        foreach ($this->getInputs() as $input) {
            $input->getFilterChain()
                  ->attach($stripTags)
                  ->attach($stringTrim);
        }
    }
}
