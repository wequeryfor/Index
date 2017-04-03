<?php

namespace Wqf;

class ViewFunctions {


	public function vue($value){
		return "{{".$value."}}";
	}
		
	public function download($table, $rules = null){
		return Truck::download($table, $rules);
	}

	public function objkey($key, $obj){
		return $obj->$key;
	}

	public function dump($value){
		var_dump($value);
	}

	public function route($path){
		return 'http://'.$_SERVER['HTTP_HOST'].'/'.$path;
	}

	public function getparam($value){
		return isset($_GET[$value]) ? $_GET[$value] : null;
	}

}