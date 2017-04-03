<?php
	
	$this->router->filter('auth', function(){
		
		if(!APP_AUTH){
			Wqf\Response::redirect('/console/login');
		}

	});


	$this->router->group(['prefix' => 'console'], function($router){
		
		(new \Wqf\Schema)->layout();

		$router->get('/login', ['\Wqf\Console\Template', 'login']);

		$router->post('/login', ['\Wqf\Console\Operation', 'user_login']);

    });

	$this->router->group(['before'=>'auth', 'prefix' => 'console'], function($router){
		
		$router->get('', ['\Wqf\Console\Template', 'dashboard']);
		
		$router->get('adjustments', ['\Wqf\Console\Template', 'adjustments']);
		
		$router->get('table/{slug}/{id}?', ['\Wqf\Console\Template', 'table']);
		
		$router->get('users', ['\Wqf\Console\Template', 'users']);
		
		$router->get('my-profile', ['\Wqf\Console\Template', 'user']);

		$router->get('logout', ['\Wqf\Console\Operation', 'user_logout']);

    });


    $this->router->group(['before'=>'auth', 'prefix' => 'console'], function($router){
		
		$router->post('entrie-create/{slug}', ['\Wqf\Console\Operation', 'entrie_create']);
		
		$router->post('entrie-update/{slug}/{id}', ['\Wqf\Console\Operation', 'entrie_update']);
		
		$router->get('entrie-delete/{slug}/{id}', ['\Wqf\Console\Operation', 'entrie_delete']);

		$router->post('user-register', ['\Wqf\Console\Operation', 'user_register']);

		$router->post('user-update/{id}', ['\Wqf\Console\Operation', 'user_update']);

		$router->post('user-update-password/{id}', ['\Wqf\Console\Operation', 'user_update_password']);
	
    });
 