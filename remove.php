<?php
include_once('config.php');

if(!$_GET['id'])
{
 die('Some error occured!!');
}
$db->execute('DELETE FROM contacts where ID = %s', $_GET['id']);
header('Location: index.php');

?>