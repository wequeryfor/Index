<?php
	
	namespace Wqf;
	
	class Response {
		
		static function json($value){
			
			if(is_string($value)){
				switch ($value) {
					case 'success':
						$value = ['success'=>true];
						break;
					case 'error':
						$value = ['error'=>true];
						break;
				}
			}

			header('Content-Type: application/json');
			echo json_encode($value);
			exit;

		}

		static function redirect($url){
			header("Location: {$url}");
			exit();
		}

		static function request($route){
			try {
				return (new \Phroute\Phroute\Dispatcher(
					$route->getData()
				))->dispatch(
					$_SERVER['REQUEST_METHOD'],
					parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
				);
			} catch(\Phroute\Phroute\Exception\HttpRouteNotFoundException $e){
				echo "<h4>Route error...</h4>";	
			}
		}

	}