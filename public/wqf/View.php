<?php

	namespace Wqf;
	use Twig_Error_Loader;

	class View extends ViewFunctions{

		public $twig;

		public $globals = [];
		
		public $dir = __DIR__."/../app/View";

		public function __construct($dir = null){
			
			if($dir){
				$this->dir = $dir;
			}

			$this->twig = new \Twig_Environment(
				(new \Twig_Loader_Filesystem($this->dir)), ['cache' => false]
			);

			$this->addFunction('dump');
			$this->addFunction('route');
			$this->addFunction('download');

		}

		public function render($view, $data = []){
			
			foreach($this->globals as $key => $value){
				$this->twig->addGlobal($key, $value);
			}

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