<form method="post">

<?php if (!$form->isValid()) : ?>
  <ul class="errors">
  <?php foreach ($form->getErrors() as $error) : ?>
    <li><?php echo $error ?></li>
  <?php endforeach;?>
  </ul>
<?php endif ?>

<input type="hidden" name="id" value="<?php echo $form['id']?>" />

<label for="firstname">First Name*</label>
<input type="text" id="firstname" name="firstname" value="<?php echo $form['firstname'] ?>" />

<label for="lastname">Last Name*</label>
<input type="text" id="lastname" name="lastname" value="<?php echo $form['lastname'] ?>" />

<label for="phone">Phone*</label>
<input type="text" id="phone" name="phone" value="<?php echo $form['phone'] ?>" />

<label for="mobile">Mobile</label>
<input type="text" id="mobile" name="mobile" value="<?php echo $form['mobile'] ?>" />

<br/><br/>
<input type="submit" value="Save" />
<a href="index.php" >Cancel</a>
</form>
<em>(* Mandatory fields)</em>