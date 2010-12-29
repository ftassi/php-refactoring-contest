<?php
include_once('config.php');
$contacts = new Recordset(mysql_query('SELECT * FROM contacts ORDER BY lastname'));
?>

<?php include_once('header.php') ?>

<div class="actions">
  <a href="new.php">New contact</a>
 </div>
 
<?php if (count($contacts)) : ?>
  <table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th>Last Name</th>
    <th>First Name</th>
    <th>Phone</th>
    <th>Mobile</th>
    <th>&nbsp;</th>
  </tr>
  <?php foreach ($contacts as $contact):?>
    <tr>
      <td><a href="edit.php?id=<?php echo $contact['id']?>" title="Modifica"><?php echo $contact['lastname']?></a></td>
      <td><?php echo $contact['firstname']?></a></td>
      <td><a href="callto://<?php echo $contact['phone']?>"><?php echo $contact['phone']?></a></td>
      <td><a href="callto://<?php echo $contact['mobile']?>"><?php echo $contact['mobile']?></a></td>
      <td>[<a href="remove.php?id=<?php echo $contact['id']?>" title="Elimina" onclick="if (confirm('Are you sure?')) {return true;} return false;">X</a>]</td>
    </tr>
  <?php endforeach;?>
  </table>

 <?php else: ?>
  Database is empty
<?php endif ?>

<?php include_once('footer.php') ?>