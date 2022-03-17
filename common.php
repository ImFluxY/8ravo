<?php

// PHP 8 /*
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});
// PHP 8 */

session_start();
if (isset($_SESSION['user']))
	$user=$_SESSION['user'];
else
	$user=null;

define ('SITE_ROOT', realpath(dirname(__FILE__)));

define ('BASE', 'mmi2pj_03');
define ('USERNAME', 'mmi2pj03');
define ('PASSWORD', 'uu7ohJ9ieg');

define ('LARGMAX_IMG', 1500);
define ('HAUTMAX_IMG', 600);
define ('LARGMAX_VIGN', 300);
define ('HAUTMAX_VIGN', 120);


function postParamsPresents($paramNames)
{
	foreach ($paramNames as $paramName)
		if (!isset($_POST[$paramName]))
			return false;
	return true;
}

function error ($message, $destination)
{
	$_SESSION['erreur'] = $message;
	header("Location: ".$destination);
	exit();
}

function success ($message, $destination)
{
	$_SESSION['success'] = $message;
	header("Location:".$destination);
	exit();
}

function getTypeName($type)
{
	$returnValue = "";

		switch ($type) {
			case 0:
				$returnValue = "Membre";
				break;
			case 1:
				$returnValue = "Créateur";
				break;
			case 2:
				$returnValue = "Administrateur";
				break;
		}

		return $returnValue;
}

function console_log( $data ){
	echo '<script>';
	echo 'console.log('. json_encode( $data ) .')';
	echo '</script>';
}
