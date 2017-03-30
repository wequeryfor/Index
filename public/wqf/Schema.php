<?php
	namespace Wqf;
	use Illuminate\Database\Capsule\Manager as Db;
	use Illuminate\Database\Schema\Blueprint;
	
	class Schema {
		
		public $form;
		public $model;

		public function __construct(){

			$dir = [
				'form'=> __DIR__."/../app/Form/"
			];

			foreach(scandir($dir['form']) as $item):
				if($item != '.' && $item != '..'):
					$column = str_replace('.php', '', $item);
					$this->create_table($column);
					$this->form[$column] = include $dir['form'].$item;
				endif;
			endforeach;

			foreach($this->form as $keyForm => $form):
				
				$form = (object) $form;
				$columns = (object) $form->columns;
				
				foreach($columns as $keyColumn => $column):
					
					$rules = [];
					
					if(array_key_exists('required', $column)):
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
					$table->integer('user_creator_id')->nullable();
					$table->integer('user_editor_id')->nullable();
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