<?php
namespace Model\Hydrator;

use DateTime;
use DateInterval;
use Model\Entity\ListingEntity;
use Throwable;
use Zend\Hydrator\HydratorInterface;

class ListingsHydrator implements HydratorInterface
{
    protected $fieldsToUnset = ['expires','submit','cityCode','captcha','csrf','hash'];
    public function hydrate($data, $listing)
    {
        if ($listing instanceof ListingEntity) {
            // populate from $data 
            try {
                $today = new DateTime();
            } catch (Throwable $e) {
                // Handle ...
            }
            $vars  = get_object_vars($listing);
            foreach ($vars as $name => $value)
                if (isset($data[$name])) 
                    $listing->$name = $data[$name];
            if (!isset($listing->date_created)) {
                // calculate current date
                $listing->date_created = $today->format(ListingEntity::DATE_FORMAT);
            }
            // calculate expires date
            if (isset($data['expires'])) {
                $listing->date_expires = $this->calcDateExpires($listing->date_created, $data['expires']);
            }
            if (empty($listing->date_expires)) {
                $listing->date_expires = 'Never';
            }
            // break out city and country from cityCode
            if (isset($data['cityCode'])) {
                [$listing->city, $listing->country] = explode(',', $data['cityCode']);
            }
            // unset unwanted fields
            foreach ($this->fieldsToUnset as $field) {
                unset($listing->$field);
            }
        }
        return $listing;
    }

    public function extract(object $object) : array
    {
        $data = get_object_vars($object);
        // convert date fields into DateTime instances
        if (empty($object->date_created))
            $data['date_created'] = date('Y-m-d H:i:s');
        if (isset($object->expires) && ((int) $object->expires) < 100)
            $data['date_expires'] = $this->calcDateExpires($data['date_created'], (int) $object->expires);
        if (isset($data['cityCode'])) {
            [$data['city'], $data['country']] = explode(',', $data['cityCode']);
            unset($data['cityCode']);
        }
        // unset unwanted fields
        foreach ($this->fieldsToUnset as $field) {
            if (isset($data[$field])) unset($data[$field]);
        }
        return $data;
    }
    
    protected function calcDateExpires($dateCreated, $expNum)
    {
        $expDateStr = NULL;
        try {
            $expDateObj = new DateTime($dateCreated);
        } catch (Throwable $e) {
            // Handle ...
        }
        switch ($expNum) {
            case 1 :
                $interval = 'P1D';
                break;
            case 7 :
                $interval = 'P1W';
                break;
            case 30 :
                $interval = 'P1M';
                break;
            default :
                $interval = FALSE;
        }
        if ($interval) {
            try {
                $expDateObj->add(new DateInterval($interval));
            } catch (Throwable $e) {
                // Handle ...
            }
            $expDateStr = $expDateObj->format(ListingEntity::DATE_FORMAT);
        } else {
            $expDateStr = NULL;
        }
        return $expDateStr;
    }
    
}

// result of form posting:
/*
Market\Controller\PostController::indexAction object(Model\Entity\Listing)#1762 (19) {
  ["listings_id"] => NULL
  ["category"] => string(4) "free"
  ["title"] => string(11) "Pom Puppies"
  ["date_created"] => NULL
  ["date_expires"] => NULL
  ["description"] => string(29) "8 Furballs for free.  HELP!!!"
  ["photo_filename"] => array(5) {
    ["name"] => string(25) "suchi_milo_front_step.png"
    ["type"] => string(9) "image/png"
    ["tmp_name"] => string(129) "/home/fred/Desktop/Repos/ZF-Level-3/Course_Applications/onlinemarket.complete/public/images/phpzLttfU_5b064197e2dd32_76518590.png"
    ["error"] => int(0)
    ["size"] => int(763056)
  }
  ["contact_name"] => string(16) "Lots A. Furballs"
  ["contact_email"] => string(21) "too@many.furballs.com"
  ["contact_phone"] => string(12) "111-111-1111"
  ["city"] => NULL
  ["country"] => NULL
  ["price"] => string(5) "99.99"
  ["delete_code"] => string(5) "12345"
  ["expires"] => string(1) "7"
  ["cityCode"] => string(8) "Surin,TH"
  ["captcha"] => array(2) {
    ["id"] => string(32) "231693cce4ea3e064e47e734077c95a4"
    ["input"] => string(4) "z52a"
  }
  ["submit"] => string(4) "Post"
  ["csrf"] => string(65) "0224f507bb2d4f661d02d530c09c7f43-b830c36cbd8aafbda03b3a0a39ab3fa9"
}
*/
