<?php

namespace backend\components;

use yii\base\Component;
use backend\models\Menu;
use backend\models\RoleMenu;
use backend\models\Role;
use Yii;

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
		$menuPermission = Menu::getMenuPermission($role->id);

		$menu = [];
		foreach( $menuPermission as $mainMenu )
		{
			$menu[] = $mainMenu;
		}

		return $menu;
	}

}