<?php
require_once('config.php');
try
{
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