<?php
error_reporting(0);
require_once('functions.php');

$database['host'] = 'localhost';
$database['username'] = 'legacy_code';
$database['password'] = 'legacy_code';
$database['name'] = 'contacts';

$db = @mysql_connect($database['host'], $database['username'], $database['password']) or die('Can\'t connect do database');
@mysql_select_db($database['name']) or die('The database selected does not exists');
?>