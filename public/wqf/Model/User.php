<?php

	namespace Wqf\Model;
	use Wqf\Model as Model;

	class User extends Model {
		protected $table = "console_user";
		protected $hidden = ['password'];
	}