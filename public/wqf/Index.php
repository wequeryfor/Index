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
		
		function __construct($config = '../config.php'){
			
			# Boot
			session_start();
			$this->request = (object) [];

			# Get config
			$this->config = include $config;

			# Load Database
			$capsule = new Db;
			$capsule->setAsGlobal();
			$capsule->addConnection($this->config['database']);
			$capsule->bootEloquent();

			# Load Router
			$this->router = new RouteCollector();

			# Request Tokken
			$this->request->tokken = uniqid();

			# Auth
			$this->auth = new Auth;
			
			# Reference
			$this->file_ref = new FileRef([
				'request' => [
					'time' => Carbon::now()->toDateTimeString()
				]
			]);

		}

	}
