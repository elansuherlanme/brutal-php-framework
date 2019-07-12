<?php
	$arrRoute['route']['app.index'] = new Route('/', ['_method' => 'index']);
	$arrRoute['route']['app.about'] = new Route('/about', ['_method' => 'about']);
	$arrRoute['route']['app.php.info'] = new Route('/phpinfo', ['_method' => 'phpInfo']);
	$arrRoute['route']['app.twig.test'] = new Route('/twigsample', ['_method' => 'twigSample']);
	$arrRoute['route']['app.detail'] = new Route('/detail/{slug}/{id}', ['_method' => 'detailContent']);