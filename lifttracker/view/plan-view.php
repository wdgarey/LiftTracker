<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>View Plan</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Title:</label>
        <span class="col-sm-2"><?php echo(htmlspecialchars($title)); ?></span>
      </div>
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=plan&action=planedit&planid=<?php echo(htmlspecialchars($planId)); ?>">Edit Plan</a>
        <a class="btn btn-primary" data-toggle="confirmation" href="../main/index.php?controller=plan&action=plandelete&planid=<?php echo(htmlspecialchars($planId)); ?>">Delete Plan</a>
      </div>
<?php if (count($weeks) == 0) { ?>
      <h2>No weeks yet? Add one <a href="../main/index.php?controller=week&action=weekadd&planid=<?php echo(htmlspecialchars($planId)); ?>">here</a>.</h2>
<?php } else {?>
      <h2>Weeks</h2>
      <hr />
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=week&action=weekadd&planid=<?php echo(htmlspecialchars($planId)); ?>">Add Week</a>
      </div>
  <?php foreach ($weeks as $week) { ?>
      <div class="form-group row">
        <label class="col-sm-1 col-form-label">Title:</label>
        <span class="col-sm-2"><?php echo(htmlspecialchars($week->getTitle())); ?></span>
      </div>
      <div class="form-group row">
        <a class="btn btn-primary" href="../main/index.php?controller=week&action=weekedit&weekid=<?php echo(htmlspecialchars($week->getId())); ?>">Edit Week</a>
        <a class="btn btn-primary" data-toggle="confirmation" href="../main/index.php?controller=week&action=weekdelete&weekid=<?php echo(htmlspecialchars($week->getId())); ?>">Delete Week</a>
      </div>
  <?php } ?>
<?php } ?>
    </div>
<?php
  require_once("../includes/footer.php");
?>

