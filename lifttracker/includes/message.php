<?php if (isset($msg) && strlen($msg)) { ?>
  <div class="center-block text-center text-danger">
    <h2>
      <?php echo(htmlspecialchars($msg)); ?>
    </h2>
    <?php if (isset($msgList)) { ?>
      <ul>
        <?php foreach ($msgList as $msgItem) { ?>
          <li><h3><?php echo(htmlspecialchars($msgItem)); ?></h3></li>
        <?php } ?>
      </ul>
    <?php } ?>
  </div>
<?php } ?>
