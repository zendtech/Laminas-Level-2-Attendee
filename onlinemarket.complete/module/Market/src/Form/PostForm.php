<?php
namespace Market\Form;

use Model\Entity\ListingEntity;
use Zend\Form\{
    Form,
    Element\Text,
    Element\Select,
    Element\Email,
    Element\Textarea,
    Element\Submit,
    Element\Radio,
    Element\Captcha,
    Element\Csrf,
    Element\File
};
use Zend\Captcha\Image as ImageCaptcha;
use Zend\Hydrator\HydratorInterface;
use Zend\InputFilter\InputFilterInterface;

class PostForm extends Form
{
    use CategoryTrait;
    use ExpireDaysTrait;
	use CaptchaTrait;

	public function __construct(
	    $formName,
        $options = null,
        array $marketExpireDays,
        array $categories,
        array $captchaOptions,
        InputFilterInterface $inputFilter,
        HydratorInterface $hydrator,
        ListingEntity $listingEntity
    )
    {
	    parent::__construct($formName, $options);
	    $this->expireDays = $marketExpireDays;
	    $this->setCategories($categories);
	    $this->setCaptchaOptions($captchaOptions);
	    $this->setInputFilter($inputFilter);
	    $this->setHydrator($hydrator);
	    $this->bind($listingEntity);

        $this->setAttribute('method', 'post');

        $category = new Select('category');
        $category->setLabel('Category')
            ->setAttribute('title', 'Please select a category')
            ->setValueOptions(array_combine($this->getCategories(), $this->getCategories()))
            ->setLabelAttributes(['style' => 'display: block']);

        $title = new Text('title');
        $title->setLabel('Title')
            ->setAttribute('placeholder', 'Enter posting title')
            ->setLabelAttributes(['style'=>'display:block']);

        //*** FILE UPLOAD LAB: convert this to a file upload form element
        $photo = new File('photo_filename');
        $photo->setLabel('Photo')
            ->setAttribute('placeholder', 'Upload image')
            ->setLabelAttributes(['style'=>'display:block']);


        $price = new Text('price');
        $price->setLabel('Price')
            ->setAttribute('title', 'Enter price as nnn.nn')
            ->setAttribute('size', 16)
            ->setAttribute('maxlength', 16)
            ->setAttribute('placeholder', 'Enter a value')
            ->setLabelAttributes(['style'=>'display:block']);

        $expires = new Radio('expires');
        $expires->setLabel('Expires')
            ->setAttribute('title', 'The expiration date will be calculated from today')
            ->setAttribute('class', 'expiresButton')
            ->setValueOptions($this->getExpireDays());

        $city = new Text('cityCode');
        $city->setLabel('Nearest City,Country')
            ->setAttribute('title', 'Enter as "city,country" using 2 letter ISO code for country')
            ->setAttribute('id', 'cityCode')
            ->setAttribute('placeholder', 'City Name,CC')
            ->setLabelAttributes(['style'=>'display:inline']);

        $name = new Text('contact_name');
        $name->setLabel('Contact Name')
            ->setAttribute('title', 'Enter the name of the person to contact for this item')
            ->setAttribute('size', 40)
            ->setAttribute('maxlength', 255)
            ->setLabelAttributes(['style'=>'display:block']);

        $phone = new Text('contact_phone');
        $phone->setLabel('Contact Phone Number')
            ->setAttribute('title', 'Enter the phone number of the person to contact for this item')
            ->setAttribute('size', 20)
            ->setAttribute('maxlength', 32)
            ->setLabelAttributes(['style'=>'display:block']);

        $email = new Email('contact_email');
        $email->setLabel('Contact Email')
            ->setAttribute('title', 'Enter the email address of the person to contact for this item')
            ->setAttribute('size', 40)
            ->setAttribute('maxlength', 255)
            ->setLabelAttributes(['style'=>'display:block']);

        $description = new Textarea('description');
        $description->setLabel('Description')
            ->setAttribute('title', 'Enter a suitable description for this posting')
            ->setAttribute('rows', 4)
            ->setAttribute('cols', 80);

        $delCode = new Text('delete_code');
        $delCode->setLabel('Delete Code')
            ->setAttribute('title', 'Enter the delete code for this item')
            ->setAttribute('size', 16)
            ->setAttribute('maxlength', 16);

        $captcha = new Captcha('captcha');
        $captchaAdapter = new ImageCaptcha();
        $captchaAdapter->setWordlen(4)
            ->setOptions($this->getCaptchaOptions());
        $captcha->setCaptcha($captchaAdapter)
            ->setLabel('Help us to prevent SPAM!')
            ->setAttribute('title', 'Help to prevent SPAM');
	
//		$hash = new Csrf('hash');

        $submit = new Submit('submit');
        $submit->setAttribute('value', 'Post')
               ->setAttribute('style', 'font-size: 16pt; font-weight:bold;')
               ->setAttribute('class', 'btn btn-success white');

        $this->add($category)
            ->add($title)
            ->add($photo)
            ->add($price)
            ->add($expires)
            ->add($city)
            ->add($name)
            ->add($phone)
            ->add($email)
            ->add($description)
            ->add($delCode)
            ->add($captcha)
//            ->add($hash)
            ->add($submit);
    }
}
