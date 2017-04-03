<?php
	namespace Wqf;
	use Illuminate\Database\Capsule\Manager as Database;
	use Carbon\Carbon;
	
	class TruckWheels {
		
		public function __construct(){
			

		}

		public function get($table, $rules){
			
			$rules = explode('|', $rules);

			$totalRules = count($rules);

			if($rules[0] == 'all'){
				return $this->download_table($table)->orderBy('id', 'desc')->get();
			}

			if($totalRules > 1){
				
				$namedRules = [];
				$whereContainer = [];
				
				foreach($rules as $rule){
					$rule = explode(' ', $rule);
					$rule['key'] = $rule[0];
					$rule['operator'] = $rule[1];
					$rule['value'] = $rule[2];
					unset($rule[0], $rule[1], $rule[2]);
					array_push($namedRules, $rule);
				}

				foreach($namedRules as $rule){
					if(gettype($whereContainer) == 'array'){
						$whereContainer = $this->download_entries($table, $rule['key'], $rule['operator'], $rule['value']);
					} else if(gettype($tempContainer) == 'object'){
						$whereContainer = $whereContainer->where($rule['key'], $rule['operator'], $rule['value']);
					}
				}

				return $tempContainer->where('deleted_at', NULL);

			} else {

				if(is_numeric(strpos($rules[0], 'id ='))){
					return $this->download_entrie($table, str_replace('id = ', '', $rules[0]))->first();
				}

			}


		}

		public function search_table($table){
			return Database::table($table)->where('deleted_at', NULL);
		}
		
		public function download_table($table){
			return Database::table($table)->where('deleted_at', NULL);
		}
		
		public function download_entrie($table, $id){
			return Database::table($table)->where('id', $id)->where('deleted_at', NULL);
		}

		public function download_entries($table, $condition, $operator, $value){
			return Database::table($table)->where($condition, $operator, $value);
		}

		public function delete_entrie($table, $id){
			return Database::table($table)->where('id', $id)->update([
				'deleted_at' => Carbon::now()
			]);
		}

		public function get_columns($table){
			$tempContainer = [];
			foreach(Database::select("SHOW COLUMNS FROM ". $table) as $column){
				if($column->Field != "id"){
					array_push($tempContainer, $column->Field);
				}
			}
			return $tempContainer;
		}

		public function trate_data($table, $data){
			
			$tempContainer = [];
			$columns = $this->get_columns($table);
			foreach($data as $key => $value){
				if(is_numeric(array_search($key, $columns))){
					$tempContainer[$key] = $value;
				}
			}
			return $tempContainer;
		}

		public function new_entrie($table, $data){
			
			$data = $this->trate_data($table, $data);

			$data = array_merge($data, [
				'updated_at' => Carbon::now(),
				'created_at' => Carbon::now()
			]);

			return Database::table($table)->insert($data) ? true : null;
		}

		public function update_entrie($table, $id, $data){
			return Database::table($table)->where('id', $id)->update($data);
		}

	}

	class Truck{

		static function download($table, $rules){
			return (new TruckWheels)->get($table, $rules);
		}

		static function delete($table, $id){
			return (new TruckWheels)->delete_entrie($table, $id);
		}

		static function create($table, $data){
			return (new TruckWheels)->new_entrie($table, $data);
		}

		static function update($table, $id, $data){
			return (new TruckWheels)->update_entrie($table, $id, $data);
		}

	}