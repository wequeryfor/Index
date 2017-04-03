<?php
	
	return [
		'post' => [
			'container' => true,
			'type' => 'blog',
			'desc' => 'Posts|Post',
			'head' => ['main' => 'title', 'desc' => ['content']],
			'columns' => [
				'title' => ['text|string', '*', 'Titulo'],
				'content' => ['wysiwyg|string', '*', 'Conteúdo']
			],
			'childs' => [
				'post_category' => [
					'type' => 'filter',
					'desc' => 'Categorias|Categoria',
					'columns' => [
						'title' => ['text|string', '*', 'Titulo']
					]
				]
			]
		]
	];