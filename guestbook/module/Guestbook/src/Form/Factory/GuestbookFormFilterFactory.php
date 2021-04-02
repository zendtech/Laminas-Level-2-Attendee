<?php
/**
 * GuestbookFormFilterFactory
 */

namespace Guestbook\Form\Factory;
use Guestbook\Form\GuestbookFormFilter;
use Interop\Container\ContainerInterface;
use Laminas\Filter\File\RenameUpload;
use Laminas\InputFilter\FileInput;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Validator\File\{FilesSize, ImageSize, IsImage};

class GuestbookFormFilterFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {
        $avatarConfig = $container->get('guestbook-avatar-config');
        return new GuestbookFormFilter(
            new FileInput('avatar'),
            new ImageSize($avatarConfig['img_size']),
            new FilesSize($avatarConfig['file_size']),
            new IsImage(),
            new RenameUpload($avatarConfig['rename'])
        );
    }
}