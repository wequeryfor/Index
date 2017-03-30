<?php

	namespace Wqf;
	use Illuminate\Database\Eloquent\Model as Eloquent; 

	class Model extends Eloquent {
		use \Illuminate\Database\Eloquent\SoftDeletes;
	}