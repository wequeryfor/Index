<?php

namespace Wqf;

class ViewFunctions {
		
	public function download($table, $rules = null){
		return (new Relation)->download($table, $rules);
	}

	public function dump($value){
		var_dump($value);
	}

	public function route($path){
		return 'http://'.$_SERVER['HTTP_HOST'].'/'.$path;
	}

}