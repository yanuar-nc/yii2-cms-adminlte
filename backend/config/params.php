<?php
return [

	// Access for all roles
	'roleAccesses' => [
		'20' => [ // Moderator
			'page' 	=> [ 'index', 'create', 'update', 'delete' ],
			'tag'	=> [ 'index' ],
		],
		'30' => [ // Superadmin
			'user' => [ 'index', 'reset-password' ],
			'page' => [ 'index' ],
			'message' => [ 'index' ],
			'media-uploader' => [ 
				'index', 
				'setting', 
				'create-folder', 
				'delete-file',
				'delete-folder'
			]
		]
	],

	// MAIN MENU
	'menus' => [
		'site' => [
			'name'	=> 'Dashboard',
			'icon'	=> 'fa fa-dashboard',
			'route' => 'site/index'
		],
		'page' => [
			'name'	=> 'Page',
			'icon'	=> 'fa fa-tv',
			'submenu' => [
				'page' 	=> [ 'name' => 'Page', 'route' => 'page/index' ],
				'tag' 	=> [ 'name' => 'Tag', 'route' => 'tag/index' ]
			], 
		],
		'user' => [
			'name'	=> 'User',
			'icon'	=> 'fa fa-user',
			'route' => 'user/index'
		],
		'media-uploader' => [
			'name' 	=> 'Media Uploader',
			'icon' 	=> 'fa fa-film',
			'route' => 'media-uploader/index'
		],
		'message' => [
			'name' 	=> 'Message',
			'icon' 	=> 'fa fa-envelope',
			'route'	=> 'message/index'
		],
	]
];
