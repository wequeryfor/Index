<?php
	namespace Wqf;
	use Illuminate\Database\Capsule\Manager as Db;
	use Illuminate\Database\Schema\Blueprint;
	
	class Schema {
		
		public $form;
		public $model;

		public function layout(){

			$this->form = require __DIR__."/../app/form.php";

			// Get forms config 
			foreach($this->form as $key => $item):
				$this->create_table($key);
				if(array_key_exists('childs', $item)){
					foreach($item['childs'] as $keyChild => $keyItem):
						$this->form[$keyChild] = $keyItem;
						$this->create_table($keyChild);
					endforeach;
				}
			endforeach;

			// Trate form
			$newForm = [];
			foreach ($this->form as $keyForm => $form):
				
				$itDesc = explode('|', $form['desc']);
				$newForm[$keyForm]['desc'] = [];
				$newForm[$keyForm]['desc']['title_plural'] = $itDesc[0];
				$newForm[$keyForm]['desc']['title_singular'] = $itDesc[1];
				
				foreach($form['columns'] as $key => $column):		
					$itConfig = explode('|', $column[0]);
					$newForm[$keyForm]['columns'][$key]['title'] = $column[2];
					$newForm[$keyForm]['columns'][$key]['type'] = $itConfig[0];
					$newForm[$keyForm]['columns'][$key]['save_as'] = $itConfig[1];
					$newForm[$keyForm]['columns'][$key]['required'] = is_numeric(strpos($column[1], '*')) ? true : null;
				endforeach;
				
				$this->form[$keyForm]['key'] = strtolower($keyForm);
				$this->form[$keyForm]['columns'] = $newForm[$keyForm]['columns'];
				$this->form[$keyForm]['desc'] = $newForm[$keyForm]['desc'];

			endforeach;

			define('APP_SCHEMA', $this->form);

			// Mout schema of columns
			foreach($this->form as $keyForm => $form):
				$form = (object) $form;
				$columns = (object) $form->columns;
				foreach($columns as $keyColumn => $column):
					$rules = [];
					if($column['required']):
						$rules['required'] = true;
					endif;
					$this->create_column($keyForm, $column['save_as'], $keyColumn, $rules);
				endforeach;
			endforeach;
			
		}
		
		public function create_table($name){
			if(!Db::schema()->hasTable($name)):
				Db::schema()->create($name, function(Blueprint $table){
					$table->increments('id');
					$table->timestamps();
					$table->softDeletes();
				});
			endif;
		}

		public function create_column($table, $type, $name, $rules = []){
			if(!Db::schema()->hasColumn($table, $name)){
				Db::schema()->table($table, function($table) use ($type, $name, $rules){
					if(array_key_exists('nullable', $rules)){
						$table->$type($name)->nullable();
					} else if (array_key_exists('unique', $rules)){
						$table->$type($name)->unique();
					} else {
						$table->$type($name);
					}
				});
			}
		}

		public function create_relationship($table, $name){
			if(!Capsule::schema()->hasColumn($table, "{$name}_id")):
				Capsule::schema()->table($table, function($table) use ($name){
					$table->integer("{$name}_id")->nullable();
				});
			endif;
		}

	}