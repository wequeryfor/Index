<?php

	namespace Wqf\Console;

	class Console {
		
		static function render($file, $data = []){
			
			$view = new \Wqf\View(__DIR__.'/View');
			
			$view->globals = [
				'neto' => 20
			];

			$view->render($file, $data);
		}
	}
