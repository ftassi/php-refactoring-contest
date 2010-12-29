<?php

include_once('config.php');

if(!$_GET['id'])
{
 die('Some error occured!!');
}

$form = new ContactForm();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$form->bind($_POST);
	$form->setValidators(array('id', 'firstname', 'lastname', 'phone'));
  if($form->isValid())
  {
  	$sql = "UPDATE contacts set firstname = '%s',lastname = '%s',phone = '%s',mobile = '%s' WHERE id = %s";
  	$db->execute($sql, $form['firstname'], $form['lastname'], $form['phone'],$form['mobile'],$form['id']);
    header('Location: index.php');
  }
}
else 
{
  $rs = $db->query('SELECT * FROM contacts WHERE id = %d', $_GET['id']);
  $form->bind($rs[0]);
}
?>

<?php include_once('header.php') ?>

<?php include_once('_form.php') ?>

<?php include_once('footer.php') ?>