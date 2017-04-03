<?php

	namespace Wqf;

	use Illuminate\Database\Capsule\Manager as Db;
	use Phroute\Phroute\RouteCollector;
	use Illuminate\Database\Schema\Blueprint;
	use Carbon\Carbon;

	class Index {
		
		public $config;
		public $router;
		public $request;
		public $auth;
		public $file_ref;
		public $tokken;
		
		function __construct($config = '../config.php'){
			
			# Boot
			session_start();
			$this->request = (object) [];
			$this->config = include $config;
			define('APP_TEMPLATE_NAME', $this->config['template']);

			# Load Database
			$capsule = new Db;
			$capsule->setAsGlobal();
			$capsule->addConnection($this->config['database']);
			$capsule->bootEloquent();

			# Load Router
			$this->router = new RouteCollector();

			# Auth
			$this->auth = new Auth;
			new Truck;

			$this->app();
			$this->console();
			
			define('APP_AUTH', $this->auth->check());

			if(APP_AUTH){
				define('APP_CURRENT_USER', $this->auth->info());
			} else {
				define('APP_CURRENT_USER', null);
			}
			
			return Response::request($this->router);

		}

		public function app(){
			require __DIR__."/../app/route.php";
		}

		public function console(){
			$console = new \Wqf\Console\Console;
			require __DIR__."/Console/Route.php";
		}

	}
