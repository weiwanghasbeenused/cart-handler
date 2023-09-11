<?php

/*
    use environment variables
    set in server block directive, read via php
    apache:
    SetEnv MYSQL_R_DATABASE_URL mysql2://user:pass@host/database
    SetEnv MYSQL_RW_DATABASE_URL mysql2://user:pass@host/database
    SetEnv MYSQL_FULL_DATABASE_URL mysql2://user:pass@host/database
    nginx:
    fastcgi_param   MYSQL_R_DATABASE_URL mysql2://user:pass@host/database;
    fastcgi_param   MYSQL_RW_DATABASE_URL mysql2://user:pass@host/database;
    fastcgi_param   MYSQL_FULL_DATABASE_URL mysql2://user:pass@host/database;
*/

$host = isset($_SERVER["HTTP_HOST"]) ? "//".$_SERVER["HTTP_HOST"]."/" : "";
$adminURLString = getenv("MYSQL_FULL_DATABASE_URL");
$readWriteURLString = getenv("MYSQL_RW_DATABASE_URL");
$readOnlyURLString = getenv("MYSQL_R_DATABASE_URL");
$media_path = $host . "media/"; // don't forget to set permissions on this folder
$mode = getenv("mode") && getenv("mode") == 'live' ? 'live' : 'sandbox';

function db_connect($remote_user) {
	global $adminURLString;
	global $readWriteURLString;
	global $readOnlyURLString;

	$users = array();
	$creds = array();

	if ($adminURLString && $readWriteURLString && $readOnlyURLString) {
		// IF YOU ARE USING ENVIRONMENTAL VARIABLES (you should)
		$urlAdmin = parse_url($adminURLString);
		$host = $urlAdmin["host"];
		$dbse = substr($urlAdmin["path"], 1);

        // full access
        $creds['full']['db_user'] = $urlAdmin["user"];
        $creds['full']['db_pass'] = $urlAdmin["pass"];

        // read / write access
        // (can't create / drop tables)
        $urlReadWrite = parse_url($readWriteURLString);
		$creds['rw']['db_user'] = $urlReadWrite["user"];
		$creds['rw']['db_pass'] = $urlReadWrite["pass"];

        // read-only access
		$urlReadOnly = parse_url($readOnlyURLString);
		$creds['r']['db_user'] = $urlReadOnly["user"];
		$creds['r']['db_pass'] = $urlReadOnly["pass"];

	} else {
		// IF YOU ARE NOT USING ENVIRONMENTAL VARIABLES
		$host = "localhost";
		$dbse = "cart_handler_local";

		// full access
		$creds['full']['db_user'] = "root";
		$creds['full']['db_pass'] = "f3f4p4ax";

		// read / write access
		// (can't create / drop tables)
		$creds['rw']['db_user'] = "root";
		$creds['rw']['db_pass'] = "f3f4p4ax";

		// read-only access
		$creds['r']['db_user'] = "root";
		$creds['r']['db_pass'] = "f3f4p4ax";
	}

	// users
	$users["admin"] = $creds['full'];
	$users["main"] = $creds['rw'];
	$users["guest"] = $creds['r'];

	$user = $users[$remote_user]['db_user'];
	$pass = $users[$remote_user]['db_pass'];

	$db = new mysqli($host, $user, $pass, $dbse);
	if($db->connect_errno)
		echo "Failed to connect to MySQL: " . $db->connect_error;
	return $db;
}

$vars = array("name", "email", "items", "subtotal", "created");

?>
