<?php
include_once('config.php');

$db = @mysql_connect($database['host'], $database['username'], $database['password']) or die('Can\'t connect do database');
@mysql_select_db($database['name']) or die('The database selected does not exists');

$query = 'SELECT * FROM contacts ORDER BY lastname';
$rs = mysql_query($query);

if (!$rs)
{
  die_with_error(mysql_error(), $query);
}

$num = mysql_num_rows($rs);

?>

<?php include_once('header.php') ?>

<div class="actions">
  <a href="new.php">New contact</a>
 </div>
 
<?php if ($num) : ?>
  <table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th>Last Name</th>
    <th>First Name</th>
    <th>Phone</th>
    <th>Mobile</th>
    <th>&nbsp;</th>
  </tr>
  <?php while($row = mysql_fetch_assoc($rs)) :?>
    <tr>
      <td><a href="edit.php?id=<?php echo $row['id']?>" title="Modifica"><?php echo $row['lastname']?></a></td>
      <td><?php echo $row['firstname']?></a></td>
      <td><a href="callto://<?php echo $row['phone']?>"><?php echo $row['phone']?></a></td>
      <td><a href="callto://<?php echo $row['mobile']?>"><?php echo $row['mobile']?></a></td>
      <td>[<a href="remove.php?id=<?php echo $row['id']?>" title="Elimina" onclick="if (confirm('Are you sure?')) {return true;} return false;">X</a>]</td>
    </tr>
  <?php endwhile;?>
  </table>

 <?php else: ?>
  Database is empty
<?php endif ?>

<?php include_once('footer.php') ?>

<?php
  mysql_free_result($rs);
  mysql_close($db);
?>