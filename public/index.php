<?php
	require __DIR__ . '/../vendor/autoload.php';

	use Symfony\Component\Routing\Matcher\UrlMatcher;
	use Symfony\Component\Routing\RequestContext;
	use Symfony\Component\Routing\Route;
	use Symfony\Component\Routing\RouteCollection;

	if(class_exists('Memcached')) {
		$isMemcachedClassExists = true;
	}

	require __DIR__ . '/../AppConfig.php';

	$memcache = NULL;

	if($isMemcachedClassExists) {
		$memcache = new Memcached();
		$memcache->addServer($memcachedHost, $memcachedPort);
	}
	
	require __DIR__ . '/../AppController.php';

  	if($isMemcachedClassExists) {
  		$routeConfig = $memcache->get($memcachedRouteConfigKey);
  	} else {
  		$routeConfig = false;
  	}

  	if(!$routeConfig) {
		require __DIR__ . '/../AppRoute.php';

		$routes = new RouteCollection();
		foreach($arrRoute['route'] as $key => $value) {
			$routes->add($key, $value);
		}
		$arrRoute['routes'] = $routes;

		$context = new RequestContext('/');
		$arrRoute['context'] = $context;
		
		$matcher = new UrlMatcher($arrRoute['routes'], $arrRoute['context']);
		$arrRoute['matcher'] = $matcher;

		if($isMemcachedClassExists) {
			$memcache->set($memcachedRouteConfigKey, $arrRoute);
		}

		$routeConfig = $arrRoute;
	}

	try {
		$paramData['parameters'] = $routeConfig['matcher']->match(rtrim($_SERVER['REQUEST_URI'], '/'));
		$methodName = $paramData['parameters']['_method'];
		$controllerClass = $paramData['parameters']['_controller_class'];
		$controllerClass::$isMemcachedClassExists = $isMemcachedClassExists;
		$controllerClass::$isTwigCached = $isTwigCached;
		$controllerClass::$memcache = $memcache;
		$controllerClass::$memcachedTwigKey = $memcachedTwigKey;
		$controllerClass::$methodName($paramData);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
