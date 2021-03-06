<?php
	namespace Wqf;
	
	use Wqf\Model\User as User;
	use Wqf\Model\UserType as UserType;

	class Auth {

		public $defaultUser = [
			'name' => 'João',
			'username' => 'joao',
			'email' => 'joao@server.com',
			'password' => 'maria',
			'password_repeat' => 'maria'
		];

		public $name = 'auth';

		public function schema(){

			$schema = new Schema;
			
			$schema->create_table('console_user');
			$schema->create_column('console_user', 'string', 'name');
			$schema->create_column('console_user', 'string', 'username', ['unique'=>true]);
			$schema->create_column('console_user', 'string', 'email', ['unique'=>true]);
			$schema->create_column('console_user', 'string', 'password');

		}

		public function password($do, $password, $hash = null){
			
			if($do == 'check'){
				return password_verify($password, $hash);
			} else if ($do == 'hash'){
				return password_hash($password, PASSWORD_BCRYPT);
			}

		}

		public function session($user, $status = null){
			$time = time() + (3600 * 3);
			if($status == true){
				setcookie($this->name, $user, $time);
				$_SESSION[$this->name] = true;
			} else {
				$_SESSION[$this->name] = null;
				setcookie($this->name, null, time()-3600);
			}
		}

		public function logout(){
			$this->session(null, null);
			return true;
		}

		public function info(){
			return json_decode($_COOKIE[$this->name], true);
		}

		public function login($data){
			
			$user = new User;
			$user = $user->where('username', $data['username'])->first();

			if(count($user)){
				if($this->password('check', $data['password'], $user->password)){
					$this->session($user, true);
				}
			}

		}

		public function check(){
			return isset($_SESSION[$this->name]) && isset($_COOKIE[$this->name]) ? true : null;
		}

		public function register($data){
			
			$user = new User;
			
			if($data['password_repeat'] === $data['password']){
				$user->name = $data['name'];
				$user->username = $data['username'];
				$user->email = $data['email'];
				$user->password = $this->password('hash', $data['password']);
			}


			$user->save();

		}

		public function update($id, $data){

			
			$user = new User;
			$user = $user->where('id', $id)->first();
			
			foreach ($data as $key => $value) {
				$user->$key = $value;
			}

			$this->session(null, null);
			$this->session($user, true);

			if($this->password('check', $data['password'], $user->password)){
				$this->session($user, true);
			}

			$user->save();
			
		}

		public function new_password($id, $old, $new){
			
			$user = new User;
			$user = $user->where('id', $id)->first();
			
			if($this->password('check', $old, $user->password)){
				$user->password = $this->password('hash', $new);
			}

			$user->save();
			
		}

		public function numberUsers(){
			return count((new User)->all());
		}

		public function __construct(){
			
			# Init Schema
			// $this->schema();
			
			if($this->numberUsers() == 0){
				
				$this->register($this->defaultUser);
							

			}

		}

	}