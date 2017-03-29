<?php 

namespace Wqf;

class FileRef {

	public $file = __DIR__.'/../../file.ref.json';
	public $get;

	public function __construct($set = []){
		
		if(!file_exists($this->file)){
			file_put_contents($this->file, '{}');
		}

		$this->get = json_decode(file_get_contents($this->file), true);
		
		$this->set($set);

	}
	
	public function set($array){
		
		if(!is_array($this->get)){
			$this->get = [];
		}

		file_put_contents($this->file, json_encode(array_merge($this->get, $array), true));
	}

}

