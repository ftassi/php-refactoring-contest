<?php
include_once('config.php');
try
{
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
}
catch(MySqlException $e)
{
	die($e->getMessage());
}
catch(Exception $e)
{
	die('Some error occured!!');
}
?>
<?php ob_start();?>
<?php require_once('_form.php') ?>
<?php $content = ob_get_clean();?>

<?php require_once('layout.php') ?>