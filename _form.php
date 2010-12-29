<form method="post">

<?php if (isset($errors) and count($errors)) : ?>
  <ul class="errors">
  <?php foreach ($errors as $error) : ?>
    <li><?php echo $error ?></li>
  <?php endforeach;?>
  </ul>
<?php endif ?>

<input type="hidden" name="id" value="<?php echo $_POST['id']?>" />

<label for="firstname">First Name*</label>
<input type="text" id="firstname" name="firstname" value="<?php echo $_POST['firstname'] ?>" />

<label for="lastname">Last Name*</label>
<input type="text" id="lastname" name="lastname" value="<?php echo $_POST['lastname'] ?>" />

<label for="phone">Phone*</label>
<input type="text" id="phone" name="phone" value="<?php echo $_POST['phone'] ?>" />

<label for="mobile">Mobile</label>
<input type="text" id="mobile" name="mobile" value="<?php echo $_POST['mobile'] ?>" />

<br/><br/>
<input type="submit" value="Save" />
<a href="index.php" >Cancel</a>
</form>
<em>(* Mandatory fields)</em>