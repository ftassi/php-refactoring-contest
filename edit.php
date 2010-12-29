<?php

include_once('config.php');

if(!$_GET['id'])
{
 die('Some error occured!!');
}

$db = @mysql_connect($database['host'], $database['username'], $database['password']) or die('Can\'t connect do database');
@mysql_select_db($database['name']) or die('The database selected does not exists');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $errors = validate(array('id', 'firstname', 'lastname', 'phone'), $_POST);
  
  if(count($errors) == 0)
  {
    $query = sprintf("UPDATE contacts set firstname = '%s', 
                                                                          lastname = '%s',
                                                                          phone = '%s', 
                                                                          mobile = '%s' WHERE id = %s",
                       mysql_real_escape_string($_POST['firstname']),
                       mysql_real_escape_string($_POST['lastname']),
                       mysql_real_escape_string($_POST['phone']),
                       mysql_real_escape_string($_POST['mobile']),
                       mysql_real_escape_string($_POST['id'])
                      );
    
    $rs = mysql_query($query);
    
    if (!$rs)
    {
      die_with_error(mysql_error(), $query);
    }
    
    header('Location: index.php');
  }
}
else 
{
  $query = sprintf('SELECT * FROM contacts WHERE id = %s', mysql_real_escape_string($_GET['id']));
  
  $rs = mysql_query($query);
  
  if (!$rs)
  {
    die_with_error(mysql_error(), $query);
  }
  
  $row = mysql_fetch_assoc($rs);
  
  $_POST['id'] = $row['id'];
  $_POST['firstname'] = $row['firstname'];
  $_POST['lastname'] = $row['lastname'];
  $_POST['phone'] = $row['phone'];
  $_POST['mobile'] = $row['mobile'];
}

mysql_close($db);

?>

<?php include_once('header.php') ?>

<?php include_once('_form.php') ?>

<?php include_once('footer.php') ?>