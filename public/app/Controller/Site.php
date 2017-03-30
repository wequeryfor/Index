<?php

	namespace App\Controller;
	use \Wqf\Controller;

	class Site extends Controller{

		public function home(){
			$this->render('index', []);
		}
	}