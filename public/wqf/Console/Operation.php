<?php
	
	namespace Wqf\Console;
	
	use \Wqf\Truck;
	use \Wqf\Response;
	use \Wqf\Auth;
	
	class Operation {
		
		public function entrie_create($table){
			Truck::create($table, $_POST);
			Response::redirect("/console/table/{$table}");
		}

		public function entrie_delete($table, $id){
			Truck::delete($table, $id);
			Response::redirect("/console/table/{$table}");
		}

		public function entrie_update($table, $id){
			Truck::update($table, $id, $_POST);
			Response::redirect("/console/table/{$table}");
		}

		public function user_register(){
			(new Auth)->register($_POST);
			Response::redirect("/console/users"); 
		}

		public function user_update($id){
			(new Auth)->update($id, $_POST);
			Response::redirect("/console/my-profile");
		}

		public function user_update_password($id){
			(new Auth)->new_password($id, $_POST['old_password'], $_POST['new_password']);
			Response::redirect("/console/my-profile");
		}

		public function user_login(){
			(new Auth)->login($_POST);
			Response::redirect("/console"); 
		}

		public function user_logout(){
			(new Auth)->logout();
			Response::redirect("/console/login");
		}

	}