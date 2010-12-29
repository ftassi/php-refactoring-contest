<?php
include_once('config.php');

$form = new ContactForm();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$form->bind($_POST);
	$form->setValidators(array('firstname', 'lastname', 'phone'));	
	if($form->isValid())
  {
		$sql = "INSERT INTO contacts (firstname, lastname, phone, mobile) VALUES ('%s', '%s', '%s', '%s')";
		$db->execute($sql, $form['firstname'], $form['lastname'], $form['phone'], $form['mobile']);
    header('Location: index.php');
    
  }
}
?>

<?php include_once('header.php') ?>

<?php include_once('_form.php') ?>

<?php include_once('footer.php') ?>