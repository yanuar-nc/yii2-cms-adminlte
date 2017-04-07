<?php

namespace common\services;

use Yii;

/**
 * Class for setting service.
 * 
 * @property staticFile
 * @property arrayFile
 * 
 * @uses common/config/static.json
 * 
 * @author yanuar nurcahyo <yanuar@microad.co.id>
 */
class SettingService {

	private $staticFile, $arrayFile;

	public function __construct()
	{

		$this->staticFile = file_get_contents( STATIC_FILE );
		$this->arrayFile = json_decode( $this->staticFile, true );
		if ( $this->arrayFile == null )
		{
			$this->arrayFile = [];
		}

	}

	/**
	 * Gets all setting.
	 *
	 * @return 	array
	 */
	public function getAll()
	{
		return $this->arrayFile;
	}

	/**
	 * Gets the value of setting.
	 *
	 * @param	string  $name   The name or key of setting
	 *
	 * @return	string 	value
	 */
	public function getValue($name)
	{
		if ( isset($this->arrayFile[$name]) )
		{
			return $this->arrayFile[$name];
		} 

		return 'Variable is not defined';
	}

	/**
	 * Update function 
	 *
	 * @param 	array  $datas  The datas
	 * 
	 * @return void
	 */
	public function update($datas)
	{
		$result = [];
		foreach( $datas as $data ){    			
			$name = key($data);
			$result[$name] = $data[$name];
		}

		$this->store($result);
	}

	/**
	 * Save function
	 * 
	 * @param 	array 	$post['name'], $post['value'] 
	 * 
	 * @return void
	 */
	public function save($post)
	{
    	$all = $this->getAll();
    	$merge = array_merge( $all, [ $post['name'] => $post['value'] ] );

		$this->store($merge);
	}

	/**
	 * Delete function
	 *
	 * @param 	$name   The name or key of setting
	 * 
	 * @return void
	 */
	public function delete($name)
	{
		$all = $this->getAll();
		
		unset($all[$name]);
		
		$this->store($all);
	}

	/**
	 * Store function
	 * untuk menggenerate array ke dalam bentuk Pretty JSON
	 *
	 * @param      array  	$result 
	 *
	 * @return     boolean	true
	 */
	public function store($result)
	{
		$output = json_encode($result, JSON_PRETTY_PRINT);
		file_put_contents( STATIC_FILE, $output . PHP_EOL );

		return true;		
	}

}