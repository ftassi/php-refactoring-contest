<?php
require_once('config.php');
try 
{
	$db->execute('DELETE FROM contacts where ID = %s', $_GET['id']);
	header('Location: index.php');
}
catch(Exception $e)
{
 die('Some error occured!!');
}

?>