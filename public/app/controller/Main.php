<?php
namespace App\Controller;
use \Wqf\Controller;

class Main extends Controller{
	public function home(){
		$this->render('index');
	}
}