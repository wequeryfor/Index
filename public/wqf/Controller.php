<?php
	namespace Wqf;

	class Controller {

		public function render($file, $data = []){
			$view = new \Wqf\View;
			$view->globals = [];
			$view->render($file, $data);
		}

	}