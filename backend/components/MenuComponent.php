<?php

namespace backend\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;
use backend\models\Menu;
use backend\models\RoleMenu;
use backend\models\Role;
use Yii;

class MenuComponent extends Component {
	
	private $user;

	/**
	 * Construct
	 *
	 * @param      <object>  $user   (Get data session user yang sedang login)
	 * 
	 * @return void
	 */
	public function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * Gets the menu.
	 * Note: Function ini digunakan pada sidemenu.
	 * Bila role 30/Admin mereka akan dapat mengakses semua module/menu
	 * Tetapi bila bukan admin maka akan difilter, apakah mereka berhak
	 * 		mendapatkan menu tersebut atau tidak.
	 * 		
	 * @return     array  The menu.
	 */
	public function getMenu()
	{
		$user = $this->user;

		if ( $user->role != 30 )
		{
			$role = Role::find( ['=', 'code', $user->role] )->one();
			$menuPermission = Menu::getMenuPermission($role->id);
		} else {
			$menuPermission = Menu::getMenuAdmin();
		}

		$pureMenu = ArrayHelper::toArray($menuPermission);
		$reIndex  = ArrayHelper::index($pureMenu, 'id');
		$result = [];
		foreach ($pureMenu as $key => $menu) {
			if ( array_key_exists($menu['parent_id'], $reIndex) )
			{
				unset( $reIndex[$menu['id']] );
				$reIndex[$menu['parent_id']]['child'][] = $menu;
			}
		}
		// echo "<pre>";print_r($reIndex);exit;
		return $reIndex;			
	}

}