<?php
include_once('config.php');

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $errors = validate(array('firstname', 'lastname', 'phone'), $_POST);
  
  if(count($errors) == 0)
  {
		$sql = "INSERT INTO contacts (firstname, lastname, phone, mobile) VALUES ('%s', '%s', '%s', '%s')";
		$db->execute($sql, $_POST['firstname'], $_POST['lastname'], $_POST['phone'], $_POST['mobile']);
    header('Location: index.php');
    
  }
}
?>

<?php include_once('header.php') ?>

<?php include_once('_form.php') ?>

<?php include_once('footer.php') ?>