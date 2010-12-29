<?php
include_once('config.php');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $errors = validate(array('firstname', 'lastname', 'phone'), $_POST);
  
  if(count($errors) == 0)
  {
    $db = @mysql_connect($database['host'], $database['username'], $database['password']) or die('Can\'t connect do database');
    @mysql_select_db($database['name']) or die('The database selected does not exists');

    $query = sprintf("INSERT INTO contacts (firstname, lastname, phone, mobile) VALUES ('%s', '%s', '%s', '%s')",
                       mysql_real_escape_string($_POST['firstname']),
                       mysql_real_escape_string($_POST['lastname']),
                       mysql_real_escape_string($_POST['phone']),
                       mysql_real_escape_string($_POST['mobile'])
                      );
    
    $rs = mysql_query($query);
    
    if (!$rs)
    {
      die_with_error(mysql_error(), $query);
    }
    
    mysql_close($db);
    
    header('Location: index.php');
    
  }
}
?>

<?php include_once('header.php') ?>

<?php include_once('_form.php') ?>

<?php include_once('footer.php') ?>