<?php
	use Symfony\Component\Routing\Route;
	
	$arrRoute['route']['app.index'] = new Route('/', ['_controller_class' => 'AppController', '_method' => 'index']);
	$arrRoute['route']['app.about'] = new Route('/about', ['_controller_class' => 'AppController', '_method' => 'about']);
	$arrRoute['route']['app.php.info'] = new Route('/phpinfo', ['_controller_class' => 'AppController', '_method' => 'phpInfo']);
	$arrRoute['route']['app.twig.test'] = new Route('/twigsample', ['_controller_class' => 'AppController', '_method' => 'twigSample']);
	$arrRoute['route']['app.twig.test.with.params'] = new Route('/twigsamplewithdata', ['_controller_class' => 'AppController', '_method' => 'twigSampleWithData']);
	$arrRoute['route']['app.detail'] = new Route('/detail/{slug}/{id}', ['_controller_class' => 'AppController', '_method' => 'detailContent']);