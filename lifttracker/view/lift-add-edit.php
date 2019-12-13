<?php
  require_once("../includes/header.php");
?>
    <div class="container">
<?php if (isset($liftId)) { ?>
      <h1>Edit Lift</h1>
      <hr />
<?php } else { ?>
      <h1>Add Lift</h1>
      <hr />
<?php } ?>
<?php
  include("../includes/message.php");
?>
      <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftprocessaddedit"); ?>">
<?php if (isset($liftId)) { ?>
        <input type="hidden" name="liftid" value="<?php echo(htmlspecialchars($liftId)); ?>" class="form-control" />
<?php } ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-4">
            <input type="text" name="title" value="<?php echo(htmlspecialchars($title)); ?>" class="form-control" placeholder="Name of lift" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label">Training Weight</label>
          <div class="col-sm-2">
            <input type="number" name="trainingweight" value="<?php echo(htmlspecialchars($trainingWeight)); ?>" class="form-control" placeholder="180" required autofocus />
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6">
            <button class="col-sm-2 btn btn-primary pull-left" type="submit">
<?php if (isset($liftId)) { ?>
              Update
<?php } else { ?>
              Add 
<?php } ?>
            </button>
          </div>
        </div>
      </form>
    </div>
<?php
  require_once("../includes/footer.php");
?>

