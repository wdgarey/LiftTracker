<?php
  require_once("../includes/header.php");
?>
      <h1>View Lifts</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
<?php if (count($lifts) == 0) { ?>
      <h2>No lifts yet? Add one <a href="../main/index.php?controller=lift&action=liftadd">here</a>.</h2>
<?php } else {?>
        <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftadd"); ?>">
          <div class="form-group row">
            <button class="col-sm-1 btn btn-primary" type="submit">Add Lift</button>
          </div>
        </form>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Name</label>
          <label class="col-sm-2 col-form-label">Training Weight</label>
        </div>
  <?php foreach ($lifts as $lift) { ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"><?php echo(htmlspecialchars($lift->getTitle())); ?></label>
          <label class="col-sm-2 col-form-label"><?php echo(htmlspecialchars($lift->getTrainingWeight())); ?></label>
          <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftedit"); ?>">
            <input type="hidden" name="liftid" value="<?php echo(htmlspecialchars($lift->getId())); ?>" class="form-control" />
            <button class="col-sm-1 btn btn-primary" type="submit">Edit</button>
          </form>
        </div>
  <?php } ?>
<?php } ?>
<?php
  require_once("../includes/footer.php");
?>

