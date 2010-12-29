<?php

include_once('config.php');

if(!$_GET['id'])
{
 die('Some error occured!!');
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $errors = validate(array('id', 'firstname', 'lastname', 'phone'), $_POST);
  
  if(count($errors) == 0)
  {
  	$sql = "UPDATE contacts set firstname = '%s',lastname = '%s',phone = '%s',mobile = '%s' WHERE id = %s";
  	$db->execute($sql, $_POST['firstname'], $_POST['lastname'], $_POST['phone'],$_POST['mobile'],$_POST['id']);
    header('Location: index.php');
  }
}
else 
{
  $rs = $db->query('SELECT * FROM contacts WHERE id = %d', $_GET['id']);
	$rs->rewind();
	$row = $rs->current();  
  $_POST['id'] = $row['id'];
  $_POST['firstname'] = $row['firstname'];
  $_POST['lastname'] = $row['lastname'];
  $_POST['phone'] = $row['phone'];
  $_POST['mobile'] = $row['mobile'];
}
?>

<?php include_once('header.php') ?>

<?php include_once('_form.php') ?>

<?php include_once('footer.php') ?>