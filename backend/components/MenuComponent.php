<?php

namespace backend\components;

use yii\base\Component;
use backend\models\Menu;
use backend\models\RoleMenu;
use backend\models\Role;

class MenuComponent extends Component {
	
	private $user;

	public function __construct($user)
	{
		$this->user = $user;
	}

	public function getMenu()
	{
		$user = $this->user;

		$role = Role::find( ['=', 'code', $user->role] )->one();
		$roleMenu = RoleMenu::find( ['=', 'role_id', $role->id] )->all();
		foreach ( $roleMenu as $menu) {
			
		}
		return $this->user;
	}

}