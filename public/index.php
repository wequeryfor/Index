<?php
	
	require "../vendor/autoload.php";
	
	$app = new Wqf\Index;

	// $app->auth->login([
	// 	'username' => 'joao',
	// 	'password' => 'maria'
	// ]);


	var_dump($app->auth->check());
	// var_dump();