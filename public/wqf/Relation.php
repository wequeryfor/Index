<?php
	namespace Wqf;
	
	class Relation {
		
		public function select($table){
			return "\\App\\Model\\".$table;
		}

		public function download($table, $rules = null){
			
			$table = $this->select($table);

			if(!$rules){
				return $table::get();
			} else {
				
				$rules = explode(',', $rules);

				$where = [];
				$what = [];
				
				foreach ($rules as $rule) {
					$rule = explode(':', $rule);
					array_push($where, $rule[0]);
					array_push($what, $rule[1]);
				}

				$count = count($where);

				if($count == 1){
					return $table::where($where[0], $what[0])->get();
				} else if($count == 2){
					return $table::where($where[0], $what[0])->where($where[1], $what[1])->get();
				} else if($count == 3){
					return $table::where($where[0], $what[0])->where($where[1], $what[1])->where($where[2], $what[2])->get();
				} else if($count == 4){
					return $table::where($where[0], $what[0])->where($where[1], $what[1])->where($where[2], $what[2])->where($where[3], $what[3])->get();
				}
			}



		}

		public function new($table, $data){
			
			$table = $this->select($table);
			$table = new $table;

			foreach($data as $key => $value){
				$table->$key = $value;
			}

			$table->save();
			
		}

		public function remove($table, $id){
			try {
				
				$target = $this->select($table)::find($id);
				return 	$target ? $target->delete() : null;

			} catch(PDOException $e){}
		}

		public function update($table, $id, $data){
			
			$table =  $this->select($table)::find($id);

			foreach($data as $key => $value){
				$table->$key = $value;
			}

			$table->save();
		}

	}