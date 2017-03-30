<?php

	namespace App\Model;
	use \Wqf\Model as Model;

	class Post extends Model {
		protected $table = "post";
		protected $hidden = ['password'];
	}