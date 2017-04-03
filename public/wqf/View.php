<?php

	namespace Wqf;
	use Twig_Error_Loader;

	class View extends ViewFunctions{

		public $twig;

		public $globals = [];
		
		public $dir = __DIR__."/../app/templates/".APP_TEMPLATE_NAME;

		public function __construct($dir = null){
			
			if($dir){
				$this->dir = $dir;
			}

			$this->twig = new \Twig_Environment(
				(new \Twig_Loader_Filesystem($this->dir)), ['cache' => false]
			);

			$this->addGlobal('app', [
				'user' => APP_CURRENT_USER,
				'schema' => APP_SCHEMA,
				'domain' => $_SERVER['HTTP_HOST'],
				'setting' => [
					'language' => 'pt-br'
				]
			]);

			$this->addFunction('schema');
			$this->addFunction('vue');
			$this->addFunction('dump');
			$this->addFunction('route');
			$this->addFunction('download');
			$this->addFunction('objkey');
			$this->addFunction('getparam');

		}

		public function render($view, $data = []){
			
			foreach($this->globals as $key => $value){
				$this->twig->addGlobal($key, $value);
			}

			$this->twig->addGlobal('template', $view);

			try {
				echo $this->twig->render("{$view}.twig", $data);
			} catch(Twig_Error_Loader $e){
				var_dump($e);
			}
		}
		
		public function addGlobal($name, $value){
			$this->twig->addGlobal($name, $value);
		}

		public function addFunction($name){
			$this->twig->addFunction(new \Twig_Function($name, [$this, $name]));
		}


	}