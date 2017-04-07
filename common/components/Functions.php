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


	/**
	 * Time Elapsed
	 *
	 * @param      integer  $time   tipe data time berupa integer 
	 * 
	 * @example :
	 * ```
	 * $time = strtotime('2017-01-01 10:10:00');
	 * $result = /common/components/Functions::timeElapsed($time);	
	 * ```
	 *
	 * @return     string
	 */
	public static function timeElapsed ( $time )
	{

	    $time = time() - $time; // to get the time since that moment
	    $time = ($time<1)? 1 : $time;
	    $tokens = array (
	        31536000 => 'tahun',
	        2592000 => 'bulan',
	        604800 => 'minggu',
	        86400 => 'hari',
	        3600 => 'jam',
	        60 => 'menit',
	        1 => 'detik'
	    );

	    foreach ($tokens as $unit => $text) {
	        if ($time < $unit) continue;
	        $numberOfUnits = floor($time / $unit);
	        return $numberOfUnits.' '.$text . ' lalu';
	    }

	}

	/**
	 * Gets the browser.
	 * 
	 * @return     array  The browser.
	 * 
	 * @copyright 	http://php.net/manual/en/function.get-browser.php#101125
	 */
	public static function getBrowser() 
	{ 
	    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
	    $bname = 'Unknown';
	    $platform = 'Unknown';
	    $version= "1";

	    //First get the platform?
	    if (preg_match('/linux/i', $u_agent)) {
	        $platform = 'Linux';
	    }
	    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
	        $platform = 'Mac';
	    }
	    elseif (preg_match('/windows|win32/i', $u_agent)) {
	        $platform = 'Windows';
	    }

	    // Next get the name of the useragent yes seperately and for good reason
	    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
	    { 
	        $bname = 'Internet Explorer'; 
	        $ub = "MSIE"; 
	    } 
	    elseif(preg_match('/Firefox/i',$u_agent)) 
	    { 
	        $bname = 'Mozilla Firefox'; 
	        $ub = "Firefox"; 
	    } 
	    elseif(preg_match('/Chrome/i',$u_agent)) 
	    { 
	        $bname = 'Google Chrome'; 
	        $ub = "Chrome"; 
	    } 
	    elseif(preg_match('/Safari/i',$u_agent)) 
	    { 
	        $bname = 'Apple Safari'; 
	        $ub = "Safari"; 
	    } 
	    elseif(preg_match('/Opera/i',$u_agent)) 
	    { 
	        $bname = 'Opera'; 
	        $ub = "Opera"; 
	    } 
	    elseif(preg_match('/Netscape/i',$u_agent)) 
	    { 
	        $bname = 'Netscape'; 
	        $ub = "Netscape"; 
	    } 

	    // finally get the correct version number
	    $known = array('Version', $ub, 'other');
	    $pattern = '#(?<browser>' . join('|', $known) .
	    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
	    if (!preg_match_all($pattern, $u_agent, $matches)) {
	        // we have no matching number just continue
	    }

	    // see how many we have
	    $i = count($matches['browser']);
	    if ($i != 1) {
	        //we will have two since we are not using 'other' argument yet
	        //see if version is before or after the name
	        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
	            $version= $matches['version'][0];
	        }
	        else {
	            $version= $matches['version'][1];
	        }
	    }
	    else {
	        $version= $matches['version'][0];
	    }

	    // check if we have a number
	    if ($version==null || $version=="") {$version="?";}

	    return array(
	        'userAgent' => $u_agent,
	        'name'      => $bname,
	        'version'   => $version,
	        'platform'  => $platform,
	        'pattern'    => $pattern
	    );
	}
}