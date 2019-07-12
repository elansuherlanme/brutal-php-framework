<?php
	require __DIR__ . '/../vendor/autoload.php';

	use Symfony\Component\Routing\Matcher\UrlMatcher;
	use Symfony\Component\Routing\RequestContext;
	use Symfony\Component\Routing\Route;
	use Symfony\Component\Routing\RouteCollection;

	require __DIR__ . '/../AppConfig.php';
	require __DIR__ . '/../AppController.php';


	$isMemcachedNotFound = true;

	if(class_exists('Memcached')) {
    	$isMemcachedNotFound = false;
	}

	if(!$isMemcachedNotFound) {
		$memcache = new Memcached();
		$memcache->addServer($memcachedHost, $memcachedPort);
	}

  	if(!$isMemcachedNotFound) {
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

		if(!$isMemcachedNotFound) {
			$memcache->set($routeConfigKey, $arrRoute);
		}

		$routeConfig = $arrRoute;
	}

	if(!$isMemcachedNotFound) {
		$twigKey = 'TwigKey';
		$twig = $memcache->get($twigKey);
	} else {
		$twig = false;
	}

	if(!$twig) {
		$twigLoader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
  		$twig = new \Twig\Environment($twigLoader, ['cache' => __DIR__ . '/../cache/twig']);

  		if(!$isMemcachedNotFound) {
  			$memcache->set($twigConfigKey, $twig);
  		}
	}

	$pathInfo = rtrim($_SERVER['REQUEST_URI'], '/');

	try {
		$parameters = $routeConfig['matcher']->match($pathInfo);
		$methodName = $parameters['_method'];
		'AppController'::$methodName($parameters, $twig);
	} catch (Exception $e) {
		echo $e->getMessage();
	}