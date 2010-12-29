<?php
include_once('config.php');

if(!$_GET['id'])
{
 die('Some error occured!!');
}

$query = sprintf('DELETE FROM contacts where ID = %s',
                 mysql_real_escape_string($_GET['id']));
                 
if(!mysql_query($query))
{
  die_with_error(mysql_error(), $query);
}

mysql_close($db);

header('Location: index.php');

?>