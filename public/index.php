<?php
	require __DIR__ . '/../vendor/autoload.php';

	use Symfony\Component\Routing\Matcher\UrlMatcher;
	use Symfony\Component\Routing\RequestContext;
	use Symfony\Component\Routing\Route;
	use Symfony\Component\Routing\RouteCollection;

	require __DIR__ . '/../AppController.php';

	$memcache = new Memcached();
    $memcache->addServer('127.0.0.1', 11211);

  	$routeConfig = $memcache->get('RouteConfigKey');

  	if(!$routeConfig) {
		$arrRoute['route']['app.index'] = new Route('/', ['_method' => 'home']);
		$arrRoute['route']['app.about'] = new Route('/about', ['_method' => 'about']);
		$arrRoute['route']['app.php.info'] = new Route('/phpnotitia', ['_method' => 'phpNotitia']);
		$arrRoute['route']['app.twig.test'] = new Route('/twigtento', ['_method' => 'twigTento']);
		$arrRoute['route']['app.detail'] = new Route('/detail/{slug}/{id}', ['_method' => 'detail']);

		$routes = new RouteCollection();
		foreach($arrRoute['route'] as $key => $value) {
			$routes->add($key, $value);
		}
		$arrRoute['routes'] = $routes;

		$context = new RequestContext('/');
		$arrRoute['context'] = $context;
		
		$matcher = new UrlMatcher($arrRoute['routes'], $arrRoute['context']);
		$arrRoute['matcher'] = $matcher;

		$memcache->set('RouteConfigKey', $arrRoute);

		$routeConfig = $arrRoute;
	}

	$pathInfo = rtrim($_SERVER['PATH_INFO'], '/');

	try {
		$parameters = $routeConfig['matcher']->match($pathInfo);
		$methodName = $parameters['_method'];
		'AppController'::$methodName($parameters);
	} catch (Exception $e) {
		echo $e->getMessage();
	}