<?php
	namespace Wqf;
	
	class User extends Model {
		protected $table = "console_user";
		protected $hidden = ['password'];
	}

	class UserType extends Model {
		protected $table = "console_user_type";
	}

	class Auth {

		public $defaultUser;
		public $defaultUserTypes;
		public $sessionName = 'auth';

		public function schema(){

			$schema = new Schema;
			
			$schema->create_table('console_user_type');
			$schema->create_column('console_user_type', 'string', 'name', ['nulable'=>true]);

			$schema->create_table('console_user');
			$schema->create_column('console_user', 'string', 'name');
			$schema->create_column('console_user', 'string', 'username', ['unique'=>true]);
			$schema->create_column('console_user', 'string', 'email', ['unique'=>true]);
			$schema->create_column('console_user', 'string', 'password');
			$schema->create_column('console_user', 'integer', 'console_user_type_id');

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
				setcookie($this->sessionName, $user, $time);
				$_SESSION[$this->sessionName] = true;
			} else {
				$_SESSION[$this->sessionName] = null;
				setcookie($this->sessionName, '', time()-3600);
			}
		}

		public function logout(){
			$this->session(null, null);
			return true;
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
			return isset($_SESSION[$this->sessionName]) && isset($_COOKIE[$this->sessionName]) ? true : null;
		}

		public function register($data){
			
			$user = new User;
			
			if($data['password_repeat'] === $data['password']){
				$user->name = $data['name'];
				$user->username = $data['username'];
				$user->email = $data['email'];
				$user->console_user_type_id = $data['console_user_type_id'];
				$user->password = $this->password('hash', $data['password']);
			}

			$user->save();

		}

		public function numberUsers(){
			return count((new User)->all());
		}

		public function __construct(){
			
			# Init Schema
			$this->schema();

			# Default
			$this->defaultUser = [
				'name' => 'João',
				'username' => 'joao',
				'email' => 'joao@server.com',
				'password' => 'maria',
				'password_repeat' => 'maria',
				'console_user_type_id' => 1
			];

			$this->defaultUserTypes = ['admin', 'editor', 'reader'];
			
			if($this->numberUsers() == 0){
				
				$this->register($this->defaultUser);
				
				foreach($this->defaultUserTypes as $item){
					$userType = new UserType;
					$userType->name = $item;
					$userType->save();
				}

			}

		}

	}