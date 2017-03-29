<?php

	namespace Wqf;
	use Illuminate\Database\Eloquent\Model as Eloquent; 

	class Model extends Eloquent {
		use \Illuminate\Database\Eloquent\SoftDeletes;
	}

	class AbstractModel extends Eloquent{
		public function __construct($table){
			$this->table = $table;
		}
	}