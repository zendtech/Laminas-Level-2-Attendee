<?php
namespace PrivateMessages\Hydrator;

use Exception;
use PrivateMessages\Model\MessageModel;
use PrivateMessages\Traits\BlockCipherTrait;
use Laminas\Hydrator\HydratorInterface;

class PrivateHydrator implements HydratorInterface
{
    use BlockCipherTrait;
    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, object $object)
    {
        if (isset($data['message']) && !empty($data['message'])) {
            try {
                $data['message'] = $this->blockCipher->decrypt($data['message']);
            } catch (Exception $e) {
                error_log(__METHOD__ . ':' . $e->getMessage());
                $data['message'] = '';
            }
        } else {
            $data['message'] = '';
        }
        return new MessageModel($data);
    }
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract(object $object) : array
    {
        $data = $object->extract();
        if (isset($data['message'])) {
            $data['message'] = $this->blockCipher->encrypt($data['message']);
        } else {
            $data['message'] = '';
        }
        return $data;
    }
}
