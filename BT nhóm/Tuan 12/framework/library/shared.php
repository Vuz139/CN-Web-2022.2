<?php

/** Check if environment is development and display errors **/

function setReporting() {
if (DEVELOPMENT_ENVIRONMENT == true) {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
} else {
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
}
}

/** Check for Magic Quotes and remove them **/

function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

function removeMagicQuotes() {
if (0) {
	$_GET = stripSlashesDeep($_GET);
	$_POST = stripSlashesDeep($_POST);
	$_COOKIE = stripSlashesDeep($_COOKIE);
}
}

/** Check register globals and remove them **/

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Secondary Call Function **/

function performAction($controller,$action,$queryString = null,$render = 0) {
	
	$controllerName = ucfirst($controller).'Controller';
	$dispatch = new $controllerName($controller,$action);
	$dispatch->render = $render;
	return call_user_func_array(array($dispatch,$action),$queryString);
}

/** Routing **/

function routeURL($url) {
	global $routing;

	foreach ( $routing as $pattern => $result ) {
            if ( preg_match( $pattern, $url ) ) {
				return preg_replace( $pattern, $result, $url );
			}
	}

	return ($url);
}

/** Main Call Function **/

function callHook() {
	global $url;
	global $default;

	$queryString = array();

	if (!isset($url)) {
		$controller = $default['controller'];
		$action = $default['action'];
	} else {
		$url = routeURL($url);
		$urlArray = array();
		$urlArray = explode("/",$url);
		$controller = $urlArray[0];
		array_shift($urlArray);
		if (isset($urlArray[0])) {
			$action = $urlArray[0];
			array_shift($urlArray);
		} else {
			$action = 'index'; // Default Action
		}
		$queryString = $urlArray;
	}
	
	$controllerName = ucfirst($controller).'Controller';

	$dispatch = new $controllerName($controller,$action);
	
	if ((int)method_exists($controllerName, $action)) {
		call_user_func_array(array($dispatch,"beforeAction"),$queryString);
		call_user_func_array(array($dispatch,$action),$queryString);
		call_user_func_array(array($dispatch,"afterAction"),$queryString);
	} else {
		/* Error Generation Code Here */
	}
}


/** Autoload any classes that are required **/

function myAutoLoad($className) {
    if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
    } else {
        // Error
    }
}


/** GZip Output **/

function gzipOutput() {
    $ua = $_SERVER['HTTP_USER_AGENT'];

    if (0 !== strpos($ua, 'Mozilla/4.0 (compatible; MSIE ')
        || false !== strpos($ua, 'Opera')) {
        return false;
    }

    $version = (float)substr($ua, 30); 
    return (
        $version < 6
        || ($version == 6  && false === strpos($ua, 'SV1'))
    );
}

/** Get Required Files **/

gzipOutput() || ob_start("ob_gzhandler");
// gzipOutput();


$cache = new Cache();
$inflect = new Inflection();

spl_autoload_register('myAutoLoad');
setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();


class Cache {
	function get($fileName) {
		$fileName = ROOT.DS.'tmp'.DS.'cache'.DS.$fileName;
		if (file_exists($fileName)) {
			$handle = fopen($fileName, 'rb');
			$variable = fread($handle, filesize($fileName));
			fclose($handle);
			return unserialize($variable);
		} else {
			return null;
		}
	}
	
	function set($fileName,$variable) {
		$fileName = ROOT.DS.'tmp'.DS.'cache'.DS.$fileName;
		$handle = fopen($fileName, 'a');
		fwrite($handle, serialize($variable));
		fclose($handle);
	}

}

class Inflection
{
    static $plural = array(
        '/(quiz)$/i'               => "$1zes",
        '/^(ox)$/i'                => "$1en",
        '/([m|l])ouse$/i'          => "$1ice",
        '/(matr|vert|ind)ix|ex$/i' => "$1ices",
        '/(x|ch|ss|sh)$/i'         => "$1es",
        '/([^aeiouy]|qu)y$/i'      => "$1ies",
        '/(hive)$/i'               => "$1s",
        '/(?:([^f])fe|([lr])f)$/i' => "$1$2ves",
        '/(shea|lea|loa|thie)f$/i' => "$1ves",
        '/sis$/i'                  => "ses",
        '/([ti])um$/i'             => "$1a",
        '/(tomat|potat|ech|her|vet)o$/i'=> "$1oes",
        '/(bu)s$/i'                => "$1ses",
        '/(alias)$/i'              => "$1es",
        '/(octop)us$/i'            => "$1i",
        '/(ax|test)is$/i'          => "$1es",
        '/(us)$/i'                 => "$1es",
        '/s$/i'                    => "s",
        '/$/'                      => "s"
    );

    static $singular = array(
        '/(quiz)zes$/i'             => "$1",
        '/(matr)ices$/i'            => "$1ix",
        '/(vert|ind)ices$/i'        => "$1ex",
        '/^(ox)en$/i'               => "$1",
        '/(alias)es$/i'             => "$1",
        '/(octop|vir)i$/i'          => "$1us",
        '/(cris|ax|test)es$/i'      => "$1is",
        '/(shoe)s$/i'               => "$1",
        '/(o)es$/i'                 => "$1",
        '/(bus)es$/i'               => "$1",
        '/([m|l])ice$/i'            => "$1ouse",
        '/(x|ch|ss|sh)es$/i'        => "$1",
        '/(m)ovies$/i'              => "$1ovie",
        '/(s)eries$/i'              => "$1eries",
        '/([^aeiouy]|qu)ies$/i'     => "$1y",
        '/([lr])ves$/i'             => "$1f",
        '/(tive)s$/i'               => "$1",
        '/(hive)s$/i'               => "$1",
        '/(li|wi|kni)ves$/i'        => "$1fe",
        '/(shea|loa|lea|thie)ves$/i'=> "$1f",
        '/(^analy)ses$/i'           => "$1sis",
        '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i'  => "$1$2sis",
        '/([ti])a$/i'               => "$1um",
        '/(n)ews$/i'                => "$1ews",
        '/(h|bl)ouses$/i'           => "$1ouse",
        '/(corpse)s$/i'             => "$1",
        '/(us)es$/i'                => "$1",
        '/s$/i'                     => ""
    );

    static $irregular = array(
        'move'   => 'moves',
        'foot'   => 'feet',
        'goose'  => 'geese',
        'sex'    => 'sexes',
        'child'  => 'children',
        'man'    => 'men',
        'tooth'  => 'teeth',
        'person' => 'people',
        'admin' => 'admin'
    );

    static $uncountable = array(
        'sheep',
        'fish',
        'deer',
        'series',
        'species',
        'money',
        'rice',
        'information',
        'equipment'
    );

    public static function pluralize( $string )
    {
		global $irregularWords;
		
		// save some time in the case that singular and plural are the same
        if ( in_array( strtolower( $string ), self::$uncountable ) )
            return $string;

        // check for irregular singular forms
        foreach ( $irregularWords as $pattern => $result )
        {
            $pattern = '/' . $pattern . '$/i';

            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string);
        }

        // check for irregular singular forms
        foreach ( self::$irregular as $pattern => $result )
        {
            $pattern = '/' . $pattern . '$/i';

            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string);
        }

        // check for matches using regular expressions
        foreach ( self::$plural as $pattern => $result )
        {
            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string );
        }

        return $string;
    }

    public static function singularize( $string )
    {	
		global $irregularWords;
        // save some time in the case that singular and plural are the same
        if ( in_array( strtolower( $string ), self::$uncountable ) )
            return $string;

	    // check for irregular words
        foreach ( $irregularWords as $result => $pattern )
        {
            $pattern = '/' . $pattern . '$/i';

            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string);
        }
		
		// check for irregular plural forms
        foreach ( self::$irregular as $result => $pattern )
        {
            $pattern = '/' . $pattern . '$/i';

            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string);
        }

	    // check for matches using regular expressions
        foreach ( self::$singular as $pattern => $result )
        {
            if ( preg_match( $pattern, $string ) )
                return preg_replace( $pattern, $result, $string );
        }

        return $string;
    }

    public static function pluralize_if($count, $string)
    {
        if ($count == 1)
            return "1 $string";
        else
            return $count . " " . self::pluralize($string);
    }
}

?>