<?php
error_reporting(0);
require_once('functions.php');
require_once 'lib/Recordset.class.php';
require_once 'lib/DatabaseConnection.class.php';
$database['host'] = 'localhost';
$database['username'] = 'legacy_code';
$database['password'] = 'legacy_code';
$database['name'] = 'contacts';

$db = new DatabaseConnection($database['host'], $database['username'], $database['password'],$database['name']);
$db->connect();
?>