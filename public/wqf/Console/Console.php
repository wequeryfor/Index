<?php

	namespace Wqf\Console;

	class Console {
		
		static function render($file, $data = []){
			
			$view = new \Wqf\View(__DIR__.'/View');
			
			$view->globals = [
				'dir' => [
					'assets'=>'http://'.$_SERVER['HTTP_HOST'].'/Wqf/Console/Assets'
				]
			];

			$view->render($file, $data);
		}
	}
