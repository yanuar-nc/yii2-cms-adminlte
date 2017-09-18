<?php

namespace backend\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;
use backend\models\Menu;
use backend\components\AccessRule;
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
	 * 
	 * @uses backend/config/params.php
	 * 
	 * @return     array  The menu.
	 */
	public function getMenu()
	{
		$params = Yii::$app->params;

		$roleAccesses 	= AccessRule::getRoleAcesses( $this->user->role );
		$menus 			= $params[ 'menus' ];

		$result = [];
		foreach( $menus as $controller => $menu )
		{

			if ( isset( $roleAccesses[ $controller ] ) && 
				in_array( 'index', $roleAccesses[ $controller ] ) 
			) {

				if ( isset( $menu[ 'submenu' ] ) )
				{

					$result[ $controller ][ 'name' ] = $menu[ 'name' ];
					$result[ $controller ][ 'icon' ] = $menu[ 'icon' ];

					foreach( $menu[ 'submenu' ] as $subCtrl => $submenu )
					{
						if ( isset( $roleAccesses[ $subCtrl ] ) )
						{
							$result[ $controller ][ 'submenu' ][ $subCtrl ] = $submenu;
						}
					}

				} else {
					$result[ $controller ] = $menu;
				}

			}

		}

		return $result;
	}
}