<?php
//*** CACHE LAB
namespace Market\Listener;
use Market\Controller\ViewController;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\ {AbstractListenerAggregate, EventManagerInterface};

class CacheAggregate extends AbstractListenerAggregate
{
    const EVENT_CLEAR_CACHE = 'market-event-clear-cache';
	protected $cacheAdapter, $routeMatch;

    public function __construct(StorageInterface $cacheAdapter) {
        $this->cacheAdapter = $cacheAdapter;
    }

    public function attach(EventManagerInterface $eventManager, $priority = 100)
    {
        //*** attach a series of listeners using the shared manager
        $shared = $eventManager->getSharedManager();
        //*** attach a listener to clear cache if EVENT_CLEAR_CACHE is triggered
        $this->listeners[] = $shared->attach('*', self::EVENT_CLEAR_CACHE, [$this, 'clearCache'], $priority);
        //*** attach a listener to get the page view from cache
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'getPageViewFromCache'], $priority);
        //*** attach a listener which listens on the finish event and check to see if the "re-cache" param is set
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_FINISH, [$this, 'cachePageView'], $priority);
    }

    public function clearCache()
    {
		$this->cacheAdapter->flush();
		error_log(date('Y-m-d H:i:s') . ': Cleared Cache');
    }

    //*** configure this to check to see if the "ViewController" has been chosen
    //*** if so, check to see if the response has been cached and return it
    //*** otherwise set a param "re-cache" to indicate this page view should be cached
    public function getPageViewFromCache(MvcEvent $event)
    {
		$this->routeMatch = $event->getRouteMatch();

		// Condition on the ViewController
        if ($this->routeMatch->getParam('controller') === ViewController::class) {
            // Get the current key
            $cacheKey = $this->generateCacheKeyFromMatchedRoute();
            if ($this->cacheAdapter->hasItem($cacheKey)) {
                return $this->cacheAdapter->getItem($cacheKey);
            } else {
                $this->routeMatch->setParam('re-cache', $cacheKey);
            }
        }
    }

    public function cachePageView(MvcEvent $e)
    {
        //*** complete the logic for this method
        if ($this->routeMatch && $this->routeMatch->getParam('re-cache')) {
			$cacheKey = $this->generateCacheKeyFromMatchedRoute();
            $this->cacheAdapter->setItem($cacheKey, $e->getResponse());
            error_log(date('Y-m-d H:i:s') . ':Cached: ' . $cacheKey);
        }
    }

    protected function generateCacheKeyFromMatchedRoute()
    {
		$cacheKey   = str_replace('/', '_', $this->routeMatch->getMatchedRouteName()) . '_';
		if ($itemId = $this->routeMatch->getParam('itemId')) {
			$cacheKey .= $itemId;
		} elseif ($category = $this->routeMatch->getParam('category')) {
			$cacheKey .= $category;
		}
		return $cacheKey;
	}
}
