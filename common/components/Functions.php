<?php

namespace common\components;

use yii\base\Component;
use Yii;

/**
 * Functions of necessary
 * 
 * @author yanuar nurcahyo <yanuarxnurcahyo@gmail.com>
 * @since  Januari 2017
 */
class Functions extends Component {

	/**
	 * Makes a slug.
	 *
	 * @param      <type>     $string     The string
	 * @param      array      $replace    The replace
	 * @param      string     $delimiter  The delimiter
	 *
	 * @throws     Exception  (description)
	 *           
	 * @return     string     ( description_of_the_return_value )
	 * 
	 * @copyright https://gist.github.com/james2doyle/9158349
	 */
	public static function makeSlug ($string, $replace = array(), $delimiter = '_') {
	  
	  	if (!extension_loaded('iconv')) {
			throw new Exception('iconv module not loaded');
	  	}
	  
		// Save the old locale and set the new locale to UTF-8
		$oldLocale = setlocale(LC_ALL, '0');
		setlocale(LC_ALL, 'en_US.UTF-8');
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

		if (!empty($replace)) {
			$clean = str_replace((array) $replace, ' ', $clean);
		}

		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower($clean);
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		$clean = trim($clean, $delimiter);
		
		// Revert back to the old locale
		setlocale(LC_ALL, $oldLocale);
		return $clean;
	}


	/**
	 * Removes a dir.
	 * function ini untuk menghapus directory bersama recursive/turunannya
	 * 
	 * @param      string  $dir    Directory
	 * @return true
	 */
	public static function removeDir($dir) 
	{ 
	   	if (is_dir($dir)) 
	   	{ 

			$objects = scandir($dir); 
			foreach ($objects as $object) { 
				if ($object != "." && $object != "..") 
				{ 
					if (is_dir($dir."/".$object))
						rrmdir($dir."/".$object);
					else
						unlink($dir."/".$object); 
				} 
			}
	     	rmdir($dir);

	   	} 

	   	return true;
	}
}