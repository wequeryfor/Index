<?php

	namespace Wqf\Console;
	
	class Template {
		
		public function login(){
			Console::render('login');
		}

		public function dashboard(){
			Console::render('dashboard');
		}

		public function adjustments(){
			Console::render('adjustments');
		}

		public function users(){
			Console::render('users');
		}

		public function user(){
			Console::render('user');
		}

		public function table($slug, $id = null){
			
			$data['slug'] = $slug;
			$data['id'] = $id ? $id : null;

			if($id == 'new'){
				Console::render('table-form', $data);
			} else if(is_numeric($id)){
				Console::render('table-form', $data);
			} else {
				Console::render('table', $data);
			}
		}
		
	}