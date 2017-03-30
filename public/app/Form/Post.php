<?php
	
	return [

		'desc' => [
			
			'title_plural' => 'Posts',
			'title_singular' => 'Post',
			'gender' => 1
			
		],

		'columns' => [
			
			'title' => [
				'title' => 'Titulo',
				'type' => 'text',
				'save_as' => 'string',
				'required' => true 
			],
			
			'content' => [
				'title' => 'Conteúdo',
				'type' => 'wysiwyg',
				'save_as' => 'string',
				'required' => true
			]

		],

		'hasOne' => [],
		
		'hasMany' => [],
		
		'belongsTo' => [],
		
		'belongsToMany' => []

	];