<?php
if (isset($msg) && strlen($msg)) {
  echo(htmlspecialchars($msg));
}
if (isset($msgList)) {
?>
<ul>
  <?php foreach ($msgList as $msgItem) { ?>
    <li><?php echo(htmlspecialchars($msgItem)); ?></li>
  <?php } ?>
</ul>
<?php } ?>

