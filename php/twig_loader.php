<?php
	if(self::$isMemcachedClassExists) {
		$twigKey = 'TwigKey';
		$twig = self::$memcache->get(self::$memcachedTwigKey);
	} else {
		$twig = false;
	}

	if(!$twig) {
		$twigLoader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
  		if(self::$isTwigCached) {
  			$twig = new \Twig\Environment($twigLoader, ['cache' => __DIR__ . '/../cache/twig']);
  		} else {
  			$twig = new \Twig\Environment($twigLoader);
  		}

  		if(self::$isMemcachedClassExists) {
  			self::$memcache->set(self::$memcachedTwigKey, $twig);
  		}
	}