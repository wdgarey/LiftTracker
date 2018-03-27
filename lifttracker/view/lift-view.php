<?php
  require_once("../includes/header.php");
?>
    <div class="container">
      <h1>View Lift</h1>
      <hr />
<?php
  include("../includes/message.php");
?>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" value="<?php echo(htmlspecialchars($title)); ?>" readonly />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">Training Weight</label>
        <div class="col-sm-2">
          <input class="form-control" type="text" value="<?php echo(htmlspecialchars($trainingWeight)); ?>" readonly />
        </div>
      </div>
      <div class="form-group row">
        <div class="col-sm-6">
          <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftdelete"); ?>">
            <input type="hidden" name="liftid" value="<?php echo(htmlspecialchars($liftId)); ?>" class="form-control" />
            <button class="col-sm-2 btn btn-primary pull-right" data-toggle="confirmation" type="submit">Delete</button>
          </form>
          <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftedit"); ?>">
            <input type="hidden" name="liftid" value="<?php echo(htmlspecialchars($liftId)); ?>" class="form-control" />
            <button class="col-sm-2 btn btn-primary pull-right" type="submit">Edit</button>
          </form>
          <form method="POST" action="<?php echo("../main/index.php?controller=lift&action=liftsview"); ?>">
            <button class="col-sm-2 btn btn-primary pull-right" type="submit">Lifts</button>
          </form>
        </div>
      </div>
    </div>
<?php
  require_once("../includes/footer.php");
?>

