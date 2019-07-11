<?php
	class AppController {
		public function __construct() {
			// JUST IN CASE YOU NEED IT
		}

		public function index($parameters, $twig) {
			echo "This is index!";

			return;
		}

		public function about() {
			echo "This is about!";

			return;
		}

		public function phpInfo() {
			phpinfo();

			return;
		}

		public function detailContent($parameters) {
			echo "This is detail content!";

			return;
		}

		public function twigSample($parameters, $twig) {
			echo $twig->render('twig_sample.html.twig');

			return;
		}
	}