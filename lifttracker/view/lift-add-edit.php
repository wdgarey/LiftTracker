<?php
  require_once("../includes/header.php");
?>

<?php if (isset($liftId)) { ?>
      <h1>Edit Lift</h1>
<?php } else { ?>
      <h1>Create Lift</h1>
<?php } ?>
<?php
  include("../includes/message.php");
?>
      <form class="form-signin" method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftprocessaddedit"); ?>">
<?php if (isset($liftId)) { ?>
        <input type="hidden" name="liftid" value="<?php echo(htmlspecialchars($liftId)); ?>" class="form-control" />
<?php } ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-4">
            <input type="text" name="title" value="<?php echo(htmlspecialchars($name)); ?>" class="form-control" placeholder="Name of lift" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Training Weight</label>
          <div class="col-sm-4">
            <input type="number" name="trainingweight" value="<?php echo(htmlspecialchars($weight)); ?>" class="form-control" placeholder="180" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6">
            <button class="col-sm-2 btn btn-primary pull-right" type="submit">
<?php if (isset($liftId)) { ?>
              Update
<?php } else { ?>
              Add 
<?php } ?>
            </button>
          </div>
        </div>
      </form>
<?php
  require_once("../includes/footer.php");
?>

