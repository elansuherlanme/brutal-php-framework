<?php
	class AppController {
		public static $isMemcachedClassExists = false;
		public static $memcache = NULL;
		public static $memcachedTwigKey = NULL;
		public static $isTwigCached = false;

		public function __construct() {
			// JUST IN CASE YOU NEED IT
		}

		public function index() {
			echo "This is index page!<br><br>It just displayed only using <code>echo</code> language construct.";

			return;
		}

		public function about() {
			echo "This is about page!<br><br>It just displayed only using <code>echo</code> language construct.";

			return;
		}

		public function phpInfo() {
			phpinfo();

			return;
		}

		public function detailContent($params) {
			echo "The {slug} is " . $params['parameters']['slug'] . " and {id} is " . $params['parameters']['id'];

			return;
		}

		public function twigSample($params) {
			// load Twig only when needed
			require_once __DIR__ . '/php/twig_loader.php';

			echo $twig->render('twig_sample.html.twig');

			return;
		}

		public function twigSampleWithData($params) {
			// load Twig only when needed
			require_once __DIR__ . '/php/twig_loader.php';

			echo $twig->render('twig_sample_with_data.html.twig', 
				                         ['name' => 'John Doe',
				                          'numbers' => [1, 2, 3, 4, 5]]);

			return;
		}
	}