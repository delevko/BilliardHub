<?php

function adminCheck()
{
	if( isset($_SESSION["id"]) )
	{
		if($_SESSION["id"]["type"] == "admin")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
		return false;
}


function userCheck()
{
	if( isset($_SESSION["id"]) )
	{
		if($_SESSION["id"]["type"] == "regular")
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
		return false;
}


function logout()
{
	$_SESSION = [];

	if(!empty($_COOKIE[session_name()]))
	{
		setcookie(session_name(), "", time()-42000);
	}

	session_destroy();
}

function redirect($destination)
{
	//$destination = HOME_DIR . $destination;
	// handle URL
	if (preg_match("/^https?:\/\//", $destination))
	{
		header("Location: " . $destination);
	}

	// handle absolute path
	else if (preg_match("/^\//", $destination))
	{
		$protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
		$host = $_SERVER["HTTP_HOST"];
		header("Location: $protocol://$host$destination");
	}

	// handle relative path
	else
	{
		// adapted from http://www.php.net/header
		$protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
		$host = $_SERVER["HTTP_HOST"];
		$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		header("Location: $protocol://$host$path/$destination");
	}

	// exit immediately since we're redirecting anyway
	exit;
}


?>
