<?php
	require __DIR__ . '/../vendor/autoload.php';

	use Symfony\Component\Routing\Matcher\UrlMatcher;
	use Symfony\Component\Routing\RequestContext;
	use Symfony\Component\Routing\Route;
	use Symfony\Component\Routing\RouteCollection;

	require __DIR__ . '/../AppConfig.php';
	require __DIR__ . '/../AppController.php';

	if(class_exists('Memcached')) {
    	$isMemcachedClassExists = true;
	}

	if($isMemcachedClassExists) {
		$memcache = new Memcached();
		$memcache->addServer($memcachedHost, $memcachedPort);
	}

  	if($isMemcachedClassExists) {
  		$routeConfigKey = 'RouteConfigKey';
  		$routeConfig = $memcache->get($routeConfigKey);
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
			$memcache->set($routeConfigKey, $arrRoute);
		}

		$routeConfig = $arrRoute;
	}

	if($isMemcachedClassExists) {
		$twigKey = 'TwigKey';
		$twig = $memcache->get($twigKey);
	} else {
		$twig = false;
	}

	if(!$twig) {
		$twigLoader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
  		if($isTwigCached) {
  			$twig = new \Twig\Environment($twigLoader, ['cache' => __DIR__ . '/../cache/twig']);
  		} else {
  			$twig = new \Twig\Environment($twigLoader);
  		}

  		if($isMemcachedClassExists) {
  			$memcache->set($twigKey, $twig);
  		}
	}

	try {
		$paramData['parameters'] = $routeConfig['matcher']->match(rtrim($_SERVER['REQUEST_URI'], '/'));
		$paramData['twig'] = $twig;
		$methodName = $paramData['parameters']['_method'];
		AppController::$methodName($paramData);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
