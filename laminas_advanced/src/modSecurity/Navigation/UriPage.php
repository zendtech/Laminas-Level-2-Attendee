<?php
/**
 * Page
 */
namespace src\modSecurity\Navigation;
use Laminas\Navigation\Page\AbstractPage;
class UriPage extends AbstractPage
{
    public function getHref()
    {
        return 'some location';
    }
}
