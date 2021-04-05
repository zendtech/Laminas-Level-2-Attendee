<?php
/**
 * AdapterAbstractFactory
 */
namespace src\modServices\AbstractFactory;
use Exception, Throwable;
use Interop\Container\ContainerInterface;
class AdapterAbstractFactory
{
    public const ERROR_NO_CONFIG = 'No adapter configuration available';
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return fnmatch('auth-oauth-adapter-*', $requestedName);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // splits by either "-" or "\"
        $breakdown = preg_split('!-|\\\!', $requestedName);
        $provider  = array_pop($breakdown);
        $className = 'AuthOauth\\Adapter\\' . ucfirst($provider) . 'Adapter';
        $config    = $container->get('auth-oauth-config');
        try{
            if (!isset($config[$provider])) {
                throw new Exception(self::ERROR_NO_CONFIG . $provider);
            }
        } catch (Throwable $e){
            // handle ...
        }
        return new $className($config[$provider]);
    }
}